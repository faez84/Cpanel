<?php
/**
 * Created by PhpStorm.
 * User: LUFFY
 * Date: 11/08/2016
 * Time: 05:55 م
 */

namespace syndex\CpanelBundle\Form\Bazar;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use syndex\BazaarBundle\Entity\Review;


class ReviewType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('target',ChoiceType::class, array(
                'label' => 'review.target',
                'choices' => array(
                    'customer' => 'customer',
                    'seller'   => 'seller',
                    'store'    => 'store',
                    'product'  => 'product'
                ),
                'empty_data'=> 'product'
            ))
            ->add('author', null, array('label' =>'review.author'))
            ->add('targetId',null, array('label' =>'review.targetId'))
            ->add('authorType',ChoiceType::class, array(
                'label' => 'review.authorType',
                'choices' => array(
                    'customer' => 'customer',
                    'seller'   => 'seller',
                    'user'    => 'user'
                ),
                'empty_data'=> 'customer'
            ))
            ->add('rate',ChoiceType::class, array(
                'label' => 'review.rate',
                'choices' => array(
                    '1' => '1',
                    '2'   => '2',
                    '3'    => '3'
                ,
                    '4'    => '4'
                ,
                    '5'    => '5'
                ),
                'empty_data'=> 'customer'
            ))
             ->add('content',TextareaType::class, array('label' => 'review.content'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Review::class,
            'translation_domain' => 'bazaar',
            'csrf_protection' => false,
            'intention' => 'syndex_bazaar_review_form',
            'validation_groups' => array('bazaar_review', 'Default'),
        ));
    }

//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'syndex\BazaarBundle\Entity\Review',
//            'translation_domain' => 'bazaar',
//            'csrf_protection' => false,
//            'intention' => 'syndex_bazaar_review_form',
//            'validation_groups' => array('bazaar_review', 'Default'),
//        ));
//    }

    public function getName()
    {
        return 'cpanel_bazaar_review_type';
    }
}