<?php

namespace App\MovieLayers\Domain\Category\DPO;

class CategoryCreateDPO
{
    /**
     * @param string $name
     */
    private function __construct(
        private string $name,
    ) {
    }

    /**
     * @param string $name
     * @return $this
     */
    public static function make(
        string $name,
    ): self {
        return new self(
            name: $name
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
