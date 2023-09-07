<?php

declare(strict_types=1);

namespace App\Integration\OpenAI\ValueObject;

use DomainException;
use JsonSerializable;

class Messages implements JsonSerializable
{
    /**
     * @var Message[]
     */
    private array $messages = [];

    private bool $hasSystemMessage = false;

    /**
     * @param Message[] $messages
     */
    public function __construct(
        array $messages
    ) {
        if (empty($messages)) {
            throw new DomainException('Messages cannot be empty');
        }

        foreach ($messages as $message) {
            $this->addMessage($message);
        }
    }

    /**
     * @return Message[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function addMessage(Message $message): void
    {
        if (!$message->isSystem()) {
            $this->messages[] = $message;

            return;
        }

        if ($this->hasSystemMessage) {
            throw new DomainException('Only one system message is allowed');
        }

        $this->hasSystemMessage = true;
        array_unshift($this->messages, $message);
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_map(
            static fn (Message $message): array => $message->jsonSerialize(),
            $this->messages
        );
    }
}
