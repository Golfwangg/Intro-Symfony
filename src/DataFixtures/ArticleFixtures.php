<?php


namespace App\DataFixtures;

use App\Service\Slugify;
use Faker;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_EN');
        $slugify = new Slugify();

        for ($i = 1; $i <= 50; $i++) {
            $article = new Article();
            $article->setTitle(mb_strtolower($faker->sentence()));
            $article->setContent(mb_strtolower($faker->realText()));
            $article->setCategory($this->getReference('category_' . (mt_rand(0, 5))));
            $article->setSlug($slugify->generate($article->getTitle()));
            $manager->persist($article);
        }
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
