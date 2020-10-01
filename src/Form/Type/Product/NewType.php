<?php
declare(strict_types=1);

namespace App\Form\Type\Product;

use App\Entity\Product;
use App\Form\Type\AbstractApiType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewType extends AbstractApiType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255])
                ]
            ]
        );
        $builder->add(
            'price',
            NumberType::class,
            [
                'scale'       => 2,
                'constraints' => [
                    new NotBlank(),
                    new GreaterThan(['value' => 0])
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(
            [
                'data_class' => Product::class,
            ]
        );
    }
}
