<?php

namespace DV\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// use DV\MainBundle\Entity\Article;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('DVMainBundle:Main:indexMain.html.twig');   
    }

    public function nosotrosAction()
    {
        return $this->render('DVMainBundle:Main:nosotros.html.twig');   
    }

    public function clientesAction()
    {
        return $this->render('DVMainBundle:Main:clientes.html.twig');   
    }

    public function rseAction()
    {
        return $this->render('DVMainBundle:Main:rse.html.twig');   
    }

    public function proyectosAction()
    {
        return $this->render('DVMainBundle:Main:proyectos.html.twig');   
    }

    public function serviciosAction()
    {
        return $this->render('DVMainBundle:Main:servicios.html.twig');   
    }

    public function fotosAction()
    {
        return $this->render('DVMainBundle:Main:fotos.html.twig');   
    }

    public function contactAction()
    {
        return $this->render('DVMainBundle:Main:contact.html.twig');   
    }

    public function enviarAction() 
    {
        // $senderName = $_POST['senderContact'];
        // $senderEmail = $_POST['emailContact'];
        // $senderContent = $_POST['corpsMail'];

        // // Message for client
        // $message = \Swift_Message::newInstance()
        //     ->setContentType('text/html')
        //     ->setSubject('[Mission Andina]')
        //     ->setFrom(array('contact@missionandina.org' => 'Mission Andina'))
        //     ->setTo($senderEmail)
        //     ->setBody(
        //         $this->renderView('DVMainBundle:Main:emailClient.html.twig',
        //             array(  'senderName' => $senderName,
        //                     'senderEmail' => $senderEmail,
        //                     'senderContent' => $senderContent
        //                     )
        //         )
        //     )
        // ;

        // // Message for manager/admin
        // $messageAdmin = \Swift_Message::newInstance()
        //     ->setContentType('text/html')
        //     ->setSubject('[Mission Andina] Nouveau message.')
        //     ->setFrom(array('contact@missionandina.org' => 'Mission Andina'))
        //     ->setTo('contact@missionandina.org')
        //     ->setBody(
        //         $this->renderView('DVMainBundle:Main:emailAdmin.html.twig',
        //             array(  'senderName' => $senderName,
        //                     'senderEmail' => $senderEmail,
        //                     'senderContent' => $senderContent
        //                     )
        //         )
        //     )
        // ;

        // $this->get('mailer')->send($message);
        // $this->get('mailer')->send($messageAdmin);        

        // // On redirige vers la page de visualisation de le document nouvellement créé
        // return $this->redirect($this->generateUrl('ma_main_footer_contact_thankYou'));
        // return $this->redirect($this->generateUrl('ma_main_footer_contact_thankYou'));
    }

    public function footerContactThankYouAction() 
    {
        
        return $this->render('DVMainBundle:Main:contactThankYou.html.twig');
    }

    public function helpUsContactAction() 
    {
        $senderName = $_POST['senderContact'];
        $senderEmail = $_POST['emailContact'];
        $senderQuantity = $_POST['quantityContact'];
        $senderType = $_POST['orderContentType'];
        $senderContent = $_POST['corpsMail'];

        // Message for client
        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('[Mission Andina]')
            ->setFrom(array('contact@missionandina.org' => 'Mission Andina'))
            ->setTo($senderEmail)
            ->setBody(
                $this->renderView('DVMainBundle:Main:emailHelpUsClient.html.twig',
                    array(  'senderName' => $senderName,
                            'senderEmail' => $senderEmail,
                            'senderQuantity' => $senderQuantity,
                            'senderType' => $senderType,
                            'senderContent' => $senderContent
                            )
                )
            )
        ;

        // Message for manager/admin
        $messageAdmin = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('[Mission Andina] Nouveau message.')
            ->setFrom(array('contact@missionandina.org' => 'Mission Andina'))
            ->setTo('contact@missionandina.org')
            ->setBody(
                $this->renderView('DVMainBundle:Main:emailHelpUsAdmin.html.twig',
                    array(  'senderName' => $senderName,
                            'senderEmail' => $senderEmail,
                            'senderQuantity' => $senderQuantity,
                            'senderType' => $senderType,
                            'senderContent' => $senderContent
                            )
                )
            )
        ;

        $this->get('mailer')->send($message);
        $this->get('mailer')->send($messageAdmin);        

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_main_helpUs_contact_thankYou'));
    }

    public function helpUsContactThankYouAction() 
    {
        return $this->render('DVMainBundle:Main:contactThankYou.html.twig');
    }
}
