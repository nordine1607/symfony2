<?php
/**
 * Created by IntelliJ IDEA.
 * User: nordine
 * Date: 10/04/15
 * Time: 15:54
 */

namespace MyApp\FilmothequeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ActeurForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance', 'birthday')
            ->add('sexe', 'choice', array('choices' => array('F'=>'Féminin','M'=>'Masculin')))
        ;
    }

    public function getName()
    {
        return 'acteur';
    }
}