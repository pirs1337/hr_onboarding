<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\SearchUsersRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserController extends Controller
{
    public function login(LoginRequest $request, UserService $userService): JsonResponse
    {
        $data = $request->validated();
        $token = $userService->login($data);

        if (empty($token)) {
            return response()->json([
                'message' => 'Error: unknown user name or bad password'
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (!Gate::allows('login')) {
            throw new AccessDeniedHttpException();
        }

        return response()->json([
            'token' => $token,
            'user' => $request->user()
        ]);
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
    }

    public function search(SearchUsersRequest $request, UserService $userService): JsonResponse
    {
        $filter = $request->validated();
        $users = $userService->search($filter);

        return response()->json($users);
    }

    public function profile(): JsonResponse
    {
        return response()->json(request()->user());
    }

    public function create(CreateUserRequest $request, UserService $userService): JsonResponse
    {
        $data = $request->onlyValidated();
        $user = $userService->create($data);

        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, UserService $userService, $id)
    {
        $userService->update($id, $request->onlyValidated());

        return response('', Response::HTTP_NO_CONTENT);
    }
}
