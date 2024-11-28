<?php

namespace App\MovieLayers\Domain\Movie\Exception;

use Exception;

class InvalidImageUrlException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Invalid image url.';
}
