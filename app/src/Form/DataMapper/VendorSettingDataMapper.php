<?php

declare(strict_types=1);

namespace App\Form\DataMapper;

use App\Entity\User;
use App\Entity\ValueObject\Token;
use App\Entity\VendorSetting;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormInterface;
use Traversable;

final readonly class VendorSettingDataMapper implements DataMapperInterface
{
    public function __construct(
        private User $user
    ) {
    }

    /**
     * @param VendorSetting|null         $data
     * @param Traversable<FormInterface> $forms
     */
    public function mapDataToForms($data, $forms): void
    {
        if ($data?->hasId()) {
            $forms = iterator_to_array($forms);
            $forms['vendor']->setData($data->getVendor());
            $forms['setting']['token']->setData($data->getSetting()->getToken());
        }
    }

    /**
     * @param Traversable<FormInterface> $forms
     * @param VendorSetting              $data
     */
    public function mapFormsToData($forms, &$data): void
    {
        $forms = iterator_to_array($forms);

        $setting = $forms['setting']->getData();
        $token = new Token($setting['token']);

        if ($data->hasId()) {
            $data->updateSetting(
                $token
            );

            return;
        }

        $vendor = $forms['vendor']->getData();

        $data = new VendorSetting(
            $this->user,
            $vendor,
            $token
        );
    }
}
