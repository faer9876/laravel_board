<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Boards;
use Illuminate\Support\Facades\DB;

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
        $boards = Boards::where('id',$id)->update(['title'=>$req->input('title')
        ,'content'=>$req->input('content')]);

        $boards = Boards::find($id);

        return redirect('/boards/'.$id);
        // return redirect()->route('boards.show',['board'=>$id]);

        // $result = Boards::find($id);
        // $result->title=$request->title;
        // $result->contnent=$request->contest;
        // $result->save();
        // return view('detail')->with('data',Boards::findOfFail($id));
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