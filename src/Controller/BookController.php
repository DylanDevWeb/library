<?php
//PERMET D'IDENTIFIER MA CLASSE
namespace App\Controller;

//IMPORT DU NAMESPACE POUR ABSTRACTCONTROLLER
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//SYMFONY INSTANCIE LA CLASSE "BooksRepository"
use App\Repository\BooksRepository;

//IMPORT DU NAMESPACE POUR LES ROUTES
use Symfony\Component\Routing\Annotation\Route;

//LA CLASS "BookController" ETEND LA CLASS "AbstractController" POUR BENEFICIER DE PLUS DE METHODES
class BookController extends AbstractController{

    /**
     * @Route("/books", name="books_list")  //--> ANNOTATION
     */
    //METHODE AVEC EN PARAMETRE LA CLASSE VOULUE SUIVIE D'UNE VARIABLE DANS LAQUELLE JE VEUX QUE SYMFONY INSTANCIE MA CLASSE
    //(l'BooksRepository EST LA CLASSE QUI PERMET DE FAIRE DES REQUETES "SELECT" DANS LA TABLE "books")
    public function BooksList(BooksRepository $booksRepository){

        //LA METHODE "findAll" SERT A RECUPERER TOUS LE ELEMENTS DE MA TABLE "authors"
        $books = $booksRepository->findAll();
        return $this->render('books.html.twig', [  //--> RENVOI HTML/TWIG, EN UTILISANT LA METHODE "RENDER"
           'books' => $books   //--> VARIABLE A UTILISER DANS LE HTML/TWIG
        ]);
    }

    /********************************************************************/

    /**
     * @Route("/book/{id}", name="book_show")
     */
    //METHODE AVEC EN PARAMETRE LA CLASSE VOULUE SUIVIE D'UNE VARIABLE DANS LAQUELLE JE VEUX QUE SYMFONY INSTANCIE MA CLASSE
    //(l'BooksRepository EST LA CLASSE QUI PERMET DE FAIRE DES REQUETES "SELECT" DANS LA TABLE "books")
    public function Book(BooksRepository $booksRepository, $id){

        //LA METHODE "find" + LE "($id)" SERT A RECUPERER UN ELEMENT DE MA TABLE "books" EN FONCTION DE SON ID
        $book = $booksRepository->find($id);
        return $this->render('book_show.html.twig', [  //--> RENVOI HTML/TWIG, EN UTILISANT LA METHODE "RENDER"
            'book' => $book   //--> VARIABLE A UTILISER DANS LE HTML/TWIG
        ]);
    }
}