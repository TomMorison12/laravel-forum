<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    public function test_unauthenticated_users_can_not_participate_in_forum() {
        $this->expectException('Illuminate\Auth\Authenticationexception');

        $thread =  factory('App\Thread')->create();
        $reply = factory('App\Reply')->create();
        $this->post($thread->path().'/replies', $reply->toArray());

    }

    public function test_an_authenticated_user_can_participate_in_forum_threads() {
        $user =factory('App\User')->create();
        $this->be($user);
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create();
        $this->post($thread->path().'/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }

    public function test_a_reply_requires_a_body() {

        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path().'/replies', $reply->toArray())
            ->assertSessionhasErrors('body');

    }
}