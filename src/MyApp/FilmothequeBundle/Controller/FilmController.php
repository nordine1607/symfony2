<?php
/**
 * Created by IntelliJ IDEA.
 * User: nordine
 * Date: 13/04/15
 * Time: 15:40
 */

namespace MyApp\FilmothequeBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\FilmothequeBundle\Entity\Film;
use MyApp\FilmothequeBundle\Form\FilmForm;

class FilmController extends ContainerAware {

    public function listerAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();

        $film = $em->getRepository('MyAppFilmothequeBundle:Film')->findAll();

        return $this->container->get('templating')->renderResponse('MyAppFilmothequeBundle:Film:lister.html.twig',
            array(
                'films' => $film
            ));
    }

    public function ajouterAction()
    {
        $message = '';
        $film = new Film();
        $form = $this->container->get('form.factory')->create(new FilmForm(), $film);

        $request = $this->container->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->container->get('doctrine')->getEntityManager();
                $em->persist($film);
                $em->flush();
                $message = 'Film ajouté avec succès !';
            }
        }

        return $this->container->get('templating')->renderResponse(
            'MyAppFilmothequeBundle:Film:editer.html.twig',
            array(
                'form' => $form->createView(),
                'message' => $message,
            ));
    }

    public function modifierAction($id)
    {
        return $this->container->get('templating')->renderResponse(
            'MyAppFilmothequeBundle:Film:modifier.html.twig');
    }


    public function editerAction($id = null)
    {
        $message = '';
        $em = $this->container->get('doctrine')->getEntityManager();

        if (isset($id)) {
            // modification d'un film existant : on recherche ses données
            $film = $em->find('MyAppFilmothequeBundle:Film', $id);

            if (!$film) {
                $message = 'Aucun film trouvé';
            }
        } else {
            // ajout d'une nouvelle film
            $film = new Film();
        }

        $form = $this->container->get('form.factory')->create(new FilmForm(), $film);

        $request = $this->container->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($film);
                $em->flush();
                if (isset($id)) {
                    $message = 'Film modifiée avec succès !';
                } else {
                    $message = 'Film ajoutée avec succès !';
                }
            }
        }

        return $this->container->get('templating')->renderResponse(
            'MyAppFilmothequeBundle:Film:editer.html.twig',
            array(
                'form' => $form->createView(),
                'message' => $message,
            ));
    }

    public function supprimerAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $film = $em->find('MyAppFilmothequeBundle:Film', $id);

        if (!$film) {
            throw new NotFoundHttpException("Film non trouvé");
        }

        $em->remove($film);
        $em->flush();


        return new RedirectResponse($this->container->get('router')->generate('myapp_film_lister'));
    }
}


?>