<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, ['choices' => $this->getChoices()]) // ajout du bouton select (utilisation de ChoiceType::class pour ajouter une option)
            ->add('options', EntityType::class, [
                'required' => false,
                'class' => Option::class, // On précise que le champs des options sera de type class et la classe Option
                'choice_label' => 'name', 
                'multiple' => true // On autorise plusieurs options à être sélectionnées
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('sold')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms' // Option pour ajouter la possibilité de traduire les labels des champs du formulaire (voir fichier créé dans translations/forms.fr.yaml)
        ]);
    }

    // Inverse la clé / valeur de notre tableau des chauffages pour utilisé la valeur dans le "select" du formulaire
    public function getChoices()
    {
        $choices = Property::HEAT;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }


}
