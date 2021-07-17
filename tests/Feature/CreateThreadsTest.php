<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_create_threats()
    {
        $this->withoutExceptionHandling();

        $this->expectException(AuthenticationException::class);
        
        $thread = Thread::factory()->raw();

        $this->post('/threads', $thread);
    }


    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->actingAs(User::factory()->create());

        $thread = Thread::factory()->raw();

        $this->post('/threads', $thread);

        $thread = Thread::first();

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
