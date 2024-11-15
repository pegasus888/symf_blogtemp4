<?php

namespace App\Controller;

use App\Entity\Posts;
//use App\Form\PostFormType;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostsController extends AbstractController
{
    private $em;
    private $postsRepository;

    public function __construct(EntityManagerInterface $em, PostsRepository $postsRepository)
    {
        $this->em = $em;
        $this->postsRepository = $postsRepository;
    }

    // Display all Posts
    #[Route('/posts', name: 'app_posts', methods: ['GET'])]
    public function index(): Response
    {
        // findAll - SELECT * FROM posts;
        $posts = $this->postsRepository->findAll();
        // dd($posts);

        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    // Display a Single Post
    #[Route('/posts/{id}', name: 'app_singlepost_posts', methods: ['GET'])]
    public function singlepost($id): Response
    {
        // find- SELECT  FROM posts;
        $post = $this->postsRepository->find($id);
        // dd($posts);

        return $this->render('posts/singlepost.html.twig', [
            'post' => $post,
        ]);
    }
}