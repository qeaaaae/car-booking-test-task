<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/api/login',
        summary: 'Авторизация по email и паролю',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'manager@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password'),
                ],
            ),
        ),
        tags: ['Аутентификация'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Успешная авторизация',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'token', type: 'string', example: 'Bearer'),
                        new OA\Property(
                            property: 'user',
                            ref: '#/components/schemas/UserResource',
                        ),
                    ],
                ),
            ),
            new OA\Response(response: 422, description: 'Ошибка валидации'),
        ],
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('car_booking')->accessToken;

            return response()->json([
                'token' => $token,
                'user' => new UserResource($user),
            ]);
        }

        return response()->json('Неавторизован', 401);
    }

    #[OA\Post(
        path: '/api/auth/logout',
        description: 'Отзывает текущий токен доступа для выхода из системы',
        summary: 'Выход пользователя',
        security: [['bearerAuth' => []]],
        tags: ['Аутентификация'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Успешный выход',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Успешный выход из системы'),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Неавторизован',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Неавторизованный доступ'),
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Ошибка сервера',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Ошибка при выходе из системы'),
                    ]
                )
            ),
        ]
    )]
    public function logout()
    {
        auth()->user()->token()->revoke();

        return response()->json([
            'message' => 'Успешный выход из системы',
        ]);
    }
}