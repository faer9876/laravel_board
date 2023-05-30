<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit</title>
</head>
<body>
    @if(count($errors)>0)
        @foreach($errors->all() as  $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif
    <form action="{{ route('boards.update',['board'=>$data->id]) }}" method="post">
        @csrf
        @method('put')
        <label for="title">제목</label>
        @if (count($errors)===0)
        <input type="text" name="title" id="title" value="{{ $data->title }}">
        @else
        <input type="text" name="title" id="title" value="{{ old('title') }}">
        @endif
        <br>
        <label for="content">내용</label>
        @if (count($errors)===0)
        <textarea name="content" id="content" >{{ $data->content }}</textarea>
        @else
        <textarea name="content" id="content" >{{ old('content') }}</textarea>
        @endif
        <button type="submit">수정</button>
        <br>
        <button type="button" onclick="location.href='{{ route('boards.show',['board'=> $data->id ]) }}'">취소</button>
    </form>
</body>
</html>
