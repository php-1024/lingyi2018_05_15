<?php

namespace App\Http\Controllers\Zerone;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountInfo;
use App\Models\AccountNode;
use App\Models\OperationLog;
use App\Models\Organization;
use App\Models\OrganizationAgentinfo;
use App\Models\OrganizationAssets;
use App\Models\OrganizationAssetsallocation;
use App\Models\Program;
use App\Models\WarzoneAgent;
use App\Services\ZeroneRedis\Check;
use Illuminate\Http\Request;
use App\Models\OrganizationAgentapply;
use App\Models\Warzone;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Session;

class AgentController extends Controller
{
    /**
     * 代理审核列表
     */
    public function agent_examinelist(Request $request)
    {
        // 中间件产生的管理员数据参数
        $admin_data = $request->get('admin_data');
        // 中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');
        // 中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');
        // 获取当前的页面路由
        $route_name = $request->path();
        // 代理名字，页面搜索用
        $agent_name = $request->input('agent_name');
        // 手机号码，页面搜索用
        $agent_owner_mobile = $request->input('agent_owner_mobile');
        // 用于分页和输入框value值
        $search_data = ['agent_name' => $agent_name, 'agent_owner_mobile' => $agent_owner_mobile];
        // 数据库值查询条件
        $where = [['status', '<>', '1']];
        if (!empty($agent_name)) {
            //代理名字搜索条件
            $where[] = ['agent_name', 'like', '%' . $agent_name . '%'];
        }
        if (!empty($agent_owner_mobile)) {
            //手机搜索条件
            $where[] = ['agent_owner_mobile', $agent_owner_mobile];
        }
        //查询代理注册审核列表
        $list = OrganizationAgentapply::getPaginage($where, '15', 'id');
        return view('Zerone/Agent/agent_examinelist', ['list' => $list, 'search_data' => $search_data, 'admin_data' => $admin_data, 'route_name' => $route_name, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data]);
    }

    /**
     * 代理审核ajaxshow显示页面
     */
    public function agent_examine(Request $request)
    {
        // 代理id
        $id = $request->input('id');
        // 是否通过值 1为通过 -1为不通过
        $status = $request->input('status');
        // 获取该代理的信息
        $info = OrganizationAgentapply::getOne([['id', $id]]);
        return view('Zerone/Agent/agent_examine', ['info' => $info, 'status' => $status]);
    }

    /**
     * 代理审核数据提交
     */
    public function agent_examine_check(Request $request)
    {
        // 中间件产生的管理员数据参数
        $admin_data = $request->get('admin_data');
        // 获取当前的页面路由
        $route_name = $request->path();
        // 代理id
        $id = $request->input('id');
        // 是否通过值 1为通过 -1为不通过
        $status = $request->input('status');
        // 查询申请代理信息
        $data = OrganizationAgentapply::getOne([['id', $id]]);
        // 程序id
        if ($status == -1) {
            DB::beginTransaction();
            try {
                // 拒绝通过
                OrganizationAgentapply::editOrganizationAgentapply([['id', $id]], ['status' => $status]);
                // 添加操作日志
                OperationLog::addOperationLog('1', '1', $admin_data['id'], $route_name, '拒绝了代理：' . $data['agent_name']); //保存操作记录
                // 提交事务
                DB::commit();
            } catch (Exception $e) {
                // 事件回滚
                DB::rollBack();
                return response()->json(['data' => '拒绝失败', 'status' => '0']);
            }
            return response()->json(['data' => '拒绝成功', 'status' => '1']);
        } else {
            DB::beginTransaction();
            try {
                // 申请通过
                OrganizationAgentapply::editOrganizationAgentapply([['id', $id]], ['status' => $status]);
                // 调用方法
                $re = $this->add_agent($data);
                if ($re != 'ok') {
                    return $re;
                }
                // 添加操作日志
                OperationLog::addOperationLog('1', '1', $admin_data['id'], $route_name, '代理审核通过：' . $data['agent_name']);
                // 提交事务
                DB::commit();

            } catch (Exception $e) {
                // 事件回滚
                DB::rollBack();
                return response()->json(['data' => '审核失败', 'status' => '0']);
            }
            return response()->json(['data' => '申请通过', 'status' => '1']);
        }
    }

