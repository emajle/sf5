<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;


class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                "label" => "Titre du livre",
                "constraints" => [
                    new Length([
                        "min" => 4,
                        "minMessage" => "Le titre doit avoir au moins 4 caractères",
                        "max" => 50,
                        "maxMessage" => "Le titre doit avoir maximum 50 caractères"
                    ])
                ]
            ])
            ->add('auteur', TextType::class)
            ->add("enregistrer", SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-secondary"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
