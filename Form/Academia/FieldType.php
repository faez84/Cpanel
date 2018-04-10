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



class FieldType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('arabicFullName',null,array('label'=> 'الاسم'))
            ->add('englishFullName',null,array('label'=> 'ألاسم باللغة لاانكليزية'))
            //->add('parent',null,array('label'=> 'الفئة الأم'))
            ->add('parent','entity', array(
                'label' => 'المجال الأب',
                'class' => 'syndexAcademicBundle:Field',
                'choice_label' => 'arabicFullName',
                'query_builder' => function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('c')
                        ->select('c')
                        ->where("c.deleted = 0");
                }
            ))
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'syndex\AcademicBundle\Entity\Field',
            'translation_domain' => 'field',
            'error_bubbling' => true,
            'csrf_protection' => true,
            'intention' => 'cpanel_academia_field_type'
             ,
            'validation_groups' => array('academia_admin_field', 'Default'),
        ));
    }

    public function getName()
    {
        return 'cpanel_academia_field_type';
    }
}