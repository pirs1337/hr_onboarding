<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class SearchUsersRequest extends Request
{
    public function rules(): array
    {
        return [
            'roles_ids' => 'array',
            'roles_ids.*' => 'int',
            'per_page' => 'int|min:1|max:100',
            'page' => 'int|min:1'
        ];
    }
}
