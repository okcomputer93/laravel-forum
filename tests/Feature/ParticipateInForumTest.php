<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withoutExceptionHandling();

        $this->expectException(AuthenticationException::class);

        $this->post('/threads/1/replies', []);
    }


    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $reply = Reply::factory()->raw();

        $this->post($thread->path() . '/replies', $reply);

        $this->get($thread->path())
            ->assertSee($reply['body']);
    }
}
