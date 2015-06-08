<?php

namespace DV\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use DV\MainBundle\Entity\Pagina;
use DV\MainBundle\Form\PaginaType;

use DV\UserBundle\Entity\Foto;
use DV\UserBundle\Form\FotoType;

class UserController extends Controller
{
    public function indexAction($paginaId = null)
    {
        if ($paginaId != null) {
            $paginaPedida = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVMainBundle:Pagina')
                            ->find($paginaId);
        }
        else {
            $paginaPedida = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVMainBundle:Pagina')
                            ->findLatestOne();

            if (sizeof($paginaPedida) > 0) {
                $paginaPedida = $paginaPedida[0];
            }
            else {
                $paginaPedida = new Pagina;
            }
        }

        $paginas = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVMainBundle:Pagina')
                        ->findAll();

        return $this->render('DVUserBundle:User:indexUser.html.twig', array(
            'paginaPedida' => $paginaPedida, 
            'paginas' => $paginas
            ));
    }

    public function paginaModifAction($paginaId)
    {
    	$pagina = $this ->getDoctrine()
	                        ->getManager()
	                        ->getRepository('DVMainBundle:Pagina')
	                        ->find($paginaId);

        // On utiliser le OrdersType
        $formNewPagina = $this->createForm(new PaginaType(), $pagina);

        // On récupère la requête
        $formNewPagina->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPagina->isValid()) {
            $pagina->setUltimaModificacion(new \Datetime);

            $em = $this->getDoctrine()->getManager();
            $em->persist($pagina);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('dv_user_homepage'));
        }

        return $this->render('DVUserBundle:User:paginaNueva.html.twig', array(
            'formNewPagina' => $formNewPagina->createView()
        ));
    }

    public function paginaNuevaAction()
    {
    	$pagina = new Pagina;

        // On utiliser le OrdersType
        $formNewPagina = $this->createForm(new PaginaType(), $pagina);

        // On récupère la requête
        $formNewPagina->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPagina->isValid()) {
            $pagina->setUltimaModificacion(new \Datetime);

            $em = $this->getDoctrine()->getManager();
            $em->persist($pagina);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('dv_user_homepage'));
        }

        return $this->render('DVUserBundle:User:paginaNueva.html.twig', array(
            'formNewPagina' => $formNewPagina->createView()
        ));
    }

    public function paginaSuprAction($paginaId)
    {
    	$pagina = $this ->getDoctrine()
	                        ->getManager()
	                        ->getRepository('DVMainBundle:Pagina')
	                        ->find($paginaId);

	    if (!$pagina) {
	        throw $this->createNotFoundException("Ningun pagina a suprimir fue encontrada ...");
	    }

        $em = $this->getDoctrine()->getManager();
        $em->remove($pagina);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_index'));
    }


    public function fotosAction($type = null)
    {
        $fotos = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVUserBundle:Foto')
                        ->findAll();

        return $this->render('DVUserBundle:User:fotos.html.twig', array(
            'fotos' => $fotos
        ));
    }

    public function fotoNuevaAction()
    {
        $foto = new Foto;

        // On utiliser le OrdersType
        $formNewFoto = $this->createForm(new FotoType(), $foto);

        // On récupère la requête
        $formNewFoto->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewFoto->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($foto);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_fotos'));
        }

        return $this->render('DVUserBundle:User:fotoNueva.html.twig', array(
            'formNewFoto' => $formNewFoto->createView()
        ));
    }

    public function fotoSuprimirAction($fotoId)
    {
        $foto = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVUserBundle:Foto')
                            ->find($fotoId);

        if (!$foto) {
            throw $this->createNotFoundException("Ningun foto a suprimir ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($foto);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_fotos'));
    }
}
