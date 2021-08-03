<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function store(Reply $reply, Request $request)
    {
        $this->authorize(
            'favorite-reply',
            [Favorite::class, $reply]
        );

        $reply->favorite();

        if ($request->wantsJson()) {
            return  response(['status' => 'Reply favorited']);
        }

        return back();
    }

    public function destroy(Reply $reply, Request $request)
    {
        $reply->unfavorite();

        if ($request->wantsJson()) {
            return  response(['status' => 'Reply unfavorited']);
        }

        return back();
    }
}
