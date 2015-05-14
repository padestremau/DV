<?php

namespace DV\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// use DV\MainBundle\Entity\Article;
// use DV\MainBundle\Form\ArticleType;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('DVUserBundle:User:indexUser.html.twig');
    }

    public function articlesAction($articleId = null)
    {
    	if ($articleId != null) {
	    	$articleAsked = $this ->getDoctrine()
	                        ->getManager()
	                        ->getRepository('DVMainBundle:Article')
	                        ->find($articleId);
    	}
    	else {
    		$articleAsked = $this ->getDoctrine()
	                        ->getManager()
	                        ->getRepository('DVMainBundle:Article')
	                        ->findLatestOne();

	        if (sizeof($articleAsked) > 0) {
		        $articleAsked = $articleAsked[0];
	        }
	        else {
	        	$articleAsked = new Article;
	        }
    	}

        $articles = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVMainBundle:Article')
                        ->findAllByDate();

        return $this->render('DVUserBundle:User:articles.html.twig', array(
        	'articleAsked' => $articleAsked, 
        	'articles' => $articles
        	));
    }

    public function articleEditAction($articleId)
    {
    	$article = $this ->getDoctrine()
	                        ->getManager()
	                        ->getRepository('DVMainBundle:Article')
	                        ->find($articleId);

        // On utiliser le OrdersType
        $formNewArticle = $this->createForm(new ArticleType(), $article);

        // On récupère la requête
        $formNewArticle->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewArticle->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_articles'));
        }

        return $this->render('DVUserBundle:User:articleNew.html.twig', array(
            'formNewArticle' => $formNewArticle->createView()
        ));
    }

    public function articleNewAction()
    {
    	$article = new Article;

        // On utiliser le OrdersType
        $formNewArticle = $this->createForm(new ArticleType(), $article);

        // On récupère la requête
        $formNewArticle->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewArticle->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_articles'));
        }

        return $this->render('DVUserBundle:User:articleNew.html.twig', array(
            'formNewArticle' => $formNewArticle->createView()
        ));
    }

    public function articleDeleteAction($articleId)
    {
    	$article = $this ->getDoctrine()
	                        ->getManager()
	                        ->getRepository('DVMainBundle:Article')
	                        ->find($articleId);

	    if (!$article) {
	        throw $this->createNotFoundException("Aucun article à supprimer n'a été trouvé ...");
	    }

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_articles'));
    }


    public function photosAction($type = null)
    {
        $photos = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVMainBundle:Photos')
                        ->findAllByDate();

        $photosEcoliers = array();
        $photosEtudiants = array();
        $photosJeunesPro = array();
        for ($i=0; $i < sizeof($photos); $i++) { 
            $photo = $photos[$i];
            if ($photo->getCategory() == 'ecoliers') {
                $photosEcoliers[] = $photo;
            } 
            else if ($photo->getCategory() == 'etudiants') {
                $photosEtudiants[] = $photo;
            }
            else if ($photo->getCategory() == 'etudiants') {
                $photosJeunesPro[] = $photo;
            }
            
        }

        if ($type) {
            if ($type == 'ecoliers') {
                $photos = $photosEcoliers;
            }
            else if ($type == 'etudiants') {
                $photos = $photosEtudiants;
            }
            else if ($type == 'jeunesPro') {
                $photos = $photosJeunesPro;
            }
        }
        else {
            $type = 'ecoliers';
            $photos = $photosEcoliers;
        }

        return $this->render('DVUserBundle:User:photos.html.twig', array(
            'type' => $type,
            'photos' => $photos
        ));
    }

    public function photoNewAction($type)
    {
        $photo = new Photos;

        $photo->setCategory($type);

        // On utiliser le OrdersType
        $formNewPhoto = $this->createForm(new PhotosType(), $photo);

        // On récupère la requête
        $formNewPhoto->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPhoto->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_photos_spe', array('type' => $type)));
        }

        return $this->render('DVUserBundle:User:photoNew.html.twig', array(
            'formNewPhoto' => $formNewPhoto->createView(),
            'type' => $type
        ));
    }

    public function photoDeleteAction($photoId, $type)
    {
        $photo = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVMainBundle:Photos')
                            ->find($photoId);

        if (!$photo) {
            throw $this->createNotFoundException("Aucune photo à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($photo);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_photos_spe', array('type' => $type)));
    }

    public function videosAction($type = null, $videoId = null)
    {
        $videos = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('DVMainBundle:Videos')
                        ->findAllByDate();

        $videosEcoliers = array();
        $videosEtudiants = array();
        $videosJeunesPro = array();
        for ($i=0; $i < sizeof($videos); $i++) { 
            $video = $videos[$i];

            if ($video->getCategory() == 'ecoliers') {
                $videosEcoliers[] = $video;
            } 
            else if ($video->getCategory() == 'etudiants') {
                $videosEtudiants[] = $video;
            }
            else if ($video->getCategory() == 'jeunesPro') {
                $videosJeunesPro[] = $video;
            }
            
        }

        if ($type) {
            if ($type == 'ecoliers') {
                $videos = $videosEcoliers;
            }
            else if ($type == 'etudiants') {
                $videos = $videosEtudiants;
            }
            else if ($type == 'jeunesPro') {
                $videos = $videosJeunesPro;
            }
        }
        else {
            $type = 'ecoliers';
            $videos = $videosEcoliers;
        }

        if ($videoId != null) {
            $videoSelect = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('DVMainBundle:Videos')
                                ->find($videoId);
        }
        else {
            if ($type == 'ecoliers') {
                $videoSelect = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('DVMainBundle:Videos')
                                ->findLatestOneByType('ecoliers');
            }
            else if ($type == 'etudiants') {
                $videoSelect = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('DVMainBundle:Videos')
                                ->findLatestOneByType('etudiants');
            }
            else if ($type == 'jeunesPro') {
                $videoSelect = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('DVMainBundle:Videos')
                                ->findLatestOneByType('jeunesPro');
            }
            else {
                $videoSelect = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('DVMainBundle:Videos')
                                ->findLatestOne();

            }
            if (sizeof($videoSelect) > 0) {
                $videoSelect = $videoSelect[0];
            }
            else {
                $videoSelect = new Videos;
            }
        }

        return $this->render('DVUserBundle:User:videos.html.twig', array(
            'type' => $type,
            'videos' => $videos,
            'videoSelect' => $videoSelect
        ));
    }

    public function videoNewAction($type)
    {
        $video = new videos;

        $video->setCategory($type);

        // On utiliser le OrdersType
        $formNewVideo = $this->createForm(new VideosType(), $video);

        // On récupère la requête
        $formNewVideo->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewVideo->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_videos_spe', array('type' => $type)));
        }

        return $this->render('DVUserBundle:User:videoNew.html.twig', array(
            'formNewVideo' => $formNewVideo->createView(),
            'type' => $type
        ));
    }

    public function videoEditAction($type, $videoId)
    {
        $video = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVMainBundle:Videos')
                            ->find($videoId);

        // On utiliser le OrdersType
        $formNewVideo = $this->createForm(new VideosType(), $video);

        // On récupère la requête
        $formNewVideo->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewVideo->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_videos_spe', array('type' => $type)));
        }

        return $this->render('DVUserBundle:User:videoNew.html.twig', array(
            'formNewVideo' => $formNewVideo->createView(),
            'type' => $type
        ));
    }

    public function videoDeleteAction($videoId, $type)
    {
        $video = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVMainBundle:Videos')
                            ->find($videoId);

        if (!$video) {
            throw $this->createNotFoundException("Aucune video à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($video);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_videos_spe', array('type' => $type)));
    }

    public function nosBesoinsAction($elementType = null, $elementId = null)
    {
        $persons = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVMainBundle:Person')
                            ->findAll();

        $projects = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVMainBundle:Project')
                            ->findAll();

        if ($elementType == 'beneficiaires' and $elementId != null) {
                $elementAsked = $this ->getDoctrine()
                                        ->getManager()
                                        ->getRepository('DVMainBundle:Person')
                                        ->find($elementId);
        }
        else if ($elementType == 'projets' and $elementId != null) {
                $elementAsked = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('DVMainBundle:Project')
                                ->find($elementId);
        }
        else {
            $elementAsked = '';
        }

        return $this->render('DVUserBundle:User:nosBesoins.html.twig', array(
            'elementAsked' => $elementAsked,
            'elementType' => $elementType,
            'persons' => $persons,
            'projects' => $projects
            ));
    }

    public function personNewAction()
    {
        $person = new Person;

        // On utiliser le OrdersType
        $formNewPerson = $this->createForm(new PersonType(), $person);

        // On récupère la requête
        $formNewPerson->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPerson->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_nosBesoins'));
        }

        return $this->render('DVUserBundle:User:personNew.html.twig', array(
            'formNewPerson' => $formNewPerson->createView()
        ));
    }

    public function personEditAction($personId)
    {
        $person = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVMainBundle:Person')
                            ->find($personId);

        // On utiliser le OrdersType
        $formNewPerson = $this->createForm(new PersonType(), $person);

        // On récupère la requête
        $formNewPerson->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPerson->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_nosBesoins_elementAjax', array('elementType' => 'beneficiaires', 'elementId' => $personId)));
        }

        return $this->render('DVUserBundle:User:personNew.html.twig', array(
            'formNewPerson' => $formNewPerson->createView()
        ));
    }

    public function personDeleteAction($personId)
    {
        $person = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVMainBundle:Person')
                            ->find($personId);

        if (!$person) {
            throw $this->createNotFoundException("Aucun bénéficiaire à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_nosBesoins'));
    }

    public function projectNewAction()
    {
        $project = new Project;

        // On utiliser le OrdersType
        $formNewProject = $this->createForm(new ProjectType(), $project);

        // On récupère la requête
        $formNewProject->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewProject->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_nosBesoins'));
        }

        return $this->render('DVUserBundle:User:projectNew.html.twig', array(
            'formNewProject' => $formNewProject->createView()
        ));
    }

    public function projectEditAction($projectId)
    {
        $project = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVMainBundle:Project')
                            ->find($projectId);

        // On utiliser le OrdersType
        $formNewProject = $this->createForm(new projectEditType(), $project);

        // On récupère la requête
        $formNewProject->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewProject->isValid()) {

            if ($_POST['finished'] == 'no_finished') {
                $project->setCompletedAt(null);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_nosBesoins_elementAjax', array('elementType' => 'projets', 'elementId' => $projectId)));
        }

        return $this->render('DVUserBundle:User:projectNew.html.twig', array(
            'formNewProject' => $formNewProject->createView()
        ));
    }

    public function projectDeleteAction($projectId)
    {
        $project = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('DVMainBundle:Project')
                            ->find($projectId);

        if (!$project) {
            throw $this->createNotFoundException("Aucun projet à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_nosBesoins'));
    }

    public function contentAction()
    {
        return $this->render('DVUserBundle:User:content.html.twig');
    }
}
