<?php
//PERMET D'IDENTIFIER MA CLASSE
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;   //IMPORT DU NAMESPACE POUR ABSTRACTCONTROLLER
use App\Repository\BooksRepository; //SYMFONY INSTANCIE LA CLASSE "BooksRepository"
use Symfony\Component\HttpFoundation\Request;   //IMPORT DU NAMESPACE POUR Request
use Symfony\Component\Routing\Annotation\Route; //IMPORT DU NAMESPACE POUR LES ROUTES


//LA CLASS "BookController" ETEND LA CLASS "AbstractController" POUR BENEFICIER DE PLUS DE METHODES
class BookController extends AbstractController{

    /**
     * @Route("/books", name="books_list")  //--> ANNOTATION
     */
    //METHODE AVEC EN PARAMETRE LA CLASSE VOULUE SUIVIE D'UNE VARIABLE DANS LAQUELLE JE VEUX QUE SYMFONY INSTANCIE MA CLASSE
    //(l'BooksRepository EST LA CLASSE QUI PERMET DE FAIRE DES REQUETES "SELECT" DANS LA TABLE "books")
    public function BooksList(BooksRepository $booksRepository){

        //LA METHODE "findAll" SERT A RECUPERER TOUS LE ELEMENTS DE MA TABLE "books"
        $books = $booksRepository->findAll();
        return $this->render('books.html.twig', [  //--> RENVOI HTML/TWIG, EN UTILISANT LA METHODE "RENDER"
           'books' => $books   //--> VARIABLE A UTILISER DANS LE HTML/TWIG
        ]);
    }

    /********************************************************************/

    /**
     * @Route("/book/{id}", name="book_show")  //--> ANNOTATION
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

    /********************************************************************/

    /**
     * @Route("/books/genre/{genre}", name="books_genre")  //--> ANNOTATION
     */
    public function BookByGenre(BooksRepository $booksRepository, $genre){

        $books = $booksRepository-> findBy(['genre' => $genre]);
        return $this->render('book_genre.html.twig', [
            'books' => $books,
            'genre' => $genre
        ]);

    }

    /********************************************************************/

    /**
     * @Route("/books/search/resume", name="books_search")  //--> ANNOTATION
     */
    //METHODE AVEC EN PARAMETRE LA CLASSE VOULUE SUIVIE D'UNE VARIABLE DANS LAQUELLE JE VEUX QUE SYMFONY INSTANCIE MA CLASSE
    //(l'BooksRepository EST LA CLASSE QUI PERMET DE FAIRE DES REQUETES "SELECT" DANS LA TABLE "books")
    //(l'Request EST LA CLASSE QUI ME PERMET DE RECUPERER LES VALEURS EN PARAMETRE D'URL
    public function booksByWords(BooksRepository $booksRepository, Request $request){

        //JE MET DANS MA VARIABLE "$word", MA "$request", EN UTILISANT LA METHODE "query->get()"
        //POUR RECUPERE LA VALEUR DU PARAMETRE D'URL
        $word= $request->query->get('search');

        //JE CREER UNE VAIRABLE "$books" POUR NE PA AVOIR D'ERREUR
        //SI JE N'AI RIEN EN PARMAETRE D'URL
        $books = [];

        //SI MA VARIABLE "$word" N'EST PAS VIDE, ALORS SA ACTIVE MA VARIABLE "$books",
        //QUI UTILISE LA METHODE "findByWordsInResume" DANS MA VARIABLE "$booksRepository"
        //SINON SE NE M'AFFICHE RIEN
        if (!empty($word)){
            $books = $booksRepository->findByWordsInResume($word);
        }
        //SA ME RETOURNE UN FICHIER TWIG DANS LEQUEL J'AI UN "form" POUR MA RECHERCHE
        return $this->render('search.html.twig',[  //--> RENVOI HTML/TWIG, EN UTILISANT LA METHODE "RENDER"
            'books' => $books   //--> VARIABLE A UTILISER DANS LE HTML/TWIG
        ]);

    }
}