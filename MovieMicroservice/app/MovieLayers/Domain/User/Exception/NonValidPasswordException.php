<?php

namespace App\MovieLayers\Domain\User\Exception;

use Exception;

class NonValidPasswordException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Non valid password';
}
