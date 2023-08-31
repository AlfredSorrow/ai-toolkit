<?php

declare(strict_types=1);

namespace App\Entity\Interface;

interface EntityInterface
{
    public function hasId(): bool;

    public function getId(): mixed;
}
