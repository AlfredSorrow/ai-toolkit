<?php

declare(strict_types=1);

namespace App\Entity\Enum;

enum ModelStatus: string
{
    case Enabled = 'enabled';
    case Disabled = 'disabled';
}