    /**
     * 添加代理
     */
    public function agent_add(Request $request)
    {
        // 中间件产生的管理员数据参数
        $admin_data = $request->get('admin_data');
        // 中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');
        // 中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');
        // 获取当前的页面路由
        $route_name = $request->path();
        // 查询全部战区
        $warzone_list = Warzone::all();
        return view('Zerone/Agent/agent_add', ['warzone_list' => $warzone_list, 'admin_data' => $admin_data, 'route_name' => $route_name, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data]);
    }


    /**
     * 提交代理数据
     */
    public function agent_add_check(Request $request)
    {
        // 中间件产生的管理员数据参数
        $admin_data = $request->get('admin_data');
        // 获取当前的页面路由
        $route_name = $request->path();
        // 代理名称
        $organization_name = $request->input('organization_name');
        // 根据名字查询，看是否重复
        if (Organization::checkRowExists([['organization_name', $organization_name]])) {
            return response()->json(['data' => '代理名称已存在', 'status' => '0']);
        }
        // 用户密码
        $password = $request->input('agent_password');
        // 获取加密盐
        $key = config("app.agent_encrypt_key");
        // 加密密码第一重
        $encrypted = md5($password);
        // 加密密码第二重
        $encryptPwd = md5("lingyikeji" . $encrypted . $key);

        $data = [
            // 代理名字
            'agent_name' => $organization_name,
            // 手机号码
            'agent_owner_mobile' => $request->mobile,
            // 用户密码
            'agent_password' => $encryptPwd,
            // 战区id
            'zone_id' => $request->zone_id,
            // 身份证号
            'agent_owner_idcard' => $request->idcard,
            // 负责人姓名
            'agent_owner' => $request->realname,
        ];

        DB::beginTransaction();
        try {
            // 调用方法
            $re = $this->add_agent($data);
            if ($re != 'ok') {
                return $re;
            }
            // 添加操作日志
            OperationLog::addOperationLog('1', '1', $admin_data['id'], $route_name, '添加了代理：' . $organization_name);
            // 提交事务
            DB::commit();
        } catch (Exception $e) {
            // 事件回滚
            DB::rollBack();
            return response()->json(['data' => '提交失败', 'status' => '0']);
        }
        return response()->json(['data' => '提交成功', 'status' => '1']);
    }

    /**
     * 代理列表
     */
    public function agent_list(Request $request)
    {
        // 中间件产生的管理员数据参数
        $admin_data = $request->get('admin_data');
        // 中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');
        // 中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');
        // 获取当前的页面路由
        $route_name = $request->path();
        // 代理名称
        $organization_name = $request->input('organization_name');
        // 前端分页和搜索使用
        $search_data = ['organization_name' => $organization_name];
        // 查询条件，type等于2 为代理
        $where = [['type', '2']];
        // 根据名字搜索
        if (!empty($organization_name)) {
            $where[] = ['organization_name', 'like', '%' . $organization_name . '%'];
        }
        // 查询代理列表
        $listorg = Organization::getPaginage($where, '10', 'id');
        foreach ($listorg as $k => $v) {
            // 战区id
            $zone_id = $v['warzoneAgent']['zone_id'];
            // 查询战区名字
            $listorg[$k]['zone_name'] = Warzone::where([['id', $zone_id]])->pluck('zone_name')->first();
        }
        return view('Zerone/Agent/agent_list', ['search_data' => $search_data, 'listorg' => $listorg, 'admin_data' => $admin_data, 'route_name' => $route_name, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data]);
    }

    /**
     * 代理编辑ajaxshow显示页面
     */
    public function agent_list_edit(Request $request)
    {
        // 代理id
        $id = $request->input('id');
        // 代理详细信息
        $listorg = Organization::getOneagent([['id', $id]]);
        // 查询所有战区
        $warzone = Warzone::all();
        return view('Zerone/Agent/agent_list_edit', ['listorg' => $listorg, 'warzone' => $warzone]);
    }

