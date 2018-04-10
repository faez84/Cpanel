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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class AttributesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name',null,array('label'=> 'الاسم'))
            ->add('unit',null,array('label'=> 'الوحدة'))

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'bazaar',
//            'csrf_protection' => true,
//            'intention' => 'syndex_bazaar_attributes_form',
            'validation_groups' => array('bazaar', 'Default'),
        ));
    }

    public function getName()
    {
        return 'cpanel_bazaar_attribute_type';
    }
}