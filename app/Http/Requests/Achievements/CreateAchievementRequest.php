<?php

namespace App\Http\Requests\Achievements;

use App\Http\Requests\Request;

class CreateAchievementRequest extends Request
{
    public function rules(): array
    {
        return [
            'script_id' => 'required|exists:scripts,id',
            'title' => 'required|string|min:1|max:255|unique:achievements',
            'incomplete_cover_id' => 'required|exists:media,id',
            'complete_cover_id' => 'required|exists:media,id',
            'incomplete_message' => 'required|string',
            'complete_message' => 'required|string'
        ];
    }
}
