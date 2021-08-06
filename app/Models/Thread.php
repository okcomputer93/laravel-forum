<?php

namespace App\Models;

use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory, RecordsActivity;

    protected $fillable = ['user_id', 'title', 'body', 'channel_id'];

    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function (Builder $query) {
            $query->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies->each(function (Reply $reply) {
               $reply->favorites->each->delete();
               $reply->delete();
            });
        });
    }

    public function scopeFilter(Builder $query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/$this->id";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function addReply(array $reply)
    {
        $reply = array_merge(
            $reply,
            ['thread_id' => $this->id]
        );

        return $this->replies()->forceCreate($reply);
    }
}
