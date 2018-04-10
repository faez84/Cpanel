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



class StoreType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text', array('label' => 'الاسم'))
            ->add('address','text', array(
                'label'    => 'العنوان',
                'required' => false
            ))
            ->add('description','textarea', array('label' => 'الوصف'))
            ->add('phone','text', array('label' => 'التلفون'))
            ->add('lat','number', array('label' => 'lat','required' => false))
            ->add('lng','number', array('label' => 'lng','required' => false))
            ->add('phoneAlt','text', array('label' => 'تلفون بديل','required' => false))
            ->add('email','text', array('label' => 'الايميل','required' => false))
            ->add('website','text', array('label' => 'موقع الكتروني','required' => false))
            ->add('path','file', array('data_class' => null,'label' => 'اللوغو'))
            ->add('city','entity', array(
                'label' => 'المدينة',
                'class' => 'syndexPlacesBundle:SyrianGeoDB',
                'query_builder' => function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('c')
                        ->select('c')
                        ->where("c.type = 'locality' OR c.type = 'sublocality_level_1'");
                }
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'syndex\BazaarBundle\Entity\Store',
            'translation_domain' => 'bazaar',
            'error_bubbling' => true,
            'csrf_protection' => true,
            'intention' => 'syndex_bazaar_store_form',
            'validation_groups' => array('bazaar_store_admin', 'Default'),
        ));
    }

    public function getName()
    {
        return 'cpanel_bazaar_store_type';
    }
}