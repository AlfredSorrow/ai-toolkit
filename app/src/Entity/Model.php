<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\ModelStatus;
use App\Entity\Enum\ModelType;
use App\Entity\Interface\EntityInterface;
use App\Repository\ModelRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ModelRepository::class)]
#[UniqueEntity(fields: ['code', 'vendor'], message: 'There is already a model with this code')]
class Model implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'models')]
    #[ORM\JoinColumn(nullable: false)]
    private Vendor $vendor;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column]
    private DateTimeImmutable $updatedAt;

    #[ORM\Column]
    private string $code;

    #[ORM\Column]
    private string $name;

    #[ORM\Column(enumType: ModelType::class, options: ['default' => ModelType::Unknown->value])]
    private ModelType $type;

    #[ORM\Column(enumType: ModelType::class, options: ['default' => ModelStatus::Disabled->value])]
    private ModelStatus $status;

    public function __construct(Vendor $vendor, string $code, ModelType $type = ModelType::Unknown)
    {
        $this->vendor = $vendor;
        $this->code = $code;
        $this->name = $code;
        $this->type = $type;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->status = ModelStatus::Disabled;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function hasId(): bool
    {
        return isset($this->id);
    }

    public function getVendor(): Vendor
    {
        return $this->vendor;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * boolean - thanks to Sonata, because it cannot render enum type yet, and thanks to PHP because it restricts toString on enum.
     */
    public function getType(bool $asValue = true): ModelType|string
    {
        if ($asValue) {
            return $this->type->value;
        }

        return $this->type;
    }

    public function setType(ModelType $type): void
    {
        $this->type = $type;
    }

    /**
     * boolean - thanks to Sonata, because it cannot render enum type yet, and thanks to PHP because it restricts toString on enum.
     */
    public function getStatus(bool $asValue = true): ModelStatus|string
    {
        if ($asValue) {
            return $this->status->value;
        }

        return $this->status;
    }

    public function setStatus(ModelStatus $status): void
    {
        $this->status = $status;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
