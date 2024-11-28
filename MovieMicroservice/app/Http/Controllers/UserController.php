<?php

namespace App\Http\Controllers;

use App\Http\Request\User\UserGetRequest;
use App\Http\Request\User\UserPreRegisterRequest;
use App\Http\Request\User\UserRegistrationRequest;
use App\Http\Request\User\UserRequest;
use App\Http\Request\User\UserUpdateRequest;
use App\Http\Resource\User\UserResource;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use App\MovieLayers\Domain\User\DPO\UserCreateDPO;
use App\MovieLayers\Domain\User\DPO\UserUpdateDPO;
use App\MovieLayers\Domain\User\Service\UserServiceInterface;
use App\MovieLayers\Domain\User\Token\UserTokenServiceInterface;
use Illuminate\Http\Response;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class UserController
{
    /**
     * @param UserServiceInterface $userService
     * @param UserTokenServiceInterface $userTokenService
     */
    public function __construct(
        private UserServiceInterface $userService,
        private UserTokenServiceInterface $userTokenService,
    ) {
    }

    /**
     * @param UserPreRegisterRequest $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function preRegister(UserPreRegisterRequest $request): JsonResponse
    {
        $this->userService->preRegister($request->getEmail());

        return response()->json([
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * @param UserRegistrationRequest $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function register(UserRegistrationRequest $request): JsonResponse
    {
        return response()->json(
            [
                'status' => Response::HTTP_CREATED,
                'data' => UserResource::make(
                    $this->userService->create(
                        UserCreateDPO::make(
                            name: $request->getName(),
                            surname: $request->getSurname(),
                            email: $request->getEmail(),
                            password: $request->getUserPassword(),
                            emailConfirmationCode: $request->getEmailConfirmationCode()
                        )
                    )
                ),
            ], Response::HTTP_CREATED
        );
    }

    /**
     * @param UserGetRequest $request
     * @return JsonResponse
     * @throws \App\MovieLayers\Domain\User\Exception\NonValidPasswordException
     * @throws \App\MovieLayers\Domain\User\Exception\UserNotFoundException
     */
    public function login(UserGetRequest $request): JsonResponse
    {
        return response()->json(
            [
                'data' => UserResource::make(
                    $this->userService->getUserByEmailAndPassword(
                        $request->getEmail(),
                        $request->getUserPassword()
                    )
                ),
            ],
        );
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     * @throws \App\MovieLayers\Domain\User\Exception\UserNotFoundException
     */
    public function refresh(UserRequest $request): JsonResponse
    {
        $user = $this->userTokenService->getUserByToken($request->getAuthHeader());

        if ($user->getId() !== $request->getUserId()) {
            throw new AccessDeniedException('You must be authorized!!!');
        }

        return response()->json([
            'data' => UserResource::make($user)
        ]);
    }

    /**
     * @param UserUpdateRequest $request
     * @return JsonResponse
     * @throws \App\MovieLayers\Domain\User\Exception\UserNotFoundException
     */
    public function update(UserUpdateRequest $request): JsonResponse
    {
        return response()->json([
            'data' => UserResource::make(
                $this->userService->update(
                    new UserUpdateDPO(
                        id: $request->getUserId(),
                        name: $request->getName(),
                        surname: $request->getSurname()
                    )
                )
            ),
        ]);
    }
}
