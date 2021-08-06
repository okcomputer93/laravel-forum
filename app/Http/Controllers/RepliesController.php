<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function store(Channel $channel, Thread $thread, Request $request)
    {
        $request->validate([
            'body' => ['required']
        ]);

        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        if ($request->expectsJson()) {
            // The key difference is that with() eager loads the related model up front,
            // immediately after the initial query (all(), first(), or find(x), for example);
            // when using load(), you run the initial query first, and then eager load the relation at some later point.
            return $reply->load('owner');
        }

        return redirect($thread->path())
            ->with('flash', 'Your reply has been left.');
    }

    public function update(Reply $reply, Request $request)
    {
        $this->authorize($reply);

        $reply->update(
            $request->validate([
                'body' => ['required']
            ])
        );
    }

    public function destroy(Reply $reply, Request $request)
    {
        $this->authorize($reply);

        $reply->delete();

        if ($request->wantsJson()) {
            return  response(['status' => 'Reply deleted']);
        }

        return back();
    }
}
