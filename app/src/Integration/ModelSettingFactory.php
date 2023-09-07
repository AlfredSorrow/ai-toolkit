<?php

declare(strict_types=1);

namespace App\Integration;

use App\Entity\Interface\ModelSettingInterface;
use App\Entity\Model;
use App\Integration\OpenAI\ValueObject\OpenAIChatProfile;
use DomainException;

class ModelSettingFactory
{
    /** @param array<string, mixed> $setting */
    public static function create(Model $model, array $setting): ModelSettingInterface
    {
        if ($model->getType(false)->isChat() && $model->getVendor()->isOpenAi()) {
            $type = OpenAIChatProfile::class;
        } else {
            throw new DomainException('Undefined setting');
        }

        return $type::fromSetting($setting);
    }
}
