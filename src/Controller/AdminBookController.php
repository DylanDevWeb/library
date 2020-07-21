<?php
//PERMET D'IDENTIFIER MA CLASSE
namespace App\Controller;

use App\Entity\Books;
use App\Form\BookType;
use App\Repository\BooksRepository; //SYMFONY INSTANCIE LA CLASSE "BooksRepository"
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;//IMPORT DU NAMESPACE POUR ABSTRACTCONTROLLER
use Symfony\Component\HttpFoundation\Request;   //IMPORT DU NAMESPACE POUR Request
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; //IMPORT DU NAMESPACE POUR LES ROUTES


//LA CLASS "AdminBookController" ETEND LA CLASS "AbstractController" POUR BENEFICIER DE PLUS DE METHODES
class AdminBookController extends AbstractController{

    /**
     * @Route("/admin/books", name="admin_books")  //--> ANNOTATION
     */
    //METHODE AVEC EN PARAMETRE LA CLASSE VOULUE SUIVIE D'UNE VARIABLE DANS LAQUELLE JE VEUX QUE SYMFONY INSTANCIE MA CLASSE
    //(l'BooksRepository EST LA CLASSE QUI PERMET DE FAIRE DES REQUETES "SELECT" DANS LA TABLE "books")
    public function AdminBooks(BooksRepository $booksRepository){

        //LA METHODE "findAll" SERT A RECUPERER TOUS LE ELEMENTS DE MA TABLE "books"
        $books = $booksRepository->findAll();

        return $this->render('admin/admin_books.html.twig', [  //--> RENVOI HTML/TWIG, EN UTILISANT LA METHODE "RENDER"
            'books' => $books   //--> VARIABLE A UTILISER DANS LE HTML/TWIG
        ]);
    }

    /********************************************************************/


    /**
     * @Route("/admin/books/delete/{id}", name="admin_book_delete")  //--> ANNOTATION
     */
    public function AdminBookDelete(BooksRepository $booksRepository, EntityManagerInterface $entityManager, $id){

        //JE SELECT UNE ENTITE AVEC LA METHODE "find"
        $book = $booksRepository->find($id);

        $entityManager->remove($book); //METHODE POUR SUPPRIMER
        $entityManager->flush(); //EQUIVALENT A "PUSH" MAIS POUR LA BDD

        return $this->redirectToRoute('admin_books'); //REDIRECTION VERS UNE ROUTE
    }

    /********************************************************************/


    /**
     * @Route("/admin/books/insert", name="admin_book_insert")  //--> ANNOTATION
     */
    public function AdminBookInsert(Request $request, EntityManagerInterface $entityManager){

        //JE CREE UNE NOUVELLE INSTANCE DE L'ENTITE
        $book = new Books();

        //JE LUI DIS DE CREER UN FORM DANS MON "new book"
        $bookform = $this->createForm(BookType::class, $book);

        //FAIT LE LIEN ENTRE LE FORMULAIRE ET LES DONNEES "post"
        //(handleRequest->formluaire et ($request)->données post)
        $bookform->handleRequest($request);

        //SI MON "$bookform" EST ENVOYER ET VALIDER ALORS persist ET flush
        if($bookform->isSubmitted() && $bookform->isValid()){
            $entityManager->persist($book); //EQUIVALENT DE "commit"
            $entityManager->flush();     //EQUIVALENT DE "push"

            $this->addFlash('sucess', 'Votre livre à bien été ajouter bravo !') ;

            return $this->redirectToRoute('admin_books'); //REDIRECTION VERS UNE ROUTE
        }
        return $this->render('admin/admin_books_insert.html.twig',[  //--> RENVOI HTML/TWIG, EN UTILISANT LA METHODE "RENDER"
            'bookform' => $bookform->createView()   //--> VARIABLE A UTILISER DANS LE HTML/TWIG, createView()->POUR CREER LA VU DU FORMULAIRE
        ]);
    }

    /********************************************************************/


    /**
     * @Route("/admin/books/update/{id}", name="admin_book_update")  //--> ANNOTATION
     */
    public function AdminBookUpdate(Request $request, EntityManagerInterface $entityManager, BooksRepository $booksRepository, $id){

        $book = $booksRepository->find($id);

        $bookform = $this->createForm(BookType::class, $book);

        $bookform->handleRequest($request);

        if($bookform->isSubmitted() && $bookform->isValid()){
            $entityManager->persist($book);
            $entityManager->flush();
            return $this->redirectToRoute('admin_books'); //REDIRECTION VERS UNE ROUTE
        }
        return $this->render('admin/admin_books_update.html.twig',[
            'bookform' => $bookform->createView(),
        ]);
    }

    /********************************************************************/

    /**
     * @Route("/admin/book/insert", name="insert_book_genre")
     */
    public function InsertBookWithGenre(GenreRepository $genreRepository, EntityManagerInterface $entityManager){

        $genre = $genreRepository->find(2);

        $book = new Books();

        $book->setTitle('Nouveau titreuh');
        $book->setNbPages(120);
        $book->setResume('blablablablablablablablablabla');
        $book->setGenre($genre);

        $entityManager->persist($book);
        $entityManager->flush();

        return new Response('livre enregistré');

    }


}

