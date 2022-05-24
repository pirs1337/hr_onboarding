<?php

namespace App\Http\Requests\Achievements;

use App\Http\Requests\Request;

class SearchAchievementsRequest extends Request
{
    public function rules(): array
    {
        return [
            'page' => 'integer',
            'per_page' => 'integer',
            'all' => 'integer',
            'order_by' => 'string',
            'desc' => 'boolean',
            'query' => 'string|nullable',
        ];
    }
}
