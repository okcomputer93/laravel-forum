<?php


namespace App\Models;


trait Favoritable
{

    /**
     * Accessor to count all favorites replies.
     * @return int
     */
    public function getFavoritesCountAttribute(): int
    {
        return $this->favorites->count();
    }

    /**
     * Determine if the current reply has been favorited.
     * @return bool
     */
    public function isFavorited(): bool
    {
        return !!$this->favorites
            ->where('user_id', auth()->id())
            ->count();
    }

    /**
     * Favorite the current reply.
     */
    public function favorite()
    {
        $this->favorites()->create([
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Morphing relationship with favorites.
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}