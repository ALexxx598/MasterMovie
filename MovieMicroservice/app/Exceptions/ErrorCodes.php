<?php

namespace App\Exceptions;

enum ErrorCodes: int
{
    case NON_VALID_PASSWORD = 1010;
    case NOT_FOUND = 1011;
    case CAN_NOT_REMOVE_MODEL = 1012;
    case INVALID_MOVIE_URL = 1110;
    case INVALID_IMAGE_URL = 1111;
}
