<?php

namespace App\MovieLayers\Domain\Collection\Service;

use App\MovieLayers\Domain\Collection\Collection;
use App\MovieLayers\Domain\Collection\CollectionTypeEnum;
use App\MovieLayers\Domain\Collection\DPO\CollectionCreateDPO;
use App\MovieLayers\Domain\User\Exception\UserNotFoundException;

class CollectionService extends BaseCollectionService implements CollectionServiceInterface
{
    /**
     * @param CollectionCreateDPO $payload
     * @return Collection
     * @throws UserNotFoundException
     */
    public function create(CollectionCreateDPO $payload): Collection
    {
        $user = $this->userService->findUser($payload->getUserId());

        $type = match (true) {
            $user->isAdmin() => CollectionTypeEnum::DEFAULT,
            $user->isViewer() => CollectionTypeEnum::CUSTOM,
            default => CollectionTypeEnum::TEST,
        };

        $collection = new Collection(
            userId: $payload->getUserId(),
            type: $type,
            name: $payload->getName()
        );

        return $collection->setId($this->collectionRepository->save($collection));
    }

    /**
     * @inheritDoc
     */
    public function deleteWithPermissionCheck(int $userId, int $collectionId): void
    {
        $user = $this->userService->findUser($userId);
        $collection = $this->findById($collectionId);

        if ($user->isAdmin() && $collection->isDefault()) {
            $this->delete($collectionId);
        }

        if ($user->isViewer() && $collection->isCustom() && $collection->isBelongToUser($user->getId())) {
            $this->delete($collectionId);
        }
    }
}