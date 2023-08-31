<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Model;
use App\Entity\Vendor;
use App\Integration\Client\ClientFactory;
use App\Repository\VendorRepository;
use App\SettingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import:models',
    description: 'Import models from API',
)]
final class ImportModelsCommand extends Command
{
    public function __construct(
        private readonly ClientFactory $clientFactory,
        private readonly SettingService $settingService,
        private readonly VendorRepository $vendorRepository,
        private readonly EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $token = $this->settingService->getOpenAiTokent()->getToken();
        $client = $this->clientFactory->openAI($token);
        $models = $client->models()->list()->data;
        $vendor = $this->vendorRepository->find(Vendor::CODE_OPENAI);

        foreach ($models as $model) {
            foreach ($vendor->getModels() as $existingModel) {
                if ($existingModel->getCode() === $model->id) {
                    continue 2;
                }
            }

            $modelEntity = new Model($vendor, $model->id);
            $this->em->persist($modelEntity);
        }

        $this->em->flush();

        return Command::SUCCESS;
    }
}
