<?php

namespace App\MovieLayers\Domain\Movie\Exception;

use App\Common\NotFoundException;

class MovieEntityNotFoundException extends NotFoundException
{
    /**
     * @var string
     */
    protected $message = 'Not found movie';
}