    /**
     * 代理编辑功能提交
     */
    public function agent_list_edit_check(Request $request)
    {
        // 中间件产生的管理员数据参数
        $admin_data = $request->get('admin_data');
        // 获取当前的页面路由
        $route_name = $request->path();
        // 代理id
        $id = $request->input('id');
        // 战区id
        $zone_id = $request->input('zone_id');
        // 代理名称
        $organization_name = $request->input('organization_name');
        // 用户名字
        $realname = $request->input('realname');
        // 用户身份证号
        $idcard = $request->input('idcard');
        // 用户手机号
        $mobile = $request->input('mobile');
        // 查询修改的代理名字是否存在
        if (Organization::checkRowExists([['organization_name', $organization_name], ['id', '<>', $id]])) {
            return response()->json(['data' => '代理名称已存在', 'status' => '0']);
        }
        // 查询用户id
        $account_id = Account::getPluck([['organization_id', $id], ['deepth', '1']], 'id')->first();
        DB::beginTransaction();
        try {
            // 修改代理表代理名称
            Organization::editOrganization([['id', $id]], ['organization_name' => $organization_name]);

            // 修改代理表代理手机号码
            OrganizationAgentinfo::editOrganizationAgentinfo([['agent_id', $id]], ['agent_owner_mobile' => $mobile]);

            // 修改用户管理员信息表 手机号
            Account::editAccount([['organization_id', $id]], ['mobile' => $mobile]);

            // 修改代理用户信息表 用户姓名
            OrganizationAgentinfo::editOrganizationAgentinfo([['agent_id', $id]], ['agent_owner' => $realname]);

            // 修改用户管理员信息表 用户名
            AccountInfo::editAccountInfo([['account_id', $account_id]], ['realname' => $realname]);

            // 修改用户管理员信息表 身份证号
            AccountInfo::editAccountInfo([['account_id', $account_id]], ['idcard' => $idcard]);
            
            // 修改代理信息表 身份证号
            OrganizationAgentinfo::editOrganizationAgentinfo([['agent_id', $id]], ['agent_owner_idcard' => $idcard]);

            // 修改战区关联表 战区id
            WarzoneAgent::editWarzoneAgent([['agent_id', $id]], ['zone_id' => $zone_id]);

            // 添加操作日志
            OperationLog::addOperationLog('1', $admin_data['organization_id'], $admin_data['id'], $route_name, '修改了代理：' . $organization_name);
            // 提交事务
            DB::commit();

        } catch (Exception $e) {
            // 事件回滚
            DB::rollBack();
            return response()->json(['data' => '修改失败', 'status' => '0']);
        }
        return response()->json(['data' => '修改成功', 'status' => '1']);
    }

    //代理冻结ajaxshow显示页面
    public function agent_list_lock(Request $request)
    {
        $id = $request->input('id'); //代理id
        $status = $request->input('status'); //冻结状态
        $list = Organization::getOneagent([['id', $id]]); //代理信息
        return view('Zerone/Agent/agent_list_lock', ['id' => $id, 'list' => $list, 'status' => $status]);
    }

    //代理冻结功能提交
    public function agent_list_lock_check(Request $request)
    {
        $admin_data = $request->get('admin_data'); //中间件产生的管理员数据参数
        $route_name = $request->path(); //获取当前的页面路由
        $id = $request->input('id'); //代理id
        $status = $request->input('status'); //代理id
        $list = Organization::getOneagent([['id', $id]]);
        DB::beginTransaction();
        try {
            if ($status == '1') {
                Organization::editOrganization([['id', $id]], ['status' => '0']);
                Account::editOrganizationBatch([['organization_id', $id]], ['status' => '0']);
                //添加操作日志
                OperationLog::addOperationLog('1', $admin_data['organization_id'], $admin_data['id'], $route_name, '冻结了代理：' . $list['organization_name']); //保存操作记录

            } elseif ($status == '0') {
                Organization::editOrganization([['id', $id]], ['status' => '1']);
                Account::editOrganizationBatch([['organization_id', $id]], ['status' => '1']);
                //添加操作日志
                OperationLog::addOperationLog('1', $admin_data['organization_id'], $admin_data['id'], $route_name, '解冻了代理：' . $list['organization_name']); //保存操作记录

            }
            DB::commit(); //提交事务

        } catch (Exception $e) {
            DB::rollBack(); //事件回滚
            return response()->json(['data' => '操作失败', 'status' => '0']);
        }
        return response()->json(['data' => '操作成功', 'status' => '1']);
    }

