<?php
declare(strict_types=1);

namespace App\Form\Type\Product;

use App\Entity\Product;
use App\Form\Type\AbstractApiType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class PatchType extends EditType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $configuredFieldKeys = array_keys($builder->all());

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($configuredFieldKeys) {
                $form     = $event->getForm();
                $data     = $event->getData();
                $dataKeys = array_keys($data);
                foreach (array_diff($configuredFieldKeys, $dataKeys) as $missingProperty) {
                    $form->remove($missingProperty);
                }
            }
        );
    }
}
