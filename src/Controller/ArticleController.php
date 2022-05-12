<?php

namespace App\Controller;

use App\Entity\MAarticle;
use App\Form\ArticleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/article/detail/{id} ', name: 'article.detail')]
    public function  detail( MAarticle $article=null){
        if (!$article){
            $this->addFlash('error','Article not found'); 
            return $this->redirectToRoute('app_article');

        }else{
            return $this->render('article/detail.html.twig', [
                'article' => $article,
            ]);

        }

    }


    #[Route('/article/edit/{id?0} ', name: 'article.edit')]
    public function editArticle(ManagerRegistry $doctrine , Request $request, MAarticle $article=null): Response
    {
      
        if (!$article){
            $article= new MAarticle();
        }

        $form=$this->createForm(ArticleType::class , $article); 
        $form->handleRequest($request);
        if($form->isSubmitted()){ 
            //$form->getData()
            $entityManager = $doctrine->getManager(); 
            $entityManager->persist($article);

            $entityManager->flush();
            $this->addFlash("success"," your changes are saved  ");
            return $this->redirectToRoute('app_article');
            

        }else{
            return $this->render('article/form.html.twig', [
                'form' => $form->createView(),
            ]);


         
    }
}

#[Route('/article/remove/{id?0} ', name: 'article.remove')]
public function remove(ManagerRegistry $doctrine , MAarticle $article=null  ){
    if ($article ==null){
        $this->addFlash('error','Article not found'); 
        return ($this->redirectToRoute('app_article'));

    }else {
        $manager=$doctrine->getManager(); 
        //ajout la fonction de suppression dans la transaction 
        $manager->remove($article);
        //excecuter la transaction 
        $manager->flush();
        $s=$article->getNom();
        $this->addFlash('success', " $s successfully removed "); 
        return ($this->redirectToRoute('app_article'));

    } 

}

}


