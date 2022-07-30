<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Tag;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('courteDesc')
            ->add('longueDesc',CKEditorType::class)
            ->add('prixAchat')
            ->add('prixVente')
            ->add('qteStock')
            ->add('slug')
            ->add('visibilite')
            ->add('favoris')
            ->add('reductionApplique')
            ->add('valeurReduction')
            ->add('typeReduction')
            ->add('tags',EntityType::class,array('class'=>Tag::class,'multiple'=>true ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
