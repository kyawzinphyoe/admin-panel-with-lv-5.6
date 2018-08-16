<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login(Request $request){
    	if($request->isMethod('post')){
    		$data=$request->input();
    		if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1'])){
                //Session::put('adminSession',$data['email']);
    			return redirect('/admin/dashboard');                
    		}else{
    			return redirect()->back()->with('flash_error_msg','Invalid email or password');
    		}
    	}
    	return view('admin.login');
    }
    public function dashboard(){
        // if(Session::has('adminSession')){
            
        // }else{
        //     return redirect('/admin/login')->with('flash_error_msg','Please login to access!!');      
        // }
         return view('admin.dashboard'); 
    }
    public function logout(){
        Session::flush();
        return redirect('/admin/login')->with('flash_success_msg','Logged out successfully');
    }
    public function setting(){
        return view('admin.settings');
    }
    public function checkpwd(Request $request){
        $data=$request->all();
        $current_pwd=$data['current_pwd'];
        $check_pwd=User::where('admin','1')->first();        
        if(Hash::check($current_pwd,$check_pwd->password)){
            echo "true"; die;
        }
        else{
            echo "false"; die;
        }
    }
    public function update_pwd(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            $current_pwd=$data['current_pwd'];
            $check_pwd=User::where('email',Auth::user()->email)->first();
            if(Hash::check($current_pwd,$check_pwd->password)){
                $password=bcrypt($data['new_pwd']);
                User::where('id','1')->update(['password'=>$password]);
                return redirect()->back()->with('flash_success_msg','update password successfully');
            }else{
                return redirect()->back()->with('flash_error_msg','incorrect current password');
            }
        }
    }
}
