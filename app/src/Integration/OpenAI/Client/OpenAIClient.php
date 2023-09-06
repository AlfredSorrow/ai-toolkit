<?php

declare(strict_types=1);

namespace App\Integration\OpenAI\Client;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use OpenAI\Contracts\ClientContract;
use OpenAI\Contracts\Resources\AudioContract;
use OpenAI\Contracts\Resources\ChatContract;
use OpenAI\Contracts\Resources\CompletionsContract;
use OpenAI\Contracts\Resources\EditsContract;
use OpenAI\Contracts\Resources\EmbeddingsContract;
use OpenAI\Contracts\Resources\FilesContract;
use OpenAI\Contracts\Resources\FineTunesContract;
use OpenAI\Contracts\Resources\FineTuningContract;
use OpenAI\Contracts\Resources\ImagesContract;
use OpenAI\Contracts\Resources\ModelsContract;
use OpenAI\Contracts\Resources\ModerationsContract;
use OpenAI\Factory;
use Psr\Log\LoggerInterface;

class OpenAIClient implements ClientContract
{
    private readonly ClientContract $client;

    public function __construct(
        private readonly string $apiKey,
        private readonly LoggerInterface $logger,
        private readonly ?string $organization = null,
    ) {
        $stack = HandlerStack::create();

        $stack->push(
            Middleware::log(
                $this->logger,
                new MessageFormatter(MessageFormatter::SHORT)
            )
        );

        $this->client = (new Factory())->withApiKey($this->apiKey)
            ->withOrganization($this->organization)
            ->withHttpClient(new Client(['handler' => $stack]))
            ->make();
    }

    public function completions(): CompletionsContract
    {
        return $this->client->completions();
    }

    public function chat(): ChatContract
    {
        return $this->client->chat();
    }

    public function embeddings(): EmbeddingsContract
    {
        return $this->client->embeddings();
    }

    public function audio(): AudioContract
    {
        return $this->client->audio();
    }

    public function edits(): EditsContract
    {
        return $this->client->edits();
    }

    public function files(): FilesContract
    {
        return $this->client->files();
    }

    public function models(): ModelsContract
    {
        return $this->client->models();
    }

    public function fineTuning(): FineTuningContract
    {
        return $this->client->fineTuning();
    }

    public function fineTunes(): FineTunesContract
    {
        return $this->client->fineTunes();
    }

    public function moderations(): ModerationsContract
    {
        return $this->client->moderations();
    }

    public function images(): ImagesContract
    {
        return $this->client->images();
    }
}
