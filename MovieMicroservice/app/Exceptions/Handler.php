<?php

namespace App\Exceptions;

use App\Common\CanNotDeleteException;
use App\Common\NotFoundException;
use App\Exceptions\ErrorCodes;
use App\MovieLayers\Domain\Movie\Exception\InvalidImageUrlException;
use App\MovieLayers\Domain\Movie\Exception\InvalidMovieUrlException;
use App\MovieLayers\Domain\User\Exception\NonValidPasswordException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse|Response|RedirectResponse
    {
        return match (true) {
            $e instanceof NonValidPasswordException => $this->mapNonValidPasswordException($e),
            $e instanceof NotFoundException => $this->mapNotFoundException($e),
            $e instanceof CanNotDeleteException => $this->mapCanNotDeleteException($e),
            $e instanceof InvalidMovieUrlException => $this->mapInvalidMovieUrl($e),
            $e instanceof InvalidImageUrlException => $this->mapInvalidImageUrl($e),
            default => parent::render($request, $e),
        };
    }

    /**
     * @param Exception|Throwable $e
     * @return JsonResponse
     */
    private function mapByDefault(Exception|Throwable $e): JsonResponse
    {
        return response()->json(
            [
                'message' => $e->getMessage(),
                'error_code' => $e->getCode(),
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * @param NonValidPasswordException $e
     * @return JsonResponse
     */
    private function mapNonValidPasswordException(NonValidPasswordException $e): JsonResponse
    {
        return response()->json([
            'message' => $e->getMessage(),
            'error' => ErrorCodes::NON_VALID_PASSWORD->value,
            'error_code' => ErrorCodes::NON_VALID_PASSWORD,
        ], Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @param NotFoundException $e
     * @return JsonResponse
     */
    private function mapNotFoundException(NotFoundException $e): JsonResponse
    {
        return response()->json([
            'message' => $e->getMessage(),
            'error' => ErrorCodes::NOT_FOUND->value,
            'error_code' => ErrorCodes::NOT_FOUND,
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param CanNotDeleteException $e
     * @return JsonResponse
     */
    private function mapCanNotDeleteException(CanNotDeleteException $e): JsonResponse
    {
        return response()->json([
            'message' => $e->getMessage(),
            'error' => ErrorCodes::CAN_NOT_REMOVE_MODEL->value,
            'error_code' => ErrorCodes::CAN_NOT_REMOVE_MODEL,
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param InvalidMovieUrlException $e
     * @return JsonResponse
     */
    private function mapInvalidMovieUrl(InvalidMovieUrlException $e): JsonResponse
    {
        return response()->json([
            'message' => $e->getMessage(),
            'error' => ErrorCodes::INVALID_MOVIE_URL->value,
            'error_code' => ErrorCodes::INVALID_MOVIE_URL,
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param InvalidImageUrlException $e
     * @return JsonResponse
     */
    private function mapInvalidImageUrl(InvalidImageUrlException $e): JsonResponse
    {
        return response()->json([
            'message' => $e->getMessage(),
            'error' => ErrorCodes::INVALID_IMAGE_URL->value,
            'error_code' => ErrorCodes::INVALID_IMAGE_URL,
        ], Response::HTTP_BAD_REQUEST);
    }
}