    //代理下级人员架构
    public function agent_structure(Request $request)
    {
        $admin_data = $request->get('admin_data'); //中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data'); //中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data'); //中间件产生的管理员数据参数
        $route_name = $request->path(); //获取当前的页面路由
        $organization_id = $request->input('organization_id'); //代理id
        $listOrg = Organization::getOneagent([['id', $organization_id]]);
        $oneOrg = Account::getOne([['organization_id', $organization_id], ['parent_id', '1']]);
        $list = Account::getList([['organization_id', $organization_id], ['parent_tree', 'like', '%' . $oneOrg['parent_tree'] . $oneOrg['id'] . ',%']], 0, 'id', 'asc')->toArray();
        $structure = $this->account_structure($list, $oneOrg['id']);
        return view('Zerone/Agent/agent_structure', ['listOrg' => $listOrg, 'oneOrg' => $oneOrg, 'structure' => $structure, 'admin_data' => $admin_data, 'route_name' => $route_name, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data]);
    }

    /**
     * 递归生成人员结构的方法
     * $list - 结构所有人员的无序列表
     * $id - 上级ID
     */
    private function account_structure($list, $id)
    {
        $structure = '';
        foreach ($list as $key => $val) {
            if ($val['parent_id'] == $id) {
                unset($list[$key]);
                $val['sonlist'] = $this->account_structure($list, $val['id']);
                //$arr[] = $val;
                $structure .= '<ol class="dd-list"><li class="dd-item" data-id="' . $val['id'] . '">';
                $structure .= '<div class="dd-handle">';
                $structure .= '<span class="pull-right">创建时间：' . date('Y-m-d,H:i:s', $val['created_at']) . '</span>';
                $structure .= '<span class="label label-info"><i class="fa fa-user"></i></span>';
                $structure .= $val['account'] . '-' . $val['account_info']['realname'];
                if (!empty($val['account_roles'])) {
                    $structure .= '【' . $val['account_roles'][0]['role_name'] . '】';
                }
                $structure .= '</div>';
                $son_menu = $this->account_structure($list, $val['id']);
                if (!empty($son_menu)) {
                    $structure .= $son_menu;
                }
                $structure .= '</li></ol>';
            }
        }
        return $structure;
    }

    //代理程序管理
    public function agent_program(Request $request)
    {
        $admin_data = $request->get('admin_data'); //中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data'); //中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data'); //中间件产生的管理员数据参数
        $route_name = $request->path(); //获取当前的页面路由
        $organization_id = $request->input('organization_id'); //代理id
        $listOrg = Organization::getOneagent([['id', $organization_id]]);
        $list = Program::getPaginage([['is_asset', '1']], 15, 'id');
        foreach ($list as $key => $value) {
            $re = OrganizationAssets::getOne([['organization_id', $organization_id], ['program_id', $value['id']]]);
            $list[$key]['program_balance'] = $re['program_balance'];
            $list[$key]['program_used_num'] = $re['program_used_num'];
        }
        return view('Zerone/Agent/agent_program', ['list' => $list, 'listOrg' => $listOrg, 'admin_data' => $admin_data, 'route_name' => $route_name, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data]);
    }

    //代理程序管理页面划入js显示
    public function agent_assets(Request $request)
    {
        $organization_id = $request->input('organization_id'); //代理id
        $program_id = $request->input('program_id'); //套餐id
        $listOrg = Organization::getOneagent([['id', $organization_id]]);
        $oneProgram = Program::getOne([['id', $program_id]]);
        $status = $request->input('status'); //状态
        return view('Zerone/Agent/agent_assets', ['listOrg' => $listOrg, 'oneProgram' => $oneProgram, 'status' => $status]);
    }

    //代理程序管理页面划入划出检测
    public function agent_assets_check(Request $request)
    {
        $route_name = $request->path(); //获取当前的页面路由
        $admin_data = $request->get('admin_data'); //中间件产生的管理员数据参数
        if ($admin_data['organization_id'] == 0) { //超级管理员没有组织id，操作默认为零壹公司操作
            $to_organization_id = 1;
        } else {
            $to_organization_id = $admin_data['organization_id'];
        }
        $organization_id = $request->input('organization_id'); //代理id
        $agent_name = Organization::getPluck([['id', $organization_id]], 'organization_name')->first();//代理名字
        $program_id = $request->input('program_id'); //程序id
        $program_name = Program::getPluck([['id', $program_id]], 'program_name')->first();//程序名字
        $number = $request->input('number'); //数量
        $status = $request->input('status'); //判断划入或者划出
        DB::beginTransaction();
        try {
            $re = OrganizationAssets::getOne([['organization_id', $organization_id], ['program_id', $program_id]]);
            $id = $re['id'];
            if ($status == '1') { //划入
                $state = '划入';
                if (empty($re)) {
                    OrganizationAssets::addAssets(['organization_id' => $organization_id, 'program_id' => $program_id, 'program_balance' => $number, 'program_used_num' => '0']);
                } else {
                    $num = $re['program_balance'] + $number;
                    OrganizationAssets::editAssets([['id', $id]], ['program_balance' => $num]);
                }

            } else { //划出
                $state = '划出';
                if (empty($re)) {
                    return response()->json(['data' => '数量不足', 'status' => '0']);
                } else {
                    if ($re['program_balance'] >= $number) { //划出数量小于或等于剩余数量
                        $num = $re['program_balance'] - $number;
                        OrganizationAssets::editAssets([['id', $id]], ['program_balance' => $num]);
                    } else {
                        return response()->json(['data' => '数量不足', 'status' => '0']);
                    }
                }
            }
            $data = ['operator_id' => $admin_data['id'], 'fr_organization_id ' => $organization_id, 'to_organization_id' => $to_organization_id, 'program_id' => $program_id, 'status' => $status, 'number' => $number];
            //添加程序操作记录
            OrganizationAssetsallocation::addOrganizationAssetsallocation($data); //保存操作记录

            //添加操作日志
            OperationLog::addOperationLog('1', '1', $admin_data['id'], $route_name, $state . '程序--' . $program_name . '*' . $number . ' --代理：' . $agent_name);
            DB::commit(); //提交事务

        } catch (Exception $e) {
            DB::rollBack(); //事件回滚
            return response()->json(['data' => '操作失败', 'status' => '0']);
        }
        return response()->json(['data' => '操作成功', 'status' => '1']);
    }

    //商户划拨管理
    public function agent_fansmanage(Request $request)
    {
        $admin_data = $request->get('admin_data'); //中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data'); //中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data'); //中间件产生的管理员数据参数
        $route_name = $request->path(); //获取当前的页面路由
        $organization_id = $request->organization_id; //代理id
        $organization_name = Organization::getPluck([['id', $organization_id]], 'organization_name')->first();
        $list = Organization::getPaginageFansmanage([['parent_id', $organization_id]], '10', 'id');
        foreach ($list as $key => $value) {
            $data = Organization::getList([['parent_id', $value['id']]]); //商户信息下级店铺信息
            $list[$key]['store'] = count($data); //计算店铺数量
            $list[$key]['program_name'] = Program::getPluck([['id', $value['asset_id']]], 'program_name')->first();//程序名字
            $list[$key]['program_balance'] = OrganizationAssets::getPluck([['program_id', $value['asset_id']], ['organization_id', $value['id']]], 'program_balance')->first();//程序剩余数量
        }
        return view('Zerone/Agent/agent_fansmanage', ['organization_name' => $organization_name, 'organization_id' => $organization_id, 'list' => $list, 'admin_data' => $admin_data, 'route_name' => $route_name, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data]);
    }

    //商户划拨归属Ajax显示页面--划入
    public function agent_fansmanage_add(Request $request)
    {
        $organization_id = $request->organization_id; //代理id
        $list = Organization::getList([['type', 3], ['parent_id', '<>', $organization_id], ['parent_id', '1']]);
        $data = Organization::getOne([['id', $organization_id]]);
        return view('Zerone/Agent/agent_fansmanage_add', ['list' => $list, 'data' => $data]);
    }

