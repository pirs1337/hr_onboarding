<?php

namespace App\Models;

class Achievement extends BaseModel
{
    protected $fillable = [
        'script_id',
        'title',
        'incomplete_cover_id',
        'complete_cover_id',
        'incomplete_message',
        'complete_message'
    ];

    protected $hidden = ['pivot'];
}
