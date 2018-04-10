<?php
/**
 * Created by PhpStorm.
 * User: LUFFY
 * Date: 11/08/2016
 * Time: 05:55 م
 */

namespace syndex\CpanelBundle\Form\Bazar;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;



class UserPreferencesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value',null, array())
            ->add('product',null, array(
                'label'    => 'up.product',

            ))
            ->add('user',null, array('label' => 'up.product'))

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'syndex\BazaarBundle\Entity\UserPreferences',
            'translation_domain' => 'bazaar',
            'error_bubbling' => true,
            'csrf_protection' => true,
            'intention' => 'syndex_bazaar_up_form',
            'validation_groups' => array('bazaar_store', 'Default'),
        ));
    }

    public function getName()
    {
        return 'cpanel_bazaar_up_type';
    }
}