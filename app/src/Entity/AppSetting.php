<?php

declare(strict_types=1);

namespace App\Entity;

use App\Encryption\Crypto;
use App\Repository\AppSettingRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\Entity(repositoryClass: AppSettingRepository::class)]
class AppSetting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(type: Types::TEXT)]
    private string $value = '';

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column]
    private DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $value,
    ) {
        $this->id = $id;
        $this->setValue($value);

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getValue(): string
    {
        // FIXME: This is a hack to get around the fact that the database is already populated with unencrypted values.
        try {
            return Crypto::decrypt($this->value);
        } catch (Exception) {
            return $this->value;
        }
    }

    public function setValue(string $value): void
    {
        $this->value = Crypto::encrypt($value);
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
