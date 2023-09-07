<?php

declare(strict_types=1);

namespace App\Integration\OpenAI\ValueObject;

use DomainException;
use JsonSerializable;

final readonly class Message implements JsonSerializable
{
    public const ROLE_USER = 'user';
    public const ROLE_ASSISTANT = 'assistant';
    public const ROLE_SYSTEM = 'system';

    public const ROLES = [
        self::ROLE_USER,
        self::ROLE_ASSISTANT,
        self::ROLE_SYSTEM,
    ];

    public function __construct(
        public string $role,
        public string $content
    ) {
        if (!in_array($role, self::ROLES, true)) {
            throw new DomainException(sprintf('Invalid role "%s"', $role));
        }

        if (empty($this->content)) {
            throw new DomainException('Message cannot be empty');
        }
    }

    public function isSystem(): bool
    {
        return $this->role === self::ROLE_SYSTEM;
    }

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'role' => $this->role,
            'content' => $this->content,
        ];
    }
}
