<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /**
     * Register a user in storage and returns token
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());
        $user->password = Hash::make($user->password);
        $user->save();

        $responseData = [];
        $responseData['token'] = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse($responseData, 201);
    }

    /**
     * Login a user and returns token
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->only(['email', 'password']))) {
            $responseData = [];
            $responseData['message'] = 'Email & Password does not match with our record.';

            return $this->sendResponseError($responseData, 401);
        }

        $user = Auth::user();
        $responseData = [];
        $responseData['token'] = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse($responseData);
    }

    /**
     * Returns a user
     */
    public function getUser(User $user): JsonResponse
    {
        $responseData = [];
        $responseData['user'] = new UserResource($user);

        return $this->sendResponse($responseData);
    }
}
