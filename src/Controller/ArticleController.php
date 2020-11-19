<?php


namespace App\Controller;


use App\Entity\Article;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(EntityManagerInterface $em){
        $rep = $em->getRepository(Article::class);
        $articles = $rep->findAllPublishedByNewest();
        return $this->render('articles/homepage.html.twig',[
            'articles'=>$articles,
        ]);
    }
    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug){

        /** @var Article $article */
        $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy(['slug'=>$slug]);
        if(!$article){
            throw $this->createNotFoundException(sprintf('No article found with this slug "%s" ',$slug));
        }
//        $comments = $commentRepository->findBy(['article'=>$article]);
//        $comments = $article->getComments();
//        foreach ($comments as $comment){
//            dd($comment);
//        }
        return $this->render('articles/show.html.twig', [
            'article'=>$article,
        ]);
    }
    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $entityManager){
        $article->incrementHeartCount();
        $entityManager->flush();
        $logger->info('hearted');
        return new JsonResponse(['hearts'=>$article->getHeartCount()]);
    }

}