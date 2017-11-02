<?php
/**
 *新版本登陆界面
 *
 **/
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Crypt;
use App\Models\Admin;
use Session;

class LoginController extends Controller{
    /*
     * 登陆页面
     */
    public function display()
    {
        $request = new Request();
        $ip = $request->getClientIps();
        dump($ip);
        $data['random']=time();
        return view('dashboard/login/display',$data);

    }
    /*
     * 生成验证码
     */
    public function captcha()
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 150, $height = 35, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session
        Session::flash('milkcaptcha', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }

    //检测登录
    public function checkLogin(){
        $request = new Request();
        $ip = $request->ip();
        dump($ip);
        $username = Input::get('username');//接收用户名
        $password = Input::get('password');//接收用户密码
        $key = config("app.encrypt_key");//获取加密盐
        $encrypted = md5($password);//加密密码第一重
        $encryptPwd = md5("lingyikeji".$encrypted.$key);//加密密码第二重
        $admininfo = Admin::where('username',$username)->first()->toArray();
        if(!empty($admininfo)){
            if($encryptPwd != $admininfo['password']){//查询密码是否对的上
                return response()->json(['data' => '登录账号或密码错误', 'status' => '0']);
            }else{

                return response()->json(['data' => '登录成功', 'status' => '1']);
            }
        }else{
            return response()->json(['data' => '登录账号或密码错误', 'status' => '0']);
        }
    }
}
?>