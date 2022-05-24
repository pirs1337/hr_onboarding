<?php

namespace App\Models;

class Role extends BaseModel
{
    const ADMIN = 1;
    const MANAGER = 2;
    const EMPLOYEE = 3;

    protected $fillable = [
        'name',
        'display_name'
    ];
}
