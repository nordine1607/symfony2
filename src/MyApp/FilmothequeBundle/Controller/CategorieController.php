<?php
/**
 * Created by IntelliJ IDEA.
 * User: nordine
 * Date: 13/04/15
 * Time: 10:00
 */

namespace MyApp\FilmothequeBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\FilmothequeBundle\Entity\Categorie;
use MyApp\FilmothequeBundle\Form\CategorieForm;

class CategorieController extends ContainerAware
{
    public function listerAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();

        $categories = $em->getRepository('MyAppFilmothequeBundle:Categorie')->findAll();

        return $this->container->get('templating')->renderResponse('MyAppFilmothequeBundle:Categorie:lister.html.twig',
            array(
                'categories' => $categories
            ));
    }

    public function ajouterAction()
    {
        $message = '';
        $categorie = new Categorie();
        $form = $this->container->get('form.factory')->create(new CategorieForm(), $categorie);

        $request = $this->container->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->container->get('doctrine')->getEntityManager();
                $em->persist($categorie);
                $em->flush();
                $message = 'Catégorie ajouté avec succès !';
            }
        }

        return $this->container->get('templating')->renderResponse(
            'MyAppFilmothequeBundle:Categorie:editer.html.twig',
            array(
                'form' => $form->createView(),
                'message' => $message,
            ));
    }

    public function modifierAction($id)
    {
        return $this->container->get('templating')->renderResponse(
            'MyAppFilmothequeBundle:Categorie:modifier.html.twig');
    }


    public function editerAction($id = null)
    {
        $message = '';
        $em = $this->container->get('doctrine')->getEntityManager();

        if (isset($id)) {
            // modification d'un categorie existant : on recherche ses données
            $categorie = $em->find('MyAppFilmothequeBundle:Categorie', $id);

            if (!$categorie) {
                $message = 'Aucun categorie trouvé';
            }
        } else {
            // ajout d'une nouvelle categorie
            $categorie = new Categorie();
        }

        $form = $this->container->get('form.factory')->create(new CategorieForm(), $categorie);

        $request = $this->container->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($categorie);
                $em->flush();
                if (isset($id)) {
                    $message = 'Categorie modifiée avec succès !';
                } else {
                    $message = 'Catégorie ajoutée avec succès !';
                }
            }
        }

        return $this->container->get('templating')->renderResponse(
            'MyAppFilmothequeBundle:Categorie:editer.html.twig',
            array(
                'form' => $form->createView(),
                'message' => $message,
            ));
    }

    public function supprimerAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $categorie = $em->find('MyAppFilmothequeBundle:Categorie', $id);

        if (!$categorie) {
            throw new NotFoundHttpException("Catégorie non trouvé");
        }

        $em->remove($categorie);
        $em->flush();


        return new RedirectResponse($this->container->get('router')->generate('myapp_categorie_lister'));
    }
}

?>