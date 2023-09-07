<?php

declare(strict_types=1);

namespace App\Integration\OpenAI\ValueObject;

use App\Entity\Interface\ModelSettingInterface;

final readonly class OpenAIChatProfile implements ModelSettingInterface
{
    public function __construct(
        public Messages $messages,
        private int $presencePenalty,
        private int $frequencyPenalty,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'messages' => $this->messages->jsonSerialize(),
            'presencePenalty' => $this->presencePenalty,
            'frequencyPenalty' => $this->frequencyPenalty,
        ];
    }

    public static function fromSetting(array $setting): OpenAIChatProfile
    {
        $messages = [];

        foreach ($setting['messages'] ?? [] as $message) {
            $messages[] = new Message((string)($message['role'] ?? ''), (string)($message['content'] ?? ''));
        }

        return new self(new Messages($messages), $setting['presencePenalty'], $setting['frequencyPenalty']);
    }
}
