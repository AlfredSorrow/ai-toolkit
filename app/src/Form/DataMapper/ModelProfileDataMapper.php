<?php

declare(strict_types=1);

namespace App\Form\DataMapper;

use App\Entity\ModelProfile;
use App\Entity\User;
use App\Integration\ModelSettingFactory;
use App\Integration\OpenAI\ValueObject\Message;
use App\Repository\ModelRepository;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormInterface;
use Traversable;

final readonly class ModelProfileDataMapper implements DataMapperInterface
{
    public function __construct(
        private User $user,
        private ModelRepository $modelRepository
    ) {
    }

    /**
     * @param ModelProfile|null          $data
     * @param Traversable<FormInterface> $forms
     */
    public function mapDataToForms($data, $forms): void
    {
        if ($data?->hasId()) {
            $forms = iterator_to_array($forms);

            /* @var $forms FormInterface[] */
            $forms['model']->setData($data->getModel()->getId());
            $forms['name']->setData($data->getName());
            $forms['setting']->setData($data->getSetting()->jsonSerialize());
        }
    }

    /**
     * @param Traversable<FormInterface> $forms
     * @param ModelProfile               $viewData
     */
    public function mapFormsToData($forms, &$viewData): void
    {
        $forms = iterator_to_array($forms);
        $model = $forms['model']->getData();
        $name = $forms['name']->getData();
        $setting = $forms['setting']->getData();
        $messages = $setting['messages'];

        $model = $this->modelRepository->find($model);

        foreach ($messages as $i => $message) {
            $messages[$i] = new Message($message['role'], $message['content']);
        }

        $setting = ModelSettingFactory::create($model, $setting);

        if ($viewData->hasId()) {
            $viewData->setSetting($setting);
            $viewData->setName($name);
            $viewData->setModel($model);

            return;
        }

        $viewData = new ModelProfile(
            $name,
            $this->user,
            $model,
            $setting
        );
    }
}
