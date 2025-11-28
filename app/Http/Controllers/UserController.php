<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Get(
        path: '/api/auth/me',
        description: 'Возвращает данные текущего авторизованного пользователя',
        summary: 'Получить данные текущего пользователя',
        security: [['bearerAuth' => []]],
        tags: ['Аутентификация'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Успешное выполнение',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'user',
                            ref: '#/components/schemas/UserResource'
                        ),
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
        ]
    )]
    public function me(Request $request)
    {
        return response()->json([
            'user' => new UserResource(auth()->user()),
        ]);
    }
}