<?php

namespace NAO\BirdBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// Type
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ObservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('date', DateType::class, array(
            'required' => false,
            'placeholder' => array('day' => 'Jour', 'month' => 'Mois', 'year' => 'Année'),
            'format' => 'dd MM yyyy',
            'html5' => false
            ))
        ->add('latitude', TextType::class, array('required' => false))
        ->add('longitude', TextType::class, array('required' => false))
        ->add('photo', PhotoType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NAO\BirdBundle\Entity\Observation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nao_birdbundle_observation';
    }


}
