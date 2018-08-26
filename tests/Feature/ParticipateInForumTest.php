<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;


    function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
        $this->reply = factory('App\Reply')->make();
    }


    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post($this->thread->path() . '/replies', []);
    }
    

    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = factory('App\User')->create());

        $this->post($this->thread->path() . '/replies', $this->reply->toArray());

        $this->get($this->thread->path())
                ->assertSee($this->reply->body);
    }
}
