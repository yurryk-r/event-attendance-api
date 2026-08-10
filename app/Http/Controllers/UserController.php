<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRoleRequest;

class UserController extends Controller
{
    #[OA\Get(
        path: '/users',
        operationId: 'getUsers',
        tags: ['Users'],
        summary: 'List users',
        description: 'Returns a list of all users. Requires administrator role.',
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Users retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                ref: '#/components/schemas/User'
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden'
            )
        ]
    )]
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return UserResource::collection(User::all());
    }

    #[OA\Patch(
        path: '/users/{user}/role',
        operationId: 'updateUserRole',
        tags: ['Users'],
        summary: 'Update user role',
        description: 'Updates the role of another user. Requires administrator role. An administrator cannot change their own role.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'user',
                description: 'User ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 2
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['role'],
                properties: [
                    new OA\Property(
                        property: 'role',
                        type: 'string',
                        enum: ['admin', 'manager', 'user'],
                        example: 'manager'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'User role updated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/User'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden'
            ),
            new OA\Response(
                response: 404,
                description: 'User not found'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            )
        ]
    )]
    public function updateRole(UpdateUserRoleRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update([
            'role' => $request->validated('role'),
        ]);

        return new UserResource($user);
    }

    #[OA\Delete(
        path: '/users/{user}',
        operationId: 'deleteUser',
        tags: ['Users'],
        summary: 'Delete user',
        description: 'Deletes another user. Requires administrator role. An administrator cannot delete themselves.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'user',
                description: 'User ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 2
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'User deleted'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden'
            ),
            new OA\Response(
                response: 404,
                description: 'User not found'
            )
        ]
    )]
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response()->noContent();
    }
}
