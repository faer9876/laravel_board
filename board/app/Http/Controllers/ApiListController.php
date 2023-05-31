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
        return response()->json($board,200);
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
    public function putlist()
{
    $user = factory(User::class)->create();
    $token = $user->generateToken();
    $headers = ['Authorization' => "Bearer $token"];
    $article = factory(Article::class)->create([
        'title' => 'First Article',
        'content' => 'First Body',
    ]);

    $payload = [
        'title' => 'Lorem',
        'content' => 'Ipsum',
    ];

    $response = $this->json('PUT', '/api/articles/' . $article->id, $payload, $headers)
        ->assertStatus(200)
        ->assertJson([
            'title' => 'Lorem',
            'content' => 'Ipsum'
        ]);

    return $response;
}

}