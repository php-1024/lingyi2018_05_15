<?php
namespace App\Http\Controllers\Zerone;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountInfo;
use App\Models\CompanyApply;
use App\Models\OperationLog;
use App\Models\Organization;
use App\Models\OrganizationCompanyinfo;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class CompanyController extends Controller{
    //添加服务商
    public function company_add(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由
        $list = Organization::whereIn('type',[1,2])->where([['status','1']])->get();

        return view('Zerone/Company/company_add',['admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data,'list'=>$list]);
    }
    //注册提交商户数据
    public function company_add_check(Request $request){
        $admin_data = Account::where('id',1)->first();//查找超级管理员的数据
        $admin_this = $request->get('admin_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由
        $id = $request->input('organization_id');//零壹或者服务商organization_id
        $organization_name = $request->input('organization_name');//商户名称
        $where = [['organization_name',$organization_name],['id','<>',$id]];

        $name = Organization::checkRowExists($where);

        if($name == 'true'){
            return response()->json(['data' => '商户已存在', 'status' => '0']);
        }


        $list = Organization::getOne([['id',$id]]);

        $parent_id = $id;//上级组织 零壹或者服务商organization_id
        $parent_tree = $list['parent_tree'].$parent_id.',';//树是上级的树拼接上级的ID；
        $mobile = $request->input('mobile');//手机号码

        $password = $request->input('password');//用户密码
        $key = config("app.zerone_encrypt_key");//获取加密盐
        $encrypted = md5($password);//加密密码第一重
        $encryptPwd = md5("lingyikeji".$encrypted.$key);//加密密码第二重
        DB::beginTransaction();
        try{
            $listdata = ['organization_name'=>$organization_name,'parent_id'=>$parent_id,'parent_tree'=>$parent_tree,'program_id'=>3,'type'=>3,'status'=>1];
            $organization_id = Organization::addOrganization($listdata); //返回值为商户的id

            $user = Account::max('account');
            $account  = $user+1;//用户账号

            $Accparent_tree = $admin_data['parent_tree'].$admin_data['id'].',';//管理员组织树
            $accdata = ['parent_id'=>$admin_data['id'],'parent_tree'=>$Accparent_tree,'deepth'=>$admin_data['deepth']+1,'mobile'=>$mobile,'password'=>$encryptPwd,'organization_id'=>$organization_id,'account'=>$account];
            $account_id = Account::addAccount($accdata);//添加账号返回id

            $realname = $request->input('realname');//负责人姓名
            $idcard = $request->input('idcard');//负责人身份证号
            $acinfodata = ['account_id'=>$account_id,'realname'=>$realname,'idcard'=>$idcard];
            AccountInfo::addAccountInfo($acinfodata);//添加到管理员信息表

            $comproxyinfo = ['organization_id'=>$organization_id, 'company_owner'=>$realname, 'company_owner_idcard'=>$idcard, 'company_owner_mobile'=>$mobile];

            OrganizationCompanyinfo::addOrganizationCompanyinfo($comproxyinfo);  //添加到服务商组织信息表
            //添加操作日志
            OperationLog::addOperationLog('1',$admin_this['organization_id'],$admin_this['id'],$route_name,'添加了商户：'.$organization_name);//保存操作记录
            DB::commit();//提交事务
        }catch (\Exception $e) {
            dd($e);
            DB::rollBack();//事件回滚
            return response()->json(['data' => '注册失败', 'status' => '0']);
        }
        return response()->json(['data' => '注册成功', 'status' => '1']);

    }

    //商户审核列表
    public function company_examinelist(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由

        $company_name = $request->input('company_name');
        $company_owner_mobile = $request->input('company_owner_mobile');
        $search_data = ['company_name'=>$company_name,'company_owner_mobile'=>$company_owner_mobile];
        $where = [];
        if(!empty($company_name)){
            $where[] = ['company_name','like','%'.$company_name.'%'];
        }

        if(!empty($company_owner_mobile)){
            $where[] = ['company_owner_mobile',$company_owner_mobile];
        }

        $list = CompanyApply::getPaginage($where,'15','id');
        return view('Zerone/Company/company_examinelist',['list'=>$list,'search_data'=>$search_data,'admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data]);
    }
    //商户审核ajaxshow显示页面
    public function company_examine(Request $request){
        $id = $request->input('id');//服务商id
        $sta = $request->input('sta');//是否通过值 1为通过 -1为不通过
        $info =  CompanyApply::getOne([['id',$id]]);//获取该ID的信息
        return view('Zerone/Company/company_examine',['info'=>$info,'sta'=>$sta]);
    }
    //商户审核数据提交
    public function company_examine_check(Request $request){
        $admin_data = Account::where('id',1)->first();//查找超级管理员的数据
        $admin_this = $request->get('admin_data');//查找当前操作人员数据
        $route_name = $request->path();//获取当前的页面路由
        $id = $request->input('id');//服务商id
        $sta = $request->input('sta');//是否通过值 1为通过 -1为不通过
        $companylist = CompanyApply::getOne([['id',$id]]);//查询申请服务商信息

        if($sta == -1 ){
            DB::beginTransaction();
            try{
                CompanyApply::editCompanyApply([['id',$id]],['status'=>$sta]);//拒绝通过
                //添加操作日志
                OperationLog::addOperationLog('1',$admin_this['organization_id'],$admin_this['id'],$route_name,'拒绝了商户：'.$companylist['proxy_name']);//保存操作记录
                DB::commit();//提交事务
            }catch (\Exception $e) {
                DB::rollBack();//事件回滚
                return response()->json(['data' => '拒绝失败', 'status' => '0']);
            }
            return response()->json(['data' => '拒绝成功', 'status' => '1']);
        }elseif($sta == 1){

            $list = Organization::getOne([['id',$id]]);

            $parent_id = $id;//零壹或者服务商organization_id
            $parent_tree = $list['parent_tree'].$parent_id.',';//树是上级的树拼接上级的ID；
            $mobile = $companylist['company_owner_mobile'];//手机号码

            DB::beginTransaction();
            try{
                CompanyApply::editCompanyApply([['id',$id]],['status'=>$sta]);//申请通过
                //添加服务商
                $listdata = ['organization_name'=>$companylist['company_name'],'parent_id'=>$parent_id,'parent_tree'=>$parent_tree,'program_id'=>3,'type'=>3,'status'=>1];
                $organization_id = Organization::addOrganization($listdata); //返回值为商户的id

                $user = Account::max('account');
                $account  = $user+1;//用户账号
                $company_password =  $companylist['company_password'];//用户密码

                $deepth = $admin_data['deepth']+1;  //用户在该组织里的深度
                $Accparent_tree = $admin_data['parent_tree'].$admin_data['id'].',';//管理员组织树
                $accdata = ['parent_id'=>$admin_data['id'],'parent_tree'=>$Accparent_tree,'deepth'=>$deepth,'mobile'=>$mobile,'password'=>$company_password,'organization_id'=>$organization_id,'account'=>$account];
                $account_id = Account::addAccount($accdata);//添加账号返回id

                $realname = $companylist['company_owner'];//负责人姓名
                $idcard = $companylist['company_owner_idcard'];//负责人身份证号
                $acinfodata = ['account_id'=>$account_id,'realname'=>$realname,'idcard'=>$idcard];
                AccountInfo::addAccountInfo($acinfodata);//添加到管理员信息表

                $companyinfo = ['organization_id'=>$organization_id, 'company_owner'=>$realname, 'company_owner_idcard'=>$idcard, 'company_owner_mobile'=>$companylist['company_owner_mobile']];

                OrganizationCompanyinfo::addOrganizationCompanyinfo($companyinfo);  //添加到服务商组织信息表

                //添加操作日志
                OperationLog::addOperationLog('1',$admin_this['organization_id'],$admin_this['id'],$route_name,'服务商审核通过：'.$companylist['company_name']);//保存操作记录
                DB::commit();//提交事务
            }catch (\Exception $e) {
                DB::rollBack();//事件回滚
                return response()->json(['data' => '审核失败', 'status' => '0']);
            }
            return response()->json(['data' => '申请通过', 'status' => '1']);
        }
    }


    //服务商列表
    public function company_list(Request $request){

        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由

        $organization_name = $request->input('organization_name');
        $company_owner_mobile = $request->input('company_owner_mobile');

        $search_data = ['organization_name'=>$organization_name,'company_owner_mobile'=>$company_owner_mobile];
        $where = [['type','3']];
        if(!empty($organization_name)){
            $where[] = ['organization_name','like','%'.$organization_name.'%'];
        }

        $listorg = Organization::getCompany($where,'5','id');
        foreach ($listorg as $k=>$v){
            $listorg[$k]['account'] = Account::getPluck(['organization_id'=>$v['id'],'parent_id'=>'1'],'account')->first();
            $listorg[$k]['proxy_name'] = Organization::getPluck(['id'=>$v['parent_id']],'organization_name')->first();
        }
        return view('Zerone/Company/company_list',['search_data'=>$search_data,'listorg'=>$listorg,'admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data]);
    }
    //商户编辑ajaxshow显示页面
    public function company_list_edit(Request $request){
        $id = $request->input('id');//服务商id
        $listorg = Organization::getOneCompany([['id',$id]]);
        $proxy = Organization::whereIn('type',[1,2])->where([['status','1']])->get();
        return view('Zerone/Company/company_list_edit',compact('listorg','proxy'));
    }
    //服务商编辑功能提交
    public function company_list_edit_check(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由
        $id = $request->input('id');//服务商id
        $parent_id = $request->input('parent_id');//上级id

        $organization_name = $request->input('organization_name');//服务商名称
        $realname = $request->input('realname');//用户名字
        $idcard = $request->input('idcard');//用户身份证号
        $mobile = $request->input('mobile');//用户手机号
        $password = $request->input('password');//登入密码

        DB::beginTransaction();
        try{
            $list = Organization::getOneCompany(['id'=>$id]); //获取商户组织信息
            $acc = Account::getOne(['organization_id'=>$id,'parent_id'=>'1']);//获取商户负责人信息
            if($list['organization_name']!=$organization_name){
                Organization::editOrganization(['id'=>$id], ['organization_name'=>$organization_name]);//修改服务商表服务商名称
            }
            if($list['mobile']!=$mobile){
                OrganizationCompanyinfo::editOrganizationCompanyinfo(['organization_id'=>$id], ['company_owner_mobile'=>$mobile]);//修改商户表商户手机号码
                Account::editAccount(['organization_id'=>$id],['mobile'=>$mobile]);//修改用户管理员信息表 手机号
            }

            if($list['organizationcompanyinfo']['company_owner'] != $realname){
                $companydata = ['company_owner'=>$realname];
                OrganizationCompanyinfo::editOrganizationCompanyinfo(['organization_id'=>$id],$companydata);//修改商户信息表 用户姓名
                AccountInfo::editAccountInfo(['account_id'=>$acc['id']],['realname'=>$realname]);//修改用户管理员信息表 用户名
            }
            if(!empty($password)){
                $key = config("app.zerone_encrypt_key");//获取加密盐
                $encrypted = md5($password);//加密密码第一重
                $encryptPwd = md5("lingyikeji".$encrypted.$key);//加密密码第二重
                $accountdata = ['password'=>$encryptPwd];
                Account::editAccount(['organization_id'=>$id,'parent_id'=>'1'],$accountdata);//修改管理员表登入密码
            }
            if($acc['idcard'] != $idcard){
                AccountInfo::editAccountInfo(['account_id'=>$acc['id']],['idcard'=>$idcard]);//修改用户管理员信息表 身份证号
                OrganizationCompanyinfo::editOrganizationCompanyinfo(['organization_id'=>$id],['company_owner_idcard'=>$idcard]);//修改商户信息表 身份证号
            }

            if($list['parent_id'] != $parent_id){
                $porxy = Organization::getOne(['id'=>$parent_id]); //获取选择更换的上级服务商信息
                $parent_tree = $porxy['parent_tree'].$parent_id.',';//组织树
                $data = ['parent_id'=>$parent_id,'parent_tree'=>$parent_tree];
                Organization::editOrganization(['id'=>$id],$data);//修改商户的上级服务商信息
            }

            //添加操作日志
            OperationLog::addOperationLog('1',$admin_data['organization_id'],$admin_data['id'],$route_name,'修改了商户：'.$list['organization_name']);//保存操作记录
            DB::commit();//提交事务
        }catch (\Exception $e) {
            DB::rollBack();//事件回滚
            return response()->json(['data' => '修改失败', 'status' => '0']);
        }
        return response()->json(['data' => '修改成功', 'status' => '1']);
    }

    //商户冻结ajaxshow显示页面
    public function company_list_frozen(Request $request){
        $id = $request->input('id');//服务商id
        $status = $request->input('status');//冻结操作状态
        $list = Organization::getOne([['id',$id]]);//服务商信息
        return view('Zerone/Company/company_list_frozen',['id'=>$id,'list'=>$list,'status'=>$status]);
    }
    //商户冻结功能提交
    public function company_list_frozen_check(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由
        $id = $request->input('id');//服务商id
        $status = $request->input('status');//冻结操作状态
        $list = Organization::getOne([['id',$id]]);
        DB::beginTransaction();
        try{
            if($status == '1'){
                Organization::editOrganization([['id',$id]],['status'=>'0']);
                Account::editOrganizationBatch([['organization_id',$id]],['status'=>'0']);
                //添加操作日志
                OperationLog::addOperationLog('1',$admin_data['organization_id'],$admin_data['id'],$route_name,'冻结了服务商：'.$list['organization_name']);//保存操作记录
            }
            elseif($status == '0'){
                Organization::editOrganization([['id',$id]],['status'=>'1']);
                Account::editOrganizationBatch([['organization_id',$id]],['status'=>'1']);
                //添加操作日志
                OperationLog::addOperationLog('1',$admin_data['organization_id'],$admin_data['id'],$route_name,'解冻了服务商：'.$list['organization_name']);//保存操作记录
            }
            DB::commit();//提交事务
        }catch (\Exception $e) {
            DB::rollBack();//事件回滚
            return response()->json(['data' => '操作失败', 'status' => '0']);
        }
        return response()->json(['data' => '操作成功', 'status' => '1']);

    }
    //商户删除ajaxshow显示页面
    public function company_list_delete(Request $request){
//        $id = $request->input('id');//服务商id
//        $listorg = Organization::getOne(['id'=>$id]);
//        $warzone = Warzone::all();
        return view('Zerone/Company/company_list_delete');
    }

    //商户下级店铺架构
    public function company_structure(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由

        $organization_id = $request->input('organization_id');//服务商id
        $listOrg = Organization::getOneCompany([['id',$organization_id]]);
        $list = Organization::getArrayCompany([['parent_tree','like','%'.$listOrg['parent_tree'].$listOrg['id'].',%']],0,'id','asc')->toArray();
        $structure = $this->Com_structure($list,$organization_id);
        return view('Zerone/Company/company_structure',['listOrg'=>$listOrg,'structure'=>$structure,'admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data]);
    }



    private function Com_structure($list,$id){
        $structure = '';
        foreach($list as $key=>$val){
            if($val['parent_id'] == $id) {
                unset($list[$key]);
                $val['sonlist'] = $this->Com_structure($list, $val['id']);
                //$arr[] = $val;
                $structure .= '<ol class="dd-list"><li class="dd-item" data-id="' . $val['id'] . '">' ;
                $structure .= '<div class="dd-handle">';
                $structure .= '<span class="pull-right">创建时间：'.date('Y-m-d,H:i:s',$val['created_at']).'</span>';
                $structure .= '<span class="label label-info"><i class="fa fa-user"></i></span>';
                $structure .= '【商户】'. $val['organization_name']. '-'.$val['organization_companyinfo']['company_owner'].'-'.$val['organization_companyinfo']['company_owner_mobile'];
                $structure .= '</div>';
                $son_menu = $this->Com_structure($list, $val['id']);
                if (!empty($son_menu)) {
                    $structure .=  $son_menu;
                }
                $structure .= '</li></ol>';
            }
        }
        return $structure;
    }

    //商户程序管理
    public function company_program(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由
        $organization_id = $request->input('organization_id');//服务商id
        $listOrg = Organization::getOne([['id'=>$organization_id]]);
        $list = Package::getPaginage([],15,'id');

        return view('Zerone/Company/company_program',['list'=>$list,'listOrg'=>$listOrg,'admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data]);
    }
    //商户程序管理
    public function company_store(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由

        return view('Zerone/Company/company_store',['admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data]);
    }
}
?>