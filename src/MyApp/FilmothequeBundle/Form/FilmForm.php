<?php
/**
 * Created by IntelliJ IDEA.
 * User: nordine
 * Date: 13/04/15
 * Time: 15:39
 */

namespace MyApp\FilmothequeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class FilmForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('categorie')
            ->add('acteurs')
        ;
    }

    public function getName()
    {
        return 'film';
    }
}

?>