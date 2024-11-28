<?php

namespace App\Http\Controllers;

use App\Http\Request\Movie\MovieCategoriesRequest;
use App\Http\Request\Movie\MovieCollectionsRequest;
use App\Http\Request\Movie\MovieDeleteRequest;
use App\Http\Request\Movie\MovieListRequest;
use App\Http\Request\Movie\MovieCreateRequest;
use App\Http\Resource\Movie\MovieListResource;
use App\Http\Resource\Movie\MovieResource;
use App\MovieLayers\Domain\Movie\Filter\MovieFilter;
use App\MovieLayers\Domain\Movie\DPO\MovieCategoryDPO;
use App\MovieLayers\Domain\Movie\DPO\MovieCollectionDPO;
use App\MovieLayers\Domain\Movie\DPO\MovieCreateDPO;
use App\MovieLayers\Domain\Movie\Service\MovieServiceInterface;
use App\MovieLayers\Domain\User\Token\UserTokenServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class MovieController extends Controller
{
    /**
     * @param MovieServiceInterface $movieService
     * @param UserTokenServiceInterface $userTokenService
     */
    public function __construct(
        private MovieServiceInterface $movieService,
        private UserTokenServiceInterface $userTokenService,
    ) {
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function get(int $id): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => MovieResource::make($this->movieService->findById($id))
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @param MovieListRequest $request
     * @return JsonResponse
     * @throws \App\MovieLayers\Domain\User\Exception\UserNotFoundException
     */
    public function list(MovieListRequest $request): JsonResponse
    {
        if ($request->getUserId() !== null && $request->getAuthHeader() == null) {
            throw new AccessDeniedException('You must be authorized !!!');
        }

        $filter = MovieFilter::make(
                userId: $request->getUserId() !== null
                    ? $this->userTokenService->getUserByToken($request->getAuthHeader())->getId()
                    : null,
                categoryIds: $request->getCategoryIds() !== null ? collect($request->getCategoryIds()) : null,
                collectionIds: $request->getCollectionIds() !== null
                    ? collect($request->getCollectionIds())
                    : null
            )
            ->setPage($request->getPage())
            ->setPerPage($request->getPerPage());

        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => MovieListResource::make($this->movieService->list($filter))
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @param MovieCreateRequest $request
     * @return JsonResponse
     * @throws \App\MovieLayers\Domain\Movie\Exception\InvalidImageUrlException
     * @throws \App\MovieLayers\Domain\Movie\Exception\InvalidMovieUrlException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(MovieCreateRequest $request): JsonResponse
    {
        $payload = MovieCreateDPO::make(
            name: $request->getName(),
            descriptionRating: $request->getDescriptionRating(),
            descriptionSlogan: $request->getDescriptionSlogan(),
            descriptionScreeningDate: $request->getDescriptionScreeningDate(),
            descriptionCountry: $request->getDescriptionCountry(),
            descriptionActors: $request->getDescriptionActors(),
            shortDescription: $request->getShortDescription(),
            storageMovieUrl: $request->getStorageMovieLink(),
            storageImageUrl: $request->getStorageImageLink()
        );

        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => MovieResource::make($this->movieService->create($payload))
        ], JsonResponse::HTTP_CREATED);
    }

    /**
     * @param MovieDeleteRequest $request
     * @return JsonResponse
     */
    public function delete(MovieDeleteRequest $request, int $movieId): JsonResponse
    {
        $this->movieService->delete($movieId);

        return response()->json([
            'status' => Response::HTTP_OK,
        ], JsonResponse::HTTP_CREATED);
    }

    /**
     * @param int $movieId
     * @param MovieCollectionsRequest $request
     * @return JsonResponse
     * @throws \App\MovieLayers\Domain\User\Exception\UserNotFoundException
     */
    public function updateCollections(MovieCollectionsRequest $request, int $movieId): JsonResponse
    {
        $payload = MovieCollectionDPO::make(
            userId: $request->getUserId(),
            movieId: $movieId,
            collectionIds: $request->getCollectionIds()
        );

        $this->movieService->syncCollections($payload);

        return response()->json([
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * @param int $movieId
     * @param MovieCategoriesRequest $request
     * @return JsonResponse
     * @throws \App\MovieLayers\Domain\User\Exception\UserNotFoundException
     */
    public function updateCategories(MovieCategoriesRequest $request, int $movieId): JsonResponse
    {
        $payload = MovieCategoryDPO::make(
            userId: $request->getUserId(),
            movieId: $movieId,
            categoryIds: $request->getCategoryIds()
        );

        $this->movieService->syncCategories($payload);

        return response()->json([
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * @param MovieCollectionsRequest $request
     * @param int $movieId
     * @return JsonResponse
     */
    public function updateDefaultCollections(MovieCollectionsRequest $request, int $movieId): JsonResponse
    {
        $payload = MovieCollectionDPO::make(
            userId: $request->getUserId(),
            movieId: $movieId,
            collectionIds: $request->getCollectionIds()
        );

        $this->movieService->syncDefaultCollections($payload);

        return response()->json([
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }
}
