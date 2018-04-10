<?php
/**
 * Created by PhpStorm.
 * User: LUFFY
 * Date: 11/08/2016
 * Time: 05:55 م
 */

namespace syndex\CpanelBundle\Form\Academia;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;



class ResearchCategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('arabicFullName',null,array('label'=> 'الاسم'))
            ->add('englishFullName',null,array('label'=> 'لاسم باللغة الانكليزية'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'syndex\AcademicBundle\Entity\ResearchCategory',
            'translation_domain' => 'researchcategory',
            'error_bubbling' => true,
            'csrf_protection' => true,
            'intention' => 'cpanel_academia_reserachcat_type'
             ,
            'validation_groups' => array('academia_admin_researchcat', 'Default'),
        ));
    }

    public function getName()
    {
        return 'cpanel_academia_reserachcat_type';
    }
}