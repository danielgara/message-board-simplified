<?php

namespace App\Http\Controllers\V1\Auth;

use App\DTOs\UserDTO;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends BaseController
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create a user in storage and returns token
     */
    public function create(CreateUserRequest $request): JsonResponse
    {
        try {
            $userObject = UserDTO::fromRequest($request);
            $user = $this->userRepository->save($userObject);

            $responseData = [];
            $responseData['token'] = $user->createToken('auth_token')->plainTextToken;

            return $this->sendResponse($responseData, 201);
        } catch (Throwable $th) {
            $responseData = [];
            $responseData['message'] = $th->getMessage();

            return $this->sendResponseError($responseData, 500);
        }
    }

    /**
     * Login a user and returns token
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        try {
            if (! Auth::attempt($request->only(['email', 'password']))) {
                $responseData = [];
                $responseData['message'] = 'Email & Password does not match with our record.';

                return $this->sendResponseError($responseData, 401);
            }

            $user = Auth::user();
            $responseData = [];
            $responseData['token'] = $user->createToken('auth_token')->plainTextToken;

            return $this->sendResponse($responseData);
        } catch (Throwable $th) {
            $responseData = [];
            $responseData['message'] = $th->getMessage();

            return $this->sendResponseError($responseData, 500);
        }
    }

    /**
     * Returns a user by id
     */
    public function getUser(int $userId): JsonResponse
    {
        try {
            $user = $this->userRepository->getById($userId);

            if (is_null($user)) {
                $responseData = [];
                $responseData['message'] = 'User not found';

                return $this->sendResponseError($responseData);
            }

            $responseData = [];
            $responseData['user'] = new UserResource($user);

            return $this->sendResponse($responseData);
        } catch (Throwable $th) {
            $responseData = [];
            $responseData['message'] = $th->getMessage();

            return $this->sendResponseError($responseData, 500);
        }
    }
}
