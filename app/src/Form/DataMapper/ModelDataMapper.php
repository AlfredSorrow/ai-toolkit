<?php

declare(strict_types=1);

namespace App\Form\DataMapper;

use App\Entity\Model;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormInterface;
use Traversable;

final readonly class ModelDataMapper implements DataMapperInterface
{
    /**
     * @param Model|null                 $data
     * @param Traversable<FormInterface> $forms
     */
    public function mapDataToForms($data, $forms): void
    {
        if ($data?->hasId()) {
            $forms = iterator_to_array($forms);
            $forms['name']->setData($data->getName());
            $forms['type']->setData($data->getType(false));
            $forms['code']->setData($data->getCode());
        }
    }

    /**
     * @param Traversable<FormInterface> $forms
     * @param Model                      $data
     */
    public function mapFormsToData($forms, &$data): void
    {
        $forms = iterator_to_array($forms);

        $name = $forms['name']->getData();
        $type = $forms['type']->getData();
        $code = $forms['code']->getData();

        if ($data->hasId()) {
            $data->setName($name);
            $data->setType($type);
            $data->setCode($code);

            return;
        }

        $vendor = $forms['vendor']->getData();

        $data = new Model(
            $vendor,
            $code,
            $type,
        );
    }
}
