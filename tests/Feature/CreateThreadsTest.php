<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    function guests_may_not_create_threads()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        
        $thread = factory('App\Thread')->make();

        $this->post('threads', $thread->toArray());
    }


    /** @test */
    function guests_cannot_see_the_create_threads_page()
    {
        $this->get('/threads/create')
                ->assertRedirect('login');
    }


    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $this->post('threads', $thread->toArray());

        $this->get($thread->path())
                ->assertSee($thread->title)
                ->assertSee($thread->body);
    }
}