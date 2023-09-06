<?php

declare(strict_types=1);

namespace App\Form\DataMapper;

use App\Entity\AppSetting;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormInterface;
use Traversable;

final readonly class AppSettingDataMapper implements DataMapperInterface
{
    /**
     * @param AppSetting|null            $data
     * @param Traversable<FormInterface> $forms
     */
    public function mapDataToForms($data, $forms): void
    {
        if ($data?->hasId()) {
            $forms = iterator_to_array($forms);
            $forms['id']->setData($data->getId());
            $forms['value']->setData($data->getValue());
        }
    }

    /**
     * @param Traversable<FormInterface> $forms
     * @param AppSetting                 $data
     */
    public function mapFormsToData($forms, &$data): void
    {
        $forms = iterator_to_array($forms);

        $value = $forms['value']->getData();

        if ($data->hasId()) {
            $data->setValue($value);

            return;
        }

        $id = $forms['id']->getData();

        $data = new AppSetting(
            $id,
            $value
        );
    }
}
