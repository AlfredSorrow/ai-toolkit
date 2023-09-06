<?php

declare(strict_types=1);

namespace App\Entity\Enum;

enum ModelType: string
{
    case Chat = 'chat';
    case TextToImage = 'text-to-image';
    case Unknown = 'unknown';
}
