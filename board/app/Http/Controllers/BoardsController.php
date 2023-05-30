<?php
/***********************************
 * 프로젝트명 : laravel_board
 * 디렉토리   : Controllers
 * 파일명     : BoardController.php
 * 이력       : v001 0526 최혁재 new
 *              v002 0530 김영범 유효성 체크 추가
 ***********************************/

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Boards;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Boards::select(['id','title','hits','created_at','updated_at'])->orderBy('hits','desc')->get();
        return view('list')->with('datas',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('write');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {

        // v002 add start
        $req->validate([
            'title' => 'required|between:3,30'
            ,'content' => 'required|max:1000'
        ]);
        // v002 add end

        $boards = new Boards([
            'title'=>$req->input('title')
            ,'content'=>$req->input('content')
        ]);
        $boards->save();
        return redirect('/boards');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boards = Boards::find($id);
        $boards->hits++;
        $boards->save();
        return view('detail')->with('data',Boards::findOrFail($id));//실패시 404오류 페이지로 이동
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $boards = Boards::find($id); //실패시 boolean 값으로 리턴(프로그램 이어짐)
        return view('edit')->with('data',$boards);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        // v002 add start


        // $validator=Validator::make(['id'=>$id],[
        //     'id' => 'required|exists.boards|integer'
        // ]);
        // if($validator->fails()){
        //     return redirect('/boards')->view('edit')->withErrors($validator);
        // }

        $arr = ['id'=>$id];
        // $req->merge($arr);
        $req->request->add($arr);

        // 마지 넘믹

        // $req->validate([
        //     'id' => 'required|integer'//v002 add
        //     ,'title' => 'required|between:3,30'
        //     ,'content' => 'required|max:1000'
        // ]);
        // v002 add end
        // $boards = Boards::where('id',$id)->update(['title'=>$req->input('title')
        // ,'content'=>$req->input('content')]);

        // $boards = Boards::find($id);

         // 유효성 검사 방법 2
        $validator = Validator::make(
            $req->only('id','title','content')
            ,[
                'id' => 'required|integer'
                ,'title' => 'required|between:3,30'
                ,'content' => 'required|max:1000'
            ]
        );
        if($validator->fails()){
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput($req->only('title','content'));
        }

        // return redirect()->route('boards.show',['board'=>$id]);

        $result = Boards::find($id);
        $result->title=$req->title;
        $result->content=$req->content;
        $result->save();
        return view('detail')->with('data',Boards::find($id));

        // return redirect('/boards/'.$id);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //destory는 pk를 받아서 삭제, delete는 soft delete지원 하는 함수
    {
        Boards::where('id',$id)->firstOrFail()->delete();
        return redirect('/boards');
    }
}