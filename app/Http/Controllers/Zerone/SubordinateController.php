<?php
namespace App\Http\Controllers\Zerone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganizationRole;
use App\Models\Module;
use Session;
class SubordinateController extends Controller{
    //添加下级人员
    public function subordinate_add(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由
        //获取当前用户添加的权限角色
        $role_list = OrganizationRole::getList([['program_id',1],['created_by',$admin_data['id']]],0,'id');
        $module_node_list = $this->getProgramModuleNode();
        return view('Zerone/Subordinate/subordinate_add',['role_list'=>$role_list,'module_node_list'=>$module_node_list,'admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data]);
    }

    //获取当前程序的功能模块和节点
    public function getModuleNode($account_id,$tag=true){
        $module_node_list = Module::getListProgram(1,[],0,'id');//获取当前系统的所有模块和节点
        return $module_node_list;
    }

    //添加下级人员数据提交
    public function subordinate_add_check(Request $request){
        echo "这里是添加下级人员数据提交";
    }

    //下级人员列表
    public function subordinate_list(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由
        return view('Zerone/Subordinate/subordinate_list',['admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data]);
    }

    //编辑下级人员
    public function subordinate_edit(Request $request){
        echo "这里是编辑下级人员";
    }

    //编辑下级人员数据提交
    public function subordinate_edit_check(Request $request){
        echo "这里是编辑下级人员数据提交";
    }

    //冻结下级人员
    public function subordinate_lock(Request $request){
        echo "这里是冻结下级人员";
    }

    //删除下级人员
    public function subordinate_delete(Request $request){
        echo "这里是删除下级人员";
    }

    //下级人员结构
    public function subordinate_structure(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由
        return view('Zerone/Subordinate/subordinate_structure',['admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data]);
    }
}
?>