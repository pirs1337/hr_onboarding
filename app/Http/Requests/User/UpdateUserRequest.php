<?php

namespace App\Http\Requests\User;

use App\Services\UserService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateUserRequest extends BaseUserRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'string|min:2|max:255',
            'last_name' => 'string|min:2|max:255',
            'date_of_birth' => 'date_format:Y-m-d',
            'email' => 'email|unique:users,email,' . $this->id,
            'phone' => 'string|min:10|max:15|unique:users,phone,' . $this->id,
            'position' => 'string|max:255',
            'starts_on' => 'date_format:Y-m-d',
            'role_id' => 'nullable|int|exists:roles,id',
            'hr_id' => 'nullable|int|exists:users,id',
            'manager_id' => 'nullable|int|exists:users,id',
            'lead_id' => 'nullable|int|exists:users,id',
            'is_onboarding_required' => 'boolean',
            'avatar_id' => 'exists:media,id',
            'scripts' => 'array',
            'scripts.*' => 'integer'
        ];
    }

    public function validateResolved()
    {
        $this->checkExistsUser();

        parent::validateResolved();

        $this->checkRole();

        $this->checkScriptsExists();
    }

    protected function checkExistsUser()
    {
        $user = app(UserService::class)->find($this->route('id'));

        if (empty($user)) {
            throw new NotFoundHttpException("User doesn't exists");
        }
    }
}
