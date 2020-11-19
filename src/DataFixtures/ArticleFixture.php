<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;

class ArticleFixture extends BaseFixture
{
    private static $articleTitles = [
      'Title1',
      'Title3',
      'Title2',
    ];
    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',

    ];
    private static $articleAuthors = [
        'Renato',
        'Shkulaku',

    ];
    protected function loadData(ObjectManager $manager)
    {
       $this->createMany(Article::class,10,function (Article $article,$count) use ($manager){
            $article->setTitle($this->faker->randomElement(self::$articleTitles))->setContent(' Spicy jalapeno bacon ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
                lorem proident beef ribs aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
                labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
                turkey shank eu pork belly meatball non cupim.
                Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
                laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
                capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
                picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
                occaecat lorem meatball prosciutto quis strip steak.')->setAuthor($this->faker->randomElement(self::$articleAuthors))->setHeartCount($this->faker->numberBetween(5,100))->setImageFilename($this->faker->randomElement(self::$articleImages));
//            $comment1 = new Comment();
//            $comment1->setAuthorName('renato');
//            $comment1->setMessage('nice');
//            $comment1->setArticle($article);
//            $manager->persist($comment1);
//            $comment2 = new Comment();
//            $comment2->setAuthorName('renato');
//            $comment2->setMessage('nice');
//            $comment2->setArticle($article);
//            $manager->persist($comment2);
//            $article->addComment($comment1);
//            $article->addComment($comment2);
            if ($this->faker->boolean(70)){
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days','-1 days'));
            }
        });
        $manager->flush();
    }
}
