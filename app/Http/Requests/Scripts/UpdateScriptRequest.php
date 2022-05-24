<?php

namespace App\Http\Requests\Scripts;

class UpdateScriptRequest extends BaseScriptRequest
{
    public function rules(): array
    {
        return [
            'title' => 'string|min:1|max:255|unique:scripts,title,' . $this->id,
            'description' => 'string|min:1',
            'cover_id' => 'exists:media,id'
        ];
    }
}
