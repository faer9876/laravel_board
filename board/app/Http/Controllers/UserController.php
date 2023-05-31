<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function login(){
        return view('login');
    }
    function loginpost(Request $req) {
        // 유효성 체크
        $req->validate([
            'email'    => 'required|email|max:100'
            ,'password' => 'required|regex:/^(?=.*[a-zA-z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);

        // 유저정보 습득
        $user = User::where('email', $req->email)->first();
        if(!$user || !(Hash::check($req->password, $user->password))){
            $error = '아이디와 비밀번호를 확인해 주세요.';
            return redirect()->back()->with('error', $error);
        }

        // 유저 인증작업
        Auth::login($user);

        if(Auth::check()) { // 인증작업이 성공했는지 체크해준다.(Auth::check)
            session($user->only('id')); // 세션에 인증된 회원 PK 등록
            return redirect()->intended(route('boards.index')); // 필요한 정보만 빼고 전부 삭제후 리다이렉트
        } else {
            $error= '인증작업 에러';
            return redirect()->back()->with('error', $error);
        }
    }


    function registration(){
        return view('registration');
    }

    function registrationpost(Request $req){
        // 유효성 체크
        $req->validate([
            'name' => 'required|regex:/^[가-힣]+$/|min:2|max:30',
            'email' => 'required|email|max:100',
            'password' => 'required_unless:password,passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);


        $data['name']=$req->name;
        $data['email'] = $req->email;
        $data['password'] = Hash::make($req->password);

        $user = User::create($data);
        if(!$user){
            $errors[]='시스템 에러가 발생하여, 회원가입에 실패했습니다.';
            $errors[]='잠시 후에 다시 회원가입해 시도해 주십시오.';
            return redirect()
                ->route('users.registration')
                ->with('errors',$errors);
        }


        // 회원가입 완료 로그인 페이지로 이동
        return redirect()
            ->route('users.login')
            ->with('success','회원가입 축하');
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('users.login');
    }

    function withdraw(){
        // 회원탈퇴 유효성 체크 넣기 ex)destory error
        $id=session('id');
        $result=User::destroy($id);
        Session::flush();
        Auth::logout();
        return redirect()->route('users.login');
    }

    function userEdit($id){

        if(auth()->guest()){
            return redirect()->route('users.login');
        }
        $users = User::find($id);
        return view('userEdit')->with('data',$users);
    }

    function userEditUpdate(Request $req){
        // $validator = Validator::make(
        //     $req->only('email','name','password','passwordChk')
        //     ,[
        //         'email' => 'required|email|max:100',
        //         'name' => 'required|regex:/^[가-힣]+$/|min:2|max:30',
        //         'password' => 'required_unless:password,passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        //     ]
        // );
        // if($validator->fails()){
        //     return redirect()
        //     ->back()
        //     ->withErrors($validator)
        //     ->withInput($req->only('email','name','password','passwordChk'));
        // }

        // $data['name']=$req->name;
        // $data['email'] = $req->email;
        // $data['password'] = Hash::make($req->password);

        // if($req['password']===$req['passwordChk']){
        // $result = User::find(session('id'));
        // $result->email=$data['email'];
        // $result->password=$data['password'];
        // $result->name=$data['name'];
        // $result->save();
        // Session::flush();
        // Auth::logout();
        // return redirect()->route('users.login')->with('success','변경 완료');
        // }else{
        //     return redirect()->route('users.login')->with('error','변경 실패');
        // }
        $arrKey=[];

        $baseUser = User::find(Auth::User()->id); //기존 데이터

        $baseUser = User::where('email', $req->email)->first();
        if(Hash::check($req->bpassword, $baseUser->password)){
            return redirect()->back()->with('error','기존비밀번호 확인');
        }

        if($req->name !== $baseUser->name){
            $arrKey[] = 'name';
        }
        if($req->email !== $baseUser->email){
            $arrKey[] = 'email';
        }
        if(isset($req->password)){
            $arrKey[] ='password';
        }
        $chkList = [
            'email' => 'required|email|max:100',
                'name' => 'required|regex:/^[가-힣]+$/|min:2|max:30',
                'bpassword' => 'required_unless:password,passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/',
                'password' => 'same:passwordChk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ];


        $arrChk['bpassword'] = $chkList['bpassword'];
        foreach($arrKey as $val){
            $arrChk[$val]= $chkList[$val];
        }

        $req->validate($arrChk);

        // if($req['password']===$req['passwordChk']){
        foreach($arrKey as $val){
            if($val === 'password'){
                $baseUser->$val = Hash::make($req->$val);
                continue;
            }
            $baseUser->$val = $req->val;
        }
        $baseUser->save();
        Session::flush();
        Auth::logout();
        return redirect()->route('users.login')->with('success','변경 완료');
    }
}
