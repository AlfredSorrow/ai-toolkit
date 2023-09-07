<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Migration\AppSettingMigration;
use App\SettingService;

final class Version20230906205809 extends AppSettingMigration
{
    protected function getSettingId(): string
    {
        /* @see SettingService::OPENAI_TOKEN */
        return 'openai_token';
    }
}
