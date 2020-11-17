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
        $entityManager->flush();

        $title = $request->request->get('title');
        $slug  = $request->request->get('slug');
        $content = $request->request->get('content');
        $datetime = $request->request->get('published_at');
        $em = $this->getDoctrine()->getManager();
        $article = new Article();
        $article->setTitle('Why Asteroids Taste Like Backon')->setSlug('why-asteroids-taste-like-backon'.rand(100,999))->setContent(' Spicy jalapeno bacon ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
                lorem proident beef ribs aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
                labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
                turkey shank eu pork belly meatball non cupim.
                Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
                laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
                capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
                picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
                occaecat lorem meatball prosciutto quis strip steak.');
        if(rand(1,10>0)){
            $article->setPublishedAt(new \DateTime(sprintf('-%d days',rand(1,100))));
        }
        $em->persist($article);
        $em->flush();
        return new Response(sprintf(
            'Hi!New article id:#%d slug : %s',
            $article->getId(),
            $article->getSlug()
        ));
    }
}
