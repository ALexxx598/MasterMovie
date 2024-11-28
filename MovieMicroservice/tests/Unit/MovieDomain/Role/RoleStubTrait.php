<?php

namespace Tests\Unit\MovieDomain\Role;

use App\MovieLayers\Domain\Role\Role;
use App\MovieLayers\Domain\Role\RoleTypeEnum;

trait RoleStubTrait
{
    /**
     * @param array $data
     * @return Role
     */
    public function makeRole(array $data = []): Role
    {
        $data = array_merge([
            'id' => $this->faker->numberBetween(),
            'userId' => $this->faker->numberBetween(),
            'roleType' => $this->faker->randomElement(RoleTypeEnum::toArray())
        ], $data);

        return new Role(
            id: $data['id'],
            userId: $data['userId'],
            role: $data['roleType'],
        );
    }
}
