<?php

namespace App\Models;

class Media extends BaseModel
{
    protected $fillable = [
        'user_id',
        'link',
        'name',
    ];

    protected $appends = ['source'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSourceAttribute()
    {
        return config('app.url') . '/api/media/' . $this->id . '/content';
    }
}
