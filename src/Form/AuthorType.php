<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //on utilise le builder de form pour créer les inputs
        //de notre formulaire, chaque input correspondant
        //généralement à une propriété d'entité et donc une colonne de la table
        $builder
            ->add('firstName',  null, [
                'label'=>'Prénom :'
            ])

            ->add('lastName',  null, [
                'label'=>'Nom :'
            ])

            ->add('birthDate',  DateTimeType::class, [
                'label'=>'Date de naissance :',
                'widget' => 'single_text'
            ])

            ->add('deathDate',  DateTimeType::class, [
                'label'=>'Date de décès :',
                'widget' => 'single_text'
            ])

            ->add('biography',  null, [
                'label'=>'Biographie :'
            ])

            ->add('published',  null, [
                'label'=>'Publié :'
            ])

            //je rajoute manuellemnt un input submit
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
