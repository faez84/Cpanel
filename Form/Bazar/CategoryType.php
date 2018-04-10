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



class CategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name',null,array('label'=> 'الاسم'))
            ->add('parent',null,array('label'=> 'الفئة الأم'))

            ->add('icon','file',array('data_class' => null,'label'=> 'الأيقونة'))
            ->add('attributes',null,array('label'=> 'الواصفات'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'syndex\BazaarBundle\Entity\Category',
            'translation_domain' => 'bazaar',
            'error_bubbling' => true,
            'csrf_protection' => true,
            'intention' => 'syndex_bazaar_store_form',
            'validation_groups' => array('bazaar_category_admin', 'Default'),
        ));
    }

    public function getName()
    {
        return 'cpanel_bazaar_category_type';
    }
}