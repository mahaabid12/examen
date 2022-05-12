<?php

namespace App\DataFixtures;

use App\Entity\MAarticle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory; 

class Article extends Fixture
{
   
    public function load(ObjectManager $manager): void
  
    {
        $faker= Factory::create(); 
        for($i=1 ; $i<10 ; $i++){
            $article=new MAarticle(); 
            $article->setNom("article".$i); 
            $article->setPrix($faker->numberBetween(1000,10000)); 
            $manager->persist($article);
        }

        $manager->flush();
    }
}
