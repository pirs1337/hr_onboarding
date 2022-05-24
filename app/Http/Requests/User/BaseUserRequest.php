<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\Models\Role;
use App\Services\ScriptService;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class BaseUserRequest extends Request
{
    protected function checkScriptsExists()
    {
        $scriptsIds = $this->input('scripts', []);

        $scripts = app(ScriptService::class)->getByList($scriptsIds);

        if (count($scripts) !== count(array_unique($scriptsIds))) {
            throw new UnprocessableEntityHttpException('One of provided scripts does not exists.');
        }
    }

    protected function checkRole()
    {
        if ($this->role_id == Role::ADMIN) {
            throw new UnprocessableEntityHttpException(
                'Error: cannot create a user with the administrator role'
            );
        }
    }
}
