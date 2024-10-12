<?php
namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{ #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/author/show/{name}', name: 'show_author')]
    public function showAuthor(string $name): Response
    {
        return $this->render('author/show.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/author/list', name: 'list_authors')]
    public function listAuthors(): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/victor.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/taha.jpg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200),
            array('id' => 3, 'picture' => '/images/sheks.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );

        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/author/details/{id}', name: 'author_details')]
    public function authorDetails(int $id): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/victor.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/taha.jpg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200),
            array('id' => 3, 'picture' => '/images/sheks.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );

        // Find the author by id
        $author = array_filter($authors, fn($a) => $a['id'] == $id);
        
        if (!$author) {
            throw $this->createNotFoundException('Author not found.');
        }

        return $this->render('author/show.html.twig', [
            'author' => array_shift($author),  
        ]);
    }
    #[Route('/read',name:'app_read')]
    public function read(AuthorRepository $repo):Response
    {$list= $repo->findAll();
        return $this->render('author/read.html.twig',
        ['authors'=>$list]);
    }
    #[Route('/delete/{id}',name:'app_delete')]
    public function delete($id,ManagerRegistry $doctrine){
        $repository=$doctrine->getRepository(Author::class);
        $author=$repository->find($id);
        $entityManager=$doctrine->getManager();
        $entityManager->remove($author);
        $entityManager->flush();
        $this->addFlash('success', 'author deleted successfully!');
        return $this->redirectToRoute('app_read');
            }
            
            #[Route('/ajout',name:'app_ajout')]
            public function create(Request $request,ManagerRegistry $doctrine){
                $author=new Author();//créer un nouveau author
               // $author->setUsername('aaa');
                //$author->setEmail('aaa@gmail.com');
                $form=$this->createForm(AuthorType::class,$author);
                //créer un formulaire à partir du formType
                $form->handleRequest($request);//gerer les données recus à partir du form 
               if ($form->isSubmitted()&& $form->isValid())// pour le controle de saisie
               { $em=$doctrine->getManager();
                $em->persist($author);
                $em->flush();
                return $this->redirectToRoute('app_read');
               }
              // return $this->renderForm('author/add.html.twig',array('form'=>$form)); 
 //ou  2eme méthode
 return $this->render('author/add.html.twig',['formA'=>$form->createView()]);
            }
          
        // fonction update 
        #[Route('/update/{id}',name:'update')]
        public function update($id,AuthorRepository $repo ,Request $request,ManagerRegistry $doctrine){
            $author=$repo->find($id);
            $form=$this->createForm(AuthorType::class,$author);
            //créer un formulaire à partir du formType
            $form->handleRequest($request);//gerer les données recus à partir du form 
           if ($form->isSubmitted()&& $form->isValid())// pour le controle de saisie
           { $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_read');
           }
         
return $this->render('author/update.html.twig',['formA'=>$form->createView()]);
        }
}
