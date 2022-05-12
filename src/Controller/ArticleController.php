<?php

namespace App\Controller;

use App\Entity\MAarticle;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(MAarticle::class);
        $articles=$repository->findAll(); 

        return $this->render('article/index.html.twig', [
            'articles' => $articles ,
        ]);
    }
}
