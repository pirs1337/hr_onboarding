<?php

namespace App\Http\Requests\Achievements;

class UpdateAchievementRequest extends BaseAchievementRequest
{
    public function rules(): array
    {
        return [
            'title' => 'string|min:1|max:255|unique:achievements,title,' . $this->id,
            'incomplete_cover_id' => 'exists:media,id',
            'complete_cover_id' => 'exists:media,id',
            'incomplete_message' => 'string',
            'complete_message' => 'string'
        ];
    }
}
