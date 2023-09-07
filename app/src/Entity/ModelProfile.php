<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\ModelSettingInterface;
use App\Entity\Interface\OwnedEnitityInterface;
use App\Integration\ModelSettingFactory;
use App\Repository\ModelProfileRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ModelProfileRepository::class)]
class ModelProfile implements OwnedEnitityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column]
    private DateTimeImmutable $updatedAt;

    /** @var array<string, mixed> */
    #[ORM\Column]
    private array $setting;

    public function __construct(
        #[ORM\Column]
        private string $name,

        #[ORM\ManyToOne]
        #[ORM\JoinColumn(nullable: false)]
        private readonly User $user,

        #[ORM\ManyToOne]
        #[ORM\JoinColumn(nullable: false)]
        private Model $model,

        ModelSettingInterface $setting,
    ) {
        $this->setSetting($setting);
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function hasId(): bool
    {
        return isset($this->id);
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getSetting(): ModelSettingInterface
    {
        return ModelSettingFactory::create($this->getModel(), $this->setting);
    }

    public function setSetting(ModelSettingInterface $setting): void
    {
        $this->setting = $setting->jsonSerialize();
    }

    public function getUser(): User
    {
        return $this->user;
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
