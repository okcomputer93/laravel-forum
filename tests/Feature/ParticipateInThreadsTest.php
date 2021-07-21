<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->post('/threads/channel/1/replies', [])
            ->assertRedirect('/login');
    }


    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create(Thread::class);

        $reply = raw(Reply::class);

        $this->post($thread->path() . '/replies', $reply);

        $this->get($thread->path())
            ->assertSee($reply['body']);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $reply = raw(Reply::class, ['body' => null]);

        $this->post($thread->path() . '/replies', $reply)
            ->assertSessionHasErrors('body');
    }

}
