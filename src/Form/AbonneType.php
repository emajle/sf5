<?php

namespace App\Form;

use App\Entity\Abonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class AbonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Récupération de la variable abonné passée en param pour construirele formulaire
        $abonne = $options["data"]; //$abonne est un objet de la classe App\Entity\Abonne
        $builder
            ->add('pseudo')
            ->add('roles', ChoiceType::class, [
                "choices" => [
                    "Directeur" => "ROLE_ADMIN",
                    "Bibliothécaire" => "ROLE_BIBLIO",
                    "Lecteur" => "ROLE_LECTEUR"
                ],
                "multiple" => true, // doit être true, car 'roles' est un array et donc peut avoir plusieurs valeurs
                "expanded" => true // pour afficher sous forme de cases à cocher
            ])
            ->add('password', TextType::class, [
                "mapped" => false, //le mdp ne doit pas être enregistré ici en bdd, mais dans AbonneController
                "constraints" => [
                    new Regex([
                        "pattern" => "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{6,10})$/",
                        "message" => "Le mot de passe doit contenir au moins 1 majusucle, 1 minuscule, 1 chiffre, 1 caractères spécial et doit faire entre 6 et 10 caractères"

                    ])
                ],
                "help" => "Le mot de passe doit contenir au moins 1 majusucle, 1 minuscule, 1 chiffre, 1 caractères spécial et doit faire entre 6 et 10 caractères",
                "required" => $abonne->getId() ? false : true
            ])
            ->add('prenom')
            ->add('nom');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonne::class,
        ]);
    }
}
