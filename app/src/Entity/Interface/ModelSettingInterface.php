<?php

declare(strict_types=1);

namespace App\Entity\Interface;

use JsonSerializable;

interface ModelSettingInterface extends JsonSerializable
{
    /**
     * @param array<string, mixed> $setting
     */
    public static function fromSetting(array $setting): ModelSettingInterface;
}
