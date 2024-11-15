<?php

namespace App\Controller;

use App\Entity\Posts;
//use App\Form\PostFormType;
use App\Form\PostFormType;
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


    // Create a Post
    #[Route('/posts/create', name: 'app_create_posts')]
    public function create(Request $request): Response
    {
        $posts = new Posts();
        $form = $this->createForm(PostFormType::class, $posts);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newPosts = $form->getData();

            //  dd($newPosts);
            // exit;

            $image = $form->get('image')->getData();
            if ($image) {
                $newFileName = (uniqid()) . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $newPosts->setImage('/uploads/' . $newFileName);
            }

            $this->em->persist($newPosts);
            $this->em->flush();

            return $this->redirectToRoute('app_posts');
        }

        return $this->render('posts/create.html.twig', [
            // key => value -> method()
            'form' => $form->createView(),
        ]);
    }


    // Edit a post
    #[Route('/posts/edit/{id}', name: 'app_edit_posts')]
    public function edit($id, Request $request): Response
    {
        // dd($id);
        // exit;

        // Db call
        $post = $this->postsRepository->find($id);
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);
        $image = $form->get('image')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image) {
                // Handle image upload
                if ($post->getImage() !== null) {
                    // Users are always guilty until proven innocent! ;-)
                    if (file_exists(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/' . $post->getImage()
                    )) {
                        $this->getParameter('kernel.project_dir') . '/public/uploads/' . $post->getImage();
                    }
                    $newFileName = uniqid() . '.' . $image->guessExtension();

                    try {
                        $image->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads',
                            $newFileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }

                    $post->setImage('/uploads/' . $newFileName);
                    $this->em->flush();

                    return $this->redirectToRoute('app_posts');
                }

            }else {
                // dd("Ok");

                $post->setTitle($form->get('title')->getData());
                $post->setContent($form->get('content')->getData());
                $post->setDate($form->get('date')->getData());
                $post->setSlug($form->get('slug')->getData());
                $post->setUser($form->get('user')->getData());
                $post->setCategory($form->get('category')->getData());

                $this->em->flush();
                return $this->redirectToRoute('app_posts');
            }
        }

        return $this->render('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }


    // Delete a post
    #[Route('/posts/delete/{id}', name: 'app_delete_posts', methods: ['GET', 'DELETE'])]
    public function delete($id): Response
    {
        $post = $this->postsRepository->find($id);
        $this->em->remove($post);
        $this->em->flush();

        return $this->redirectToRoute('app_posts');
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