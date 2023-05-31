<h2>Header</h2>
{{-- 로그인 중 --}}
    @auth
        <div><a href="{{ route('users.logout') }}">잘가</a></div>
    @endauth
    @auth
        <div><a href="{{ route('users.userEdit', ['id'=>session('id')]) }}">정보수정</a></div>
    @endauth

{{-- 비로그인 상태(인증x) --}}
    @guest
        <div><a href="{{ route('users.login') }}">들어와</a></div>
    @endguest
<hr>
