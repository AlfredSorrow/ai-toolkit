<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

use InvalidArgumentException;

final readonly class Token
{
    public function __construct(
        private string $token,
    ) {
        if (empty($token)) {
            throw new InvalidArgumentException('Token cannot be empty');
        }
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
