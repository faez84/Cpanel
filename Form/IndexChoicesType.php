<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 3/27/2017
 * Time: 1:58 PM
 */

namespace syndex\CpanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class IndexChoicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $newsarr = $this->em->getRepository('syndexNewsBundle:NewsArticle')->findBy([], array('id' => 'ASC'), 100, 0);
        $arrw = array();
        foreach ($newsarr as $sd) {

            $arrw[$sd->getId()] =
                $sd->getTitle();

        }
        $builder
            ->add('reference', 'choice', [
                'choices' => $arrw,
                'label' => 'admin.reference', 'translation_domain' => 'CpanelBundle',
            ])
            //   ->add('type','text',array('label' => 'form.type'))
//            ->add('status', 'text',array('label' => 'form.status'))
            ->add('status', 'choice', [
                'choices' => ['1' => '1', '0' => '0'],
                'label' => 'admin.status', 'translation_domain' => 'CpanelBundle',
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'syndex\AdminBundle\Entity\IndexChoices',
        ));
    }

    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    public function getName()
    {
        return 'index_choices';
    }
}