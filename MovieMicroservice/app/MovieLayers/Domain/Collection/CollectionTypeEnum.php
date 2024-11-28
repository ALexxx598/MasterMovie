<?php

namespace App\MovieLayers\Domain\Collection;

enum CollectionTypeEnum: string
{
    case CUSTOM = 'CUSTOM';
    case DEFAULT = 'DEFAULT';
    case TEST = 'TEST';
}