    //商户划拨归属功能提交
    public function agent_fansmanage_add_check(Request $request)
    {
        $admin_data = $request->get('admin_data'); //中间件产生的管理员数据参数
        $route_name = $request->path(); //获取当前的页面路由
        $organization_id = $request->organization_id; //代理id
        $oneAgent = Organization::getOne([['id', $organization_id]]); //代理信息
        $status = $request->status; //是否消耗程序数量
        $fansmanage_id = $request->fansmanage_id; //商户id
        $fansmanage_name = Organization::getPluck([['id', $fansmanage_id]], 'organization_name')->first();
        DB::beginTransaction();
        try {
            $parent_tree = $oneAgent['parent_tree'] . $organization_id . ','; //组织树
            Organization::editOrganization([['id', $fansmanage_id]], ['parent_id' => $organization_id, 'parent_tree' => $parent_tree]);
            $datastore = Organization::getList([['parent_id', $fansmanage_id]]); //商户信息下级分店信息
            if (!empty($datastore->toArray())) { //如果有店铺
                foreach ($datastore as $key => $value) {
                    $asset_id = $value->program_id; //店铺用的程序id
                    $storeParent_tree = $parent_tree . $fansmanage_id . ','; //商户店铺的组织树
                    Organization::editOrganization([['id', $value->id]], ['parent_tree' => $storeParent_tree]);
                }
                if ($status == 1) { //消耗程序数量
                    $number = count($datastore); //计算店铺数量
                    $Assets = OrganizationAssets::getOne([['organization_id', $organization_id], ['program_id', $asset_id]]); //查询代理程序数量信息
                    if ($Assets['program_balance'] >= $number) { //如果代理剩余程序数量足够
                        $program_balance = $Assets->program_balance - $number; //剩余数量
                        $program_used_num = $Assets->program_used_num + $number; //使用数量
                        OrganizationAssets::editAssets([['id', $Assets->id]], ['program_balance' => $program_balance, 'program_used_num' => $program_used_num]); //修改数量
                        $data = ['operator_id' => $admin_data['id'], 'fr_organization_id ' => $organization_id, 'to_organization_id' => $fansmanage_id, 'program_id' => $asset_id, 'status' => '0', 'number' => $number];
                        //添加操作日志
                        OrganizationAssetsallocation::addOrganizationAssetsallocation($data); //保存操作记录

                    } else {
                        return response()->json(['data' => '该代理的程序数量不够', 'status' => '0']);
                    }
                }
            }
            //添加操作日志
            OperationLog::addOperationLog('1', '1', $admin_data['id'], $route_name, '划拨了商户:' . $fansmanage_name . '-归属于代理：' . $oneAgent['organization_name']); //保存操作记录
            DB::commit(); //提交事务

        } catch (Exception $e) {
            DB::rollBack(); //事件回滚
            return response()->json(['data' => '操作失败', 'status' => '0']);
        }
        return response()->json(['data' => '操作成功', 'status' => '1']);
    }

    //商户划拨归属Ajax显示页面--划出
    public function agent_fansmanage_draw(Request $request)
    {
        $organization_id = $request->organization_id; //代理id
        $oneAgent = Organization::getOne([['id', $organization_id]]);
        $fansmanage_id = $request->fansmanage_id; //划出商户id
        $onedata = Organization::getOne([['id', $fansmanage_id]]);
        return view('Zerone/Agent/agent_fansmanage_draw', ['onedata' => $onedata, 'oneAgent' => $oneAgent]);
    }

    //商户划拨归属划出功能提交
    public function agent_fansmanage_draw_check(Request $request)
    {
        /*划出默认归属零壹*/
        $admin_data = $request->get('admin_data'); //中间件产生的管理员数据参数
        $route_name = $request->path(); //获取当前的页面路由
        $organization_id = $request->organization_id; //代理id
        $organization_name = Organization::getPluck([['id', $organization_id]], 'organization_name')->first(); //代理名称
        $fansmanage_id = $request->fansmanage_id; //划出商户id
        $status = $request->status; //是否消耗程序数量
        $fansmanage_name = Organization::getPluck([['id', $fansmanage_id]], 'organization_name')->first(); //店铺名称
        DB::beginTransaction();
        try {
            $parent_tree = '0' . ',' . '1' . ','; //组织树
            Organization::editOrganization([['id', $fansmanage_id]], ['parent_id' => '1', 'parent_tree' => $parent_tree]);
            $datastore = Organization::getList([['parent_id', $fansmanage_id]]); //商户信息下级分店信息
            if (!empty($datastore->toArray())) { //如果有店铺
                foreach ($datastore as $key => $value) {
                    $asset_id = $value->program_id; //店铺用的程序id
                    $storeParent_tree = $parent_tree . $fansmanage_id . ','; //商户店铺的组织树
                    Organization::editOrganization([['id', $value->id]], ['parent_tree' => $storeParent_tree]);
                }
                if ($status == 1) { //消耗程序数量
                    $number = count($datastore); //计算店铺数量
                    $Assets = OrganizationAssets::getOne([['organization_id', $organization_id], ['program_id', $asset_id]]); //查询代理程序数量信息
                    if (!empty($Assets)) { //如果存在
                        $program_balance = $Assets->program_balance + $number; //剩余数量
                        $program_used_num = $Assets->program_used_num - $number; //使用数量
                        OrganizationAssets::editAssets([['id', $Assets->id]], ['program_balance' => $program_balance, 'program_used_num' => $program_used_num]); //修改数量

                    } else {
                        $data = ['program_id' => $asset_id, 'organization_id' => $organization_id, 'program_balance' => $number, 'program_used_num' => '0'];
                        OrganizationAssets::addAssets($data);
                    }
                    $data = ['operator_id' => $admin_data['id'], 'fr_organization_id ' => '1', 'to_organization_id' => $organization_id, 'program_id' => $asset_id, 'status' => '2', 'number' => $number];
                    //添加操作日志
                    OrganizationAssetsallocation::addOrganizationAssetsallocation($data); //保存操作记录

                }
            }
            //添加操作日志
            OperationLog::addOperationLog('1', '1', $admin_data['id'], $route_name, '从代理:' . $organization_name . '-划出了商户：' . $fansmanage_name); //保存操作记录
            DB::commit(); //提交事务

        } catch (Exception $e) {
            DB::rollBack(); //事件回滚
            return response()->json(['data' => '操作失败', 'status' => '0']);
        }
        return response()->json(['data' => '操作成功', 'status' => '1']);
    }


