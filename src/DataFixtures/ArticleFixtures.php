<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Enum\ArticleStatus;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use DateTimeImmutable;

/**
 * Class ArticleFixtures.
 */
class ArticleFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(100, 'articles', function (int $i) {
            $article = new Article();
            $article->setTitle($this->faker->sentence);
            $article->setContent($this->faker->sentence);
            $article->setCreatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $article->setUpdatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );

            $category = $this->getRandomReference('categories');
            $article->setCategory($category);

            $tags = $this->getRandomReferences('tags', $this->faker->numberBetween(1, 5));
            foreach ($tags as $tag) {
                $article->addTag($tag);
            }

            // Przekształć losową liczbę na stan artykułu
            $article->setStatus(ArticleStatus::from($this->faker->numberBetween(1, 2)));

            $author = $this->getRandomReference('users');
            $article->setAuthor($author);

            return $article;
        });

        $this->manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class, TagFixtures::class, UserFixtures::class];
    }
}
