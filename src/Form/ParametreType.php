<?php

namespace App\Form;

use App\Entity\Parametre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ParametreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSite')
            ->add('titre')
            ->add('description')
            ->add('tel')
            ->add('email')
            ->add('facebook')
            ->add('instagram')
            ->add('whatsapp')
            ->add('adresse')
            ->add('idPaypal')
            ->add('seuilLivraison')
            ->add('gestionStock',ChoiceType::class ,['choices'=>['Activée'=>true,'Desactivé'=>false]])
            ->add('imageFile',VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'supprimer',
                'asset_helper' => true,
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parametre::class,
        ]);
    }
}
