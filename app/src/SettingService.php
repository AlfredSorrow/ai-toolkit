<?php

declare(strict_types=1);

namespace App;

use App\Entity\ValueObject\Token;
use App\Repository\AppSettingRepository;
use InvalidArgumentException;

final readonly class SettingService
{
    private const OPENAI_TOKEN = 'openai_token';

    public function __construct(private AppSettingRepository $appSettingRepository)
    {
    }

    private function get(string $id): string
    {
        $appSetting = $this->appSettingRepository->find($id);

        if ($appSetting === null) {
            throw new InvalidArgumentException("AppSetting with id {$id} not found.");
        }

        return $appSetting->getValue();
    }

    public function getOpenAiTokent(): Token
    {
        return new Token($this->get(self::OPENAI_TOKEN));
    }
}
