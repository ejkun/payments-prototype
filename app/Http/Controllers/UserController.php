<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyUser;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return new JsonResponse(
            UserResource::collection($this->service->index())
        );
    }

    public function store(StoreUser $request): JsonResponse
    {
        return new JsonResponse(
            new UserResource(
                $this->service->store($request->validated())
            ),
            Response::HTTP_CREATED
        );
    }

    public function show(User $user): JsonResponse
    {
        return new JsonResponse(
            new UserResource($user)
        );
    }

    public function update(UpdateUser $request, User $user): JsonResponse
    {
        $this->service->update($user, $request->validated());

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function destroy(DestroyUser $request, User $user): JsonResponse
    {
        $request->validated();
        $this->service->destroy($user);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
