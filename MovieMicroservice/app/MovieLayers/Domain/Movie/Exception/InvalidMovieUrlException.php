<?php

namespace App\MovieLayers\Domain\Movie\Exception;

use Exception;

class InvalidMovieUrlException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Invalid movie url';
}
