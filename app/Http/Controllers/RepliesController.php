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

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

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
