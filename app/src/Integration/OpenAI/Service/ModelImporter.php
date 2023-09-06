<?php

declare(strict_types=1);

namespace App\Integration\OpenAI\Service;

use App\Entity\Enum\ModelType;
use App\Entity\Model;
use App\Entity\Vendor;
use App\Integration\ClientFactory;
use App\Repository\VendorRepository;
use App\SettingService;
use Doctrine\ORM\EntityManagerInterface;
use OpenAI\Responses\Models\RetrieveResponse;

readonly class ModelImporter
{
    public function __construct(
        private ClientFactory $clientFactory,
        private SettingService $settingService,
        private VendorRepository $vendorRepository,
        private EntityManagerInterface $em
    ) {
    }

    public function import(): void
    {
        $models = $this->getModels();
        $vendor = $this->vendorRepository->find(Vendor::CODE_OPENAI);

        foreach ($models as $model) {
            foreach ($vendor->getModels() as $existingModel) {
                if ($existingModel->getCode() === $model->id) {
                    continue 2;
                }
            }

            $type = $this->guessType($model);
            $modelEntity = new Model($vendor, $model->id, $type);
            $this->em->persist($modelEntity);
        }

        $this->em->flush();
    }

    /**
     * @return RetrieveResponse[]
     */
    protected function getModels(): array
    {
        $token = $this->settingService->getOpenAiTokent()->getToken();

        return $this->clientFactory->openAI($token)->models()->list()->data;
    }

    private function guessType(RetrieveResponse $model): ModelType
    {
        $chatRegex = '/^gpt-[\d\.]/m';
        if (preg_match($chatRegex, $model->id)) {
            return ModelType::Chat;
        }

        return ModelType::Unknown;
    }
}
