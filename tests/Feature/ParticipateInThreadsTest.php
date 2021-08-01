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

    /** @test */
    public function unauthorized_users_cannot_delete_replies()
    {
        $reply = create(Reply::class);

        $this->delete("/replies/$reply->id")
            ->assertRedirect('login');

        $this->signIn();

        $this->delete("/replies/$reply->id")
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete("/replies/$reply->id")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->user()]);

        $this->patch("replies/$reply->id", [
            'body' => $body = 'Updated'
        ])->assertStatus(200);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $body]);
    }

    /** @test */
    public function unauthorized_users_cannot_update_replies()
    {
        $reply = create(Reply::class);

        $this->patch("/replies/$reply->id")
            ->assertRedirect('login');

        $this->signIn();

        $this->patch("/replies/$reply->id")
            ->assertStatus(403);
    }

    /** @test */
    public function update_a_reply_requires_a_body()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->patch("/replies/$reply->id", [
            'body' => null
        ])->assertSessionHasErrors('body');
    }

}
