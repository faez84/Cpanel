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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use syndex\AcademicBundle\Entity\Publisher;


class PublisherType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('arabicFullName',null,array('label'=> 'الاسم'))
            ->add('englishFullName',null,array('label'=> 'ألاسم باللغة لاانكليزية', 'translation_domain' => 'CpanelBundle',))
            ->add('website',null,array('label'=> 'الموقع الالكتروني'))
            ->add('category',null, array(
                'label' => 'نوع',
//                'class' => 'syndexAcademicBundle:PublisherCategory',
//                'choice_label' => 'arabicFullName',
//                'query_builder' => function(EntityRepository $entityRepository){
//                    return $entityRepository->createQueryBuilder('c')
//                        ->select('c')
//                        ->where("c.deleted = 0");
//                }
            ))
            ->add('place',null, array('label' => 'المكان','attr' => ['class' => 'adv-select']))
            ->add('city',null, array('label' => 'المدينة','attr' => ['class' => 'adv-select']))
            ->add('description',null,array('label'=> 'الوصف '))
            ->add('phone',null,array('label'=> ' التلفون'))
            ->add('fax',null,array('label'=> 'الفاكس '))
            ->add('email',null,array('label'=> 'الايميل الالكتروني'))
            ->add('syrianRanking',null,array('label'=> 'التصنيف ضمن سوريا', 'attr' => ['min' => 0]))
            ->add('additionalInfo', new PublisherAdditionalInfoType(), array( 'validation_groups' => "academia_admin_publisher_info",
                'label'=> 'معلومات إضافية', 'validation_groups' => ['academia_admin_publisher_info'],'constraints' => new \Symfony\Component\Validator\Constraints\Valid(),));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Publisher::class,
            'translation_domain' => 'CpanelBundle',
            'csrf_protection' => true,
            'intention' => 'cpanel_academia_publisher_type',
            'validation_groups' => array('academia_admin_publisher', 'Default'),
            'error_bubbling' => true,
            'cascade_validation' => true,

        ));
    }

    public function getName()
    {
        return 'cpanel_academia_publisher_type';
    }
}