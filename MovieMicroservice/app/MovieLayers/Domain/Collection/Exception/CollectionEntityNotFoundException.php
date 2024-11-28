<?php

namespace App\MovieLayers\Domain\Collection\Exception;

use App\Common\NotFoundException;

class CollectionEntityNotFoundException extends NotFoundException
{
    protected $message = 'Not found movie collection.';
}
