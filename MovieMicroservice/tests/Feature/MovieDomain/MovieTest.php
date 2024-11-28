<?php

namespace Tests\Feature\MovieDomain;

use App\MovieLayers\Domain\Role\RoleTypeEnum;
use Tests\ApiTestCase;
use Tests\Feature\MovieDomain\User\UserModelTrait;

class MovieTest extends ApiTestCase
{
    use UserModelTrait;

    public function testCreate(): void
    {
        $user = $this->makeUser(role: RoleTypeEnum::ADMIN());

        $response = $this->post(
            'api/movie/',
            [
                'name' => $this->faker->word,
                'description' => [
                    'someInfo' => $this->faker->word, // TODO: make data
                ],
                'storage_movie_link' => $this->faker->url,
                'storage_image_link' => $this->faker->imageUrl,
            ],
            [
                'authorization' => $this->getUserToken($user),
            ]
        );

        $response->assertOk();
    }
}
