<?php

namespace App\Http\Requests\Scripts;

use App\Http\Requests\Request;

class CreateScriptRequest extends Request
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|unique:scripts|min:1|max:255',
            'description' => 'required|string|min:1',
            'cover_id' => 'required|exists:media,id'
        ];
    }
}
