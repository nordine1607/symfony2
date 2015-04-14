<?php

namespace MyApp\FilmothequeBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware,
    Symfony\Component\HttpFoundation\RedirectResponse;
use MyApp\FilmothequeBundle\Entity\Categorie;

class DefaultController extends ContainerAware
{

    public function indexAction()
    {

        return $this->container->get('templating')->renderResponse('MyAppFilmothequeBundle:Default:index.html.twig',array()
        );
    }
}