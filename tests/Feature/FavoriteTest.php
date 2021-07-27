<?php

namespace Tests\Feature;

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_favorite_anything()
    {
        $reply = create(Reply::class);

        $this->post('/replies/' . $reply->id . '/favorites')
            ->assertRedirect('login');
    }


    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('/replies/' . $reply->id . '/favorites');
        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }


}
