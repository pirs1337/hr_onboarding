<?php

use App\Models\Role;

return [
    'permitted_media_types' => ['jpg', 'png'],
    'items_per_page' => 20,

    /*
    |--------------------------------------------------------------------------
    | Temp media link lifetime, minutes
    |--------------------------------------------------------------------------
    */
    'media_temp_link_lifetime' => 5,
    'access' => [
        'hr_onboarding' => [Role::EMPLOYEE],
        'hr_management' => [Role::ADMIN, Role::MANAGER],
    ],
    'app_name_header' => 'x-app-name'
];
