<?php
/**
 * Created by IntelliJ IDEA.
 * User: nordine
 * Date: 13/04/15
 * Time: 11:13
 */
namespace MyApp\FilmothequeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategorieForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
        ;
    }

    public function getName()
    {
        return 'categorie';
    }
}

?>