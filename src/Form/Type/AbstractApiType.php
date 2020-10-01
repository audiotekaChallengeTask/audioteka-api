<?php
declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractApiType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'csrf_protection'      => false,
                'extra_fields_message' => 'Properties [{{ extra_fields }}] are unknown in this context.'
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
