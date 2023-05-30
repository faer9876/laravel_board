<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    function login(){
        return view('login');
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
                ->with('errors',collect($errors));
        }

        // 회원가입 완료 로그인 페이지로 이동
        return redirect()
            ->route('users.login')
            ->with('success','회원가입 축하');
    }
}