<?php

namespace App\Models;

class Script extends BaseModel
{
    protected $fillable = [
        'title',
        'description',
        'cover_id'
    ];

    protected $hidden = ['pivot'];

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
}
