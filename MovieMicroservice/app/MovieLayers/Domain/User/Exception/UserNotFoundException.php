<?php

namespace App\MovieLayers\Domain\User\Exception;

use App\Common\NotFoundException;

class UserNotFoundException extends NotFoundException
{
    /**
     * @var string
     */
    protected $message = 'Not found user';
}