    /**
     * 添加代理数据提交
     */
    private function add_agent($data)
    {
        DB::beginTransaction();
        try {
            // 代理组织树
            $orgparent_tree = '0' . ',' . '1' . ',';
            //数据处理
            $orgData = [
                // 代理名称
                'organization_name' => $data['agent_name'],
                // 上级id
                'parent_id' => '1',
                // 组织树
                'parent_tree' => $orgparent_tree,
                // 程序id
                'program_id' => '2',
                // 类型2为代理
                'type' => '2',
                // 状态1正常 0冻结
                'status' => '1',

                'asset_id' => '0',
            ];
            // 添加代理并返回组织id
            $organization_id = Organization::addOrganization($orgData);

            //数据处理
            $agentdata = [
                // 代理id
                'agent_id' => $organization_id,
                // 战区id
                'zone_id' => $data['zone_id']
            ];
            // 战区关联代理
            WarzoneAgent::addWarzoneAgent($agentdata);

            // 查询零壹账号人数
            $user = Account::max('account');
            // 新的用户账号
            $account = $user + 1;
            // 树是上级的树拼接上级的ID；
            $parent_tree = '0' . ',';
            // 数据处理
            $accdata = [
                // 上级id
                'parent_id' => '0',
                // 组织树
                'parent_tree' => $parent_tree,
                // 账号深度
                'deepth' => '1',
                // 手机号
                'mobile' => $data['agent_owner_mobile'],
                // 密码
                'password' => $data['agent_password'],
                // 组织id
                'organization_id' => $organization_id,
                // 登入账号
                'account' => $account
            ];
            // 添加账号返回id
            $account_id = Account::addAccount($accdata);

            // 数据处理
            $acinfodata = [
                // 用户id
                'account_id' => $account_id,
                // 负责人姓名
                'realname' => $data['agent_owner'],
                // 负责人身份证
                'idcard' => $data['agent_owner_idcard']
            ];
            // 添加到用户信息详情
            AccountInfo::addAccountInfo($acinfodata);

            // 数据处理
            $orgagentinfo = [
                // 代理id
                'agent_id' => $organization_id,
                // 代理负责人名字
                'agent_owner' => $data['agent_owner'],
                // 代理负责人身份证
                'agent_owner_idcard' => $data['agent_owner_idcard'],
                // 代理负责人手机号
                'agent_owner_mobile' => $data['agent_owner_mobile']
            ];
            // 添加到代理组织信息表
            OrganizationAgentinfo::addOrganizationAgentinfo($orgagentinfo);

            // 获取当前系统的所有节点
            $module_node_list = Module::getListProgram(2, [], 0, 'id');
            foreach ($module_node_list as $key => $val) {
                foreach ($val->program_nodes as $k => $v) {
                    // 为当前用户加上节点权限
                    AccountNode::addAccountNode(['account_id' => $account_id, 'node_id' => $v['id']]);
                }
            }
            // 提交事务
            DB::commit();
        } catch (Exception $e) {
            // 事件回滚
            DB::rollBack();
            return response()->json(['data' => '审核失败', 'status' => '0']);
        }
        return 'ok';
    }

}

?>