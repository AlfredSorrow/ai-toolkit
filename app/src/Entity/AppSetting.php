<?php

declare(strict_types=1);

namespace App\Entity;

use App\Encryption\Crypto;
use App\Entity\Interface\EntityInterface;
use App\Repository\AppSettingRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: AppSettingRepository::class)]
class AppSetting implements EntityInterface
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(type: Types::TEXT)]
    private string $value = '';

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column]
    private DateTimeImmutable $updatedAt;

    #[ORM\Column(type: Types::TEXT, options: ['default' => ''])]
    private string $description = '';

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

    public function hasId(): bool
    {
        return isset($this->id);
    }

    public function getValue(): string
    {
        return Crypto::decrypt($this->value);
    }

    public function setValue(string $value): void
    {
        $this->value = Crypto::encrypt($value);
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
