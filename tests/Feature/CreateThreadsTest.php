<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->post('/threads', [])
            ->assertRedirect('/login');

        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = raw(Thread::class);

        $this->post('/threads', $thread);

        $thread = Thread::first();

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }


    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        create(Channel::class);

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $thread = create(Thread::class);

        $this->delete($thread->path())
            ->assertRedirect('login');

        $this->signIn();

        $this->delete($thread->path())
            ->assertStatus(403);
    }


    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class);

        $this->signIn($user);

        $thread = create(Thread::class, ['user_id' => $user->id]);

        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $this->delete($thread->path())
            ->assertRedirect('/threads');

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }


    /**
     * Publish a thread as sign in.
     * @param array $overrides
     * @return \Illuminate\Testing\TestResponse
     */
    public function publishThread(array $overrides): \Illuminate\Testing\TestResponse
    {
        $this->signIn();

        $thread = raw(Thread::class, $overrides);

        return $this->post('/threads', $thread);
    }

}
