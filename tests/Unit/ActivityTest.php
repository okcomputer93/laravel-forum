<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        create(Thread::class, ['user_id' => auth()->id()]);

        $this->travel(-1)->weeks();

        create(Thread::class, ['user_id' => auth()->id()]);

        $this->travelBack();

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
                now()->format('Y-m-d'),
        ));

        $this->assertTrue($feed->keys()->contains(
            now()->subWeek()->format('Y-m-d')
        ));

    }


}
