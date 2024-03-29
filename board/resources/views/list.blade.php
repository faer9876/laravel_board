@extends('layout.layout')

@section('list','Login')

@section('contents')
    <a href="{{ route('boards.create') }}">작성하기</a>

<br><br>

<table>
    <tr>
        <th>글번호</th>
        <th>글제목</th>
        <th>조회수</th>
        <th>등록일</th>
        <th>수정일</th>
    </tr>
@forelse($datas as $item)
    <tr>
    <td>{{$item->id}}</td>
    <td><a href="{{ route('boards.show',['board'=>$item->id])}} ">{{$item->title}}</td></a>
    <td>{{$item->hits}}</td>
    <td>{{$item->created_at}}</td>
    <td>{{$item->updated_at}}</td>
    </tr>

@empty
    <tr>
    <td></td>
    <td>게시글 없음</td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
@endforelse
</table>
@endsection



