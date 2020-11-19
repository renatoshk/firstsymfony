<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new", name="article_admin")
     */
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        die('todo');
        return new Response(sprintf(
            'Hi!New article id:#%d slug : %s',
            $article->getId(),
            $article->getSlug()
        ));
    }
}
