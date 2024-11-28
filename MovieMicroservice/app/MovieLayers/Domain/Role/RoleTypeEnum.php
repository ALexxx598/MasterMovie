<?php

namespace App\MovieLayers\Domain\Role;

enum RoleTypeEnum: string
{
    case VIEWER = 'VIEWER';
    case ADMIN = 'ADMIN';
}
