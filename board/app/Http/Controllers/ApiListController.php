<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boards;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\factory;


class ApiListController extends Controller
{
    function getList($id){
        $board = Boards::find($id);
        // return response()->json($board,200); code num 이외에 설정을 하기 위해 사용
        // postman에서 header 등등 설정
        return $board;// 자동으로 jason으로 200으로 넘겨줌
    }
    function postList(Request $req){
        //유효성 체크 필요


        $boards = new Boards([
            'title' => $req->title,
            'content' =>$req->content
        ]);
        $boards->save();

        $arr['errorcode'] = '0';
        $arr['msg'] = 'success';
        $arr['data']=$boards->only('id','title');

        return $arr;

    }
    function putlist(Request $req, $id){
        $arrData=[
            'code' =>'0',
            'msg' => '',
            // 'org_data' => [],
            // 'udt_data' => []
        ];
        $arr1 = ['id' => $id];
        $req->merge($arr1);

        $validator = Validator::make($req->all(),
            [
                'id' => 'required|exists:boards|integer',
                'title' => 'required|between:3,30'
                ,'content' => 'required|max:2000'
            ]
        );
        if($validator->fails()){
            $arrData['code']= 'E01';
            $arrData['msg']= 'Validate Error';
            $arrData['errmsg'] = $validator->errors()->all();
            return $arrData;
        }else{$result = Boards::find($id);
            $result->title=$req->title;
            $result->content=$req->content;
            $result->save();

            $arr['code'] = '0';
            $arr['msg'] = 'success';
            $arr['data']=$result->only('title','content');
            return $arr;}
    }

    function deletelist($id){
        $arrData=[
            'code' =>'0',
            'msg' => '',
            // 'org_data' => [],
            // 'udt_data' => []
        ];
        $data['id'] = $id;
        $validator = Validator::make( $data,
            [
                'id' => 'required|exists:boards|integer',
            ]
        );
        if($validator->fails()){
            $arrData['code']= 'E01';
            $arrData['msg']= 'Validate Error';
            $arrData['errmsg'] = 'ID NOT FOUND';
            return $arrData;
        }else{
            $board=Boards::find($id);
            if($board){
                $board->delete();
                $arrData['code'] = '0';
                $arrData['msg'] = 'success';
            }else{
                $arrData['code']='E02';
                $arrData['msg']='Already Deleted';
            }

        }
        return $arrData;
    }
}