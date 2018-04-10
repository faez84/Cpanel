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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;



class ProductType extends AbstractType
{

    private $toStore;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text', array('label' => 'الاسم'))
            ->add('description','textarea', array('label' => 'الوصف'))
            ->add('price','number', array('label' => 'السعر'))
            ->add('quantity','number', array('label' => 'الكمية'))
            ->add('phone','text', array('label' => 'الموبايل'))

            ->add('city','entity', array(
                'label' => 'المدينة',
                'class' => 'syndexPlacesBundle:SyrianGeoDB',
//                'choice_label' => 'name',
//                'query_builder' => function(EntityRepository $entityRepository){
//                    return $entityRepository->createQueryBuilder('c')
//                        ->select('c')
//                        ->where("c.type = 'locality' OR c.type = 'sublocality_level_1'");
//                }
            ))
 
            ->add('store','entity', array(
                'label' => 'المتجر',
                'class' => 'syndexBazaarBundle:Store',

            ))
            ->add('logo', 'file', array('label' => 'اللوغو'));
            
        ;

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            if (isset($data['toStore'])){
                $this->toStore = $data['toStore'];
            }
        });
        // ...
   
    }



    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'syndex\BazaarBundle\Entity\Product',
            'translation_domain' => 'bazaar',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'syndex_bazaar_product_form',
            'intention' => 'syndex_bazaar_product_form',
            'cascade_validation' => true,
            'validation_groups' => function () {

                if ($this->toStore) {
                    return array('store_product');
                }

                return array('product_new');
            },
        ));
    }

    public function getName()
    {
        return 'cpanel_bazaar_product_type';
    }
}