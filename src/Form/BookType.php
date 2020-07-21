<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Books;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //on utilise le builder de form pour créer les inputs
        //de notre formulaire, chaque input correspondant
        //généralement à une propriété d'entité et donc une colonne de la table
        $builder
            ->add('title', null, [
                'label'=>'Titre :'
            ])

            ->add('nbPages', null, [
                'label'=>'Nombre de page :'
            ])
            ->add('genre', EntityType::class, [
                'class'=>Genre::class,
                'choice_label'=>'name'
            ])

            ->add('resume', null, [
                'label'=>'Résumé :'
            ])

            ->add('author', EntityType::class, [
                'class'=>Author::class,
                'choice_label'=>'Name',
            ])

            //je rajoute manuellemnt un input submit
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
