<?php

namespace DV\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// use DV\MainBundle\Entity\Article;

class MainController extends Controller
{
    public function indexAction()
    {
        $pagina = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVMainBundle:Pagina')
                        ->findByNombre('Index');

        return $this->render('DVMainBundle:Main:indexMain.html.twig', array(
            'pagina' => $pagina,
            ));
    }

    public function nosotrosAction()
    {
        $pagina = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVMainBundle:Pagina')
                        ->findByNombre('Nosotros');

        return $this->render('DVMainBundle:Main:nosotros.html.twig', array(
            'pagina' => $pagina,
            ));
    }

    public function clientesAction()
    {
        $pagina = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVMainBundle:Pagina')
                        ->findByNombre('Clientes');

        return $this->render('DVMainBundle:Main:clientes.html.twig', array(
            'pagina' => $pagina,
            ));
    }

    public function rseAction()
    {
        $pagina = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVMainBundle:Pagina')
                        ->findByNombre('RSE');

        return $this->render('DVMainBundle:Main:rse.html.twig', array(
            'pagina' => $pagina,
            ));
    }

    public function proyectosAction()
    {
        $pagina = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVMainBundle:Pagina')
                        ->findByNombre('Proyectos');

        return $this->render('DVMainBundle:Main:proyectos.html.twig', array(
            'pagina' => $pagina,
            ));
    }

    public function serviciosAction()
    {
        $pagina = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVMainBundle:Pagina')
                        ->findByNombre('Proyectos');

        return $this->render('DVMainBundle:Main:servicios.html.twig', array(
            'pagina' => $pagina,
            )); 
    }

    public function fotosAction()
    {
        $fotos = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVUserBundle:Foto')
                        ->findAll();

        return $this->render('DVMainBundle:Main:fotos.html.twig', array(
            'fotos' => $fotos,
            ));
    }

    public function contactAction()
    {
        return $this->render('DVMainBundle:Main:contact.html.twig');   
    }

    public function enviarAction() 
    {
        $senderName = $_POST['senderContact'];
        $senderEmail = $_POST['emailContact'];
        $senderCel = $_POST['celContact'];
        $senderPais = $_POST['paisContact'];
        $senderContent = $_POST['corpsMail'];

        // Message for client
        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('[Deo Volente]')
            ->setFrom(array('info@deovolente.com.pe' => 'Deo Volente'))
            ->setTo(array($senderEmail => $senderName))
            ->setBody(
                $this->renderView('DVMainBundle:Main:emailClient.html.twig',
                    array(  'senderName' => $senderName,
                            'senderEmail' => $senderEmail,
                            'senderCel' => $senderCel,
                            'senderPais' => $senderPais,
                            'senderContent' => $senderContent
                            )
                )
            )
        ;
        
        $this->get('mailer')->send($message);   

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('dv_main_contact_enviado'));
    }

    public function enviadoAction() 
    {
        return $this->render('DVMainBundle:Main:enviado.html.twig');
    }
}
