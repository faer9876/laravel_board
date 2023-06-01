<?php

namespace Tests\Feature;

use App\Models\Boards;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class BoardsTest extends TestCase
{
    // php artisan make:test BoardsTest
    // 이름의 끝이 Test로 끝나야함ㅋㅋ

    use RefreshDatabase; // 테스트 완료후 DB 초기화를 위한 트레이트
    use DatabaseMigrations; // DB 마이그레이션
    /**

     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_게스트_리다이렉트()
    {
        $response = $this->get('/boards');

        $response->assertRedirect('/users/login');
    }

    public function test_index_유저인증(){
        // 테스트용 유저 생성
        $user = new user(['email' => 'aa@aa.aa'
                        ,'name' =>'테스트'
                        ,'password' => 'asdasd@1'
                        ]);
        $user -> save();

        $response = $this->actingAs($user)->get('/boards');
        $this->assertAuthenticatedAs($user);
    }

    public function test_index_유저인증_뷰반환(){
        // 테스트용 유저 생성
        $user = new user(['email' => 'aa@aa.aa'
                        ,'name' =>'테스트'
                        ,'password' => 'asdasd@1'
                        ]);
        $user -> save();

        $response = $this->actingAs($user)->get('/boards');
        $response->assertViewIs('list');
    }

    public function test_index_유저인증_뷰반환_데이터확인(){
        // 테스트용 유저 생성
        $user = new user(['email' => 'aa@aa.aa'
                        ,'name' =>'테스트'
                        ,'password' => 'asdasd@1'
                        ]);
        $user -> save();

        $board1= new Boards(['title'=>'test1'
                            ,'content' => 'content1']);
        $board1->save();
        $board2= new Boards(['title'=>'test2'
        ,'content' => 'content2']);
        $board2->save();
        $response = $this->actingAs($user)->get('/boards');

        $response->assertViewHas('datas');
        $response->assertSee('test1');
        $response->assertSee('test2');

    }

}
