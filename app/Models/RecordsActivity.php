<?php


namespace App\Models;

use ReflectionClass;

trait RecordsActivity
{
    /**
     * Boot method for every model.
     */
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return;
        foreach (static::getActivitiesToRecord() as $event) {
           static::$event(function ($model) use ($event) {
               $model->recordActivity($event);
           });
       }
    }

    /**
     * Return an array of recordable activity events.
     * @return string[]
     */
    protected static function getActivitiesToRecord(): array
    {
        return ['created'];
    }

    /**
     * Return the type of activity.
     * @param string $event
     * @return string
     */
    protected function getActivityType(string $event): string
    {
        $type = strtolower((new ReflectionClass($this))->getShortName());
        return "{$event}_$type";
    }

    /**
     * Records into Activity model.
     * @param string $event
     */
    protected function recordActivity(string $event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    /**
     * Relationship with Activity.
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
