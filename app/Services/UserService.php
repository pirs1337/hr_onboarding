<?php

namespace App\Services;

use App\Mail\PasswordSetup;
use App\Models\Role;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RonasIT\Support\Services\EntityService;

/**
 * @property UserRepository $repository
 */
class UserService extends EntityService
{
    public function __construct()
    {
        $this->setRepository(UserRepository::class);
    }

    public function login(array $data): ?string
    {
        if (!Auth::attempt($data)) {
           return null;
        }

        $tokenName = request()->ip();

        return request()->user()->createToken($tokenName)->plainTextToken;
    }

    public function search(array $filter): LengthAwarePaginator
    {
        return $this->repository
            ->searchQuery($filter)
            ->filterByList('role_id', 'roles_ids')
            ->getSearchResults();
    }

    public function create(array $data): Model
    {
        $data['role_id'] = $data['role_id'] ?? Role::EMPLOYEE;
        list($password, $hash) = $this->generatePassword();
        $data['password'] = $hash;
        $user = $this->repository->create($data);

        if (!empty($data['scripts'])) {
            $insertData = array_map(function ($scriptId) use ($user) {
                return [
                    'script_id' => $scriptId,
                    'user_id' => $user->id
                ];
            }, $data['scripts']);

            DB::table('script_user')->insert($insertData);
        }

        Mail::to($user)->send(new PasswordSetup($password));

        return $user;
    }

    protected function generatePassword(): array
    {
        $password = Str::random(8);

        return [$password, Hash::make($password)];
    }

    public function update($where, array $data): Model
    {
        $updatedUser = $this->repository->update($where, $data);

        if (!empty($data['scripts'])) {
            $updatedUser->scripts()->sync($data['scripts']);
        }

        return $updatedUser;
    }
}
