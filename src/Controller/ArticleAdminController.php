<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 *@IsGranted("ROLE_ADMIN")
 */
class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new", name="article_admin")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ArticleFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            /** @var Article $article */
            $article = $form->getData();
            $article->setAuthor($this->getUser());
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success','Article Created!');
            return $this->redirectToRoute('admin_article_list');
        }
        return $this->render('article_admin/new.html.twig',[
           'articleForm' => $form->createView(),
        ]);
    }
    /**
     *@Route("/admin/article/{id}/edit", name="admin_article_edit")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function edit(Article $article, Request $request,EntityManagerInterface $entityManager){
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            /** @var Article $article */
            $article = $form->getData();
            $article->setAuthor($this->getUser());
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success','Article Updated!');
            return $this->redirectToRoute('admin_article_edit',[
                'id'=>$article->getId(),
            ]);
        }
        return $this->render('article_admin/edit.html.twig',[
            'articleForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/article", name="admin_article_list")
     */
    public function list(ArticleRepository $articleRepository){
        $articles = $articleRepository->findAll();
         return $this->render('article_admin/list.html.twig',[
           'articles'=>$articles
        ]);
    }
}
