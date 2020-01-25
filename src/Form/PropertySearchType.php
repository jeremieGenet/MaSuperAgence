<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Champs du formulaire (avec leurs caractéristiques)
            ->add('minSurface', IntegerType::class, [
                'required' => false, // Pour dire que le champs 'minSurface' n'est pas obligatoire (requis)
                'label' => false,
                'attr' => [
                    'placeholder' => 'Surface minimale'
                ]
            ])
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget max'
                ]
            ])
            ->add('options', EntityType::class, [
                'required' => false, 
                'label' => false,
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'translation_domain' => 'forms', // Option pour ajouter la possibilité de traduire les labels des champs du formulaire (voir fichier créé dans translations/forms.fr.yaml)
            'method' => 'get',
            'csrf_protection' => false // Protection token de formulaire désactivé (avec false)
        ]);
    }

    
    // ASTUCE : Permet de retourner '' dans les param d'url de la zone de recherche (plutot que les variables prédéfinis, c'est beaucoup plus propre)
    public function getBlockPrefix()
    {
        return '';
    }
    



}
