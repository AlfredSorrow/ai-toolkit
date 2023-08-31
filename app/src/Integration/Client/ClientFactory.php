<?php

declare(strict_types=1);

namespace App\Integration\Client;

use App\Integration\Client\OpenAI\OpenAIClient;
use Psr\Log\LoggerInterface;

final readonly class ClientFactory
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function openAI(
        string $apiKey,
        string $organization = null
    ): OpenAIClient {
        return new OpenAIClient(
            $apiKey,
            $this->logger,
            $organization,
        );
    }
}
