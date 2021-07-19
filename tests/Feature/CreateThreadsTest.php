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

        $thread = raw(Thread::class);

        $this->post('/threads', $thread);
    }

    /** @test */
    public function guests_cannot_see_the_create_thread_page()
    {
          $this->get('/threads/create')
              ->assertRedirect('/login');
    }



    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = raw(Thread::class);

        $this->post('/threads', $thread);

        $thread = Thread::first();

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
