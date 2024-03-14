<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      title="User API",
 *      version="1.0.0",
 *      description="API для управления пользователями",
 *      @OA\Contact(
 *          email="support@example.com",
 *          name="Support Team"
 *      ),
 *      @OA\License(
 *          name="MIT",
 *          url="https://opensource.org/licenses/MIT"
 *      )
 * )
 */
class UserController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     summary="Get list of users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="List of users"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return $this->sendResponse(
            UserResource::collection($users)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     summary="Store a newly created user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User created successfully"
     *     )
     * )
     */
    public function store(UserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());
        return $this->sendResponse(
            new UserResource($user)
        );
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{user}",
     *     summary="Display the specified user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User details"
     *     )
     * )
     */
    public function show(User $user): JsonResponse
    {
        return $this->sendResponse(
            new UserResource($user)
        );
    }

    /**
     * @OA\Put(
     *     path="/api/v1/users/{user}",
     *     summary="Update the specified user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully"
     *     )
     * )
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $user->update($request->all());
        return $this->sendResponse(
            new UserResource($user)
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/users/{user}",
     *     summary="Remove the specified user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully"
     *     )
     * )
     */
    public function destroy(User $user): JsonResponse
    {
        return $this->sendResponse($user->delete());
    }
}
