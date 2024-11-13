<?php

namespace App\DataFixtures;

use App\Entity\Posts;
use App\Entity\Users;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Step 1: Create Categories
        $category1 = new Categories();
        $category1->setCategory('Technology')
            ->setSlug('technology')
            ->setDisabled(0);
        $manager->persist($category1);

        $category2 = new Categories();
        $category2->setCategory('Work')
            ->setSlug('work')
            ->setDisabled(0);
        $manager->persist($category2);

        $category3 = new Categories();
        $category3->setCategory('Miscellaneous')
            ->setSlug('misc')
            ->setDisabled(0);
        $manager->persist($category3);

        $category4 = new Categories();
        $category4->setCategory('English')
            ->setSlug('eng')
            ->setDisabled(0);
        $manager->persist($category4);

        // Step 2: Create Users
        $user1 = new Users();
        $user1->setUsername('Author1')
            ->setEmail('author1@example.com')
            ->setPassword(password_hash('password123', PASSWORD_BCRYPT))
            ->setDate(new \DateTime()) // Use the current date
            ->setRoles(['ROLE_USER']);
        $manager->persist($user1);

        $user2 = new Users();
        $user2->setUsername('Author2')
            ->setEmail('author2@example.com')
            ->setPassword(password_hash('password123', PASSWORD_BCRYPT))
            ->setDate(new \DateTime()) // Use the current date
            ->setRoles(['ROLE_USER']);
        $manager->persist($user2);

        // Step 3: Create Posts
        $post1 = new Posts();
        $post1->setTitle('Whatever Title')
            ->setContent('In this post, we will discuss whatever topic')
            ->setImage('/images/post2.jpg')
            ->setDate(new \DateTime())
            ->setSlug('post1-slug')
            ->setUser($user2)
            ->setCategory($category3); // Assign Others category
        $manager->persist($post1);


        $post2 = new Posts();
        $post2->setTitle('Maintaining Good Health')
            ->setContent('In this post, we will discuss various tips and strategies for maintaining good health and well-being.')
            ->setImage('/images/post3.jpg')
            ->setDate(new \DateTime())
            ->setSlug('maintaining-good-health')
            ->setUser($user2)
            ->setCategory($category2);
        $manager->persist($post2);

        $post3 = new Posts();
        $post3->setTitle('The Future of Technology')
            ->setContent('Technology is evolving at an unprecedented pace. In this post, we will explore the latest trends in tech.')
            ->setImage('/images/cyborg-eye.jpg')
            ->setDate(new \DateTime())
            ->setSlug('the-future-of-technology')
            ->setUser($user1)
            ->setCategory($category1);
        $manager->persist($post3);


        // Flush all created entities to the database at the same time
        $manager->flush();
    }
}
