<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create(User::class);

        $this->get('/profiles/' . $user->name)
            ->assertSee($user->name);
    }

    /** @test */
    public function profiles_display_all_threads_created_by_the_associated_user()
    {
        $this->signIn();

        $this->withoutExceptionHandling();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->get('/profiles/' . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
