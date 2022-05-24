<?php

namespace App\Http\Requests\User;

class CreateUserRequest extends BaseUserRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|min:10|max:15|unique:users,phone',
            'position' => 'required|string|max:255',
            'starts_on' => 'required|date_format:Y-m-d',
            'role_id' => 'nullable|int|exists:roles,id',
            'hr_id' => 'nullable|int|exists:users,id',
            'manager_id' => 'nullable|int|exists:users,id',
            'lead_id' => 'nullable|int|exists:users,id',
            'is_onboarding_required' => 'boolean',
            'avatar_id' => 'required|exists:media,id',
            'scripts' => 'array',
            'scripts.*' => 'integer'
        ];
    }

    public function validateResolved()
    {
        parent::validateResolved();

        $this->checkRole();

        $this->checkScriptsExists();
    }
}
