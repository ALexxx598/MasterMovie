<?php

namespace App\Common;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieMicroserviceResource extends JsonResource
{
    /**
     * @inheritDoc
     */
    public static $wrap = null;

    /**
     * @inheritDoc
     */
    public function toArray($request): array
    {
        return [];
    }
}