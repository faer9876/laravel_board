@extends('layout.layout')

@section('title','Registration')

@section('contents')
    <form action="{{ route('users.registration.post') }}" method="post">
        @csrf
        @method('post')
        <h1>Registration</h1>
        @include('layout.errorsvalidate')
        <label for="name">Name : </label>
        <input type="text" name="name" id="name">
        <br>
        <label for="email">Email : </label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <br>
        <label for="passwordchk">Password : </label>
        <input type="passwordchk" name="passwordchk" id="passwordchk">
        <br><br>
        <button type="submit">Registration</button>
        <button type="button" onclick="location.href='{{ route('users.login') }}'">Cancel</button>
    </form>
@endsection
