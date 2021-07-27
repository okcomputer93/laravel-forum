<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = Thread::factory()->create();
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertStatus(200)
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);

    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = create(Reply::class, [
            'thread_id' => $this->thread->id
        ]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $this->withoutExceptionHandling();

        $channel = create(Channel::class);

        $threadInChannel = create(Thread::class, [
            'channel_id' => $channel->id
        ]);

        $threadNotInChannel = create(Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->withoutExceptionHandling();
        $this->signIn(create(User::class, ['name' => 'Jhon Doe']));

        $threadByJhon = create(Thread::class, ['user_id' => auth()->id()]);

        $threadNotByJhon = create(Thread::class);

        $this->get('threads?by=Jhon Doe')
            ->assertSee($threadByJhon->title)
            ->assertDontSee($threadNotByJhon->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithThreeReplies = create(Thread::class);
        create(Reply::class, [
            'thread_id' => $threadWithThreeReplies->id
        ], 3);

        $this->travel(1)->minutes();

        $threadWithNoReplies = $this->thread;

        $this->travel(1)->minutes();

        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class, [
            'thread_id' => $threadWithTwoReplies->id
        ], 2);

        $this->get('threads?popular=1')
            ->assertSeeInOrder([
                $threadWithThreeReplies->title,
                $threadWithTwoReplies->title,
                $threadWithNoReplies->title
            ]);
    }


}
