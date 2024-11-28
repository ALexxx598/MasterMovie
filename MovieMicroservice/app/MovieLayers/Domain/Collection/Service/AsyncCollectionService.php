<?php

namespace App\MovieLayers\Domain\Collection\Service;

use App\MovieLayers\Domain\Collection\Collection;
use App\MovieLayers\Domain\Collection\CollectionTypeEnum;
use App\MovieLayers\Domain\Collection\DPO\CollectionCreateDPO;
use App\MovieLayers\Domain\User\User;

use function Amp\async;

class AsyncCollectionService extends BaseCollectionService implements CollectionServiceInterface
{
    /**
     * @throws \App\MovieLayers\Domain\User\Exception\UserNotFoundException
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
            id: null,
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
        $userPromise = async(function () use ($userId, $collectionId): User {
            return $this->userService->findUser($userId);
        });

        $collectionPromise = async(function () use ($userId, $collectionId): Collection {
            return $this->findById($collectionId);
        });

        /** @var Collection $collection **/
        $collection = $collectionPromise->await();

        /** @var User $user **/
        $user = $userPromise->await();

        if ($user->isAdmin() && $collection->isDefault()) {
            $this->delete($collectionId);
        }

        if ($user->isViewer() && $collection->isCustom() && $collection->isBelongToUser($user->getId())) {
            $this->delete($collectionId);
        }
    }
}
