<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;


    function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }


    /** @test */
    function guests_can_not_favorite_anything()
    {
        $this->post('replies/1/favorites')
                ->assertRedirect('/login');
    }


    /** @test */
    function an_authenticated_user_can_favorite_any_reply()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }


    /** @test */
    function an_authenticated_use_may_only_favorite_a_reply_once()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        try {
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Cannot favorite same reply more than once');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
