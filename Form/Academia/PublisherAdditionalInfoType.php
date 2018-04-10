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
use syndex\AcademicBundle\Entity\PublisherAdditionalInfo;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PublisherAdditionalInfoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numberOfStudents', null, array('label' => 'عدد الطلاب', 'attr' => ['min' => 0]))
            ->add('globalRanking',  null, array('label' => 'الترتيب العالمي', 'attr' => [ 'min' => 0]))
            ->add('establishDate', DateType::class, array('label' => 'تاريخ التأسيس' ,   'widget' => 'single_text',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false, 'format' => 'dd-MM-yyyy','attr' => ['class' => 'datepicker', "readonly" => "readonly",
                "cols" => 20, "data-date-end-date" => "0d"]))
            ->add('isPrivate', null, array('label' => 'النوع (خاصة؟)',))
            ->add('logo', FileType::class, array('label' => 'الشعار', 'image_path' => 'logo'))
            ->add('coverImage', 'file', array('label' => 'صورة الغلاف', "data_class" => null));;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            //       'data_class' => 'syndex\AcademicBundle\Entity\PublisherAdditionalInfo',
            'data_class' => PublisherAdditionalInfo::class,
            'translation_domain' => 'CpanelBundle',
            'csrf_protection' => true,
            'intention' => 'cpanel_academia_publisher_Info_type',

            'error_bubbling' => true,
            
        ));
    }

    public function getName()
    {
        return 'cpanel_academia_publisher_Info_type';
    }
}