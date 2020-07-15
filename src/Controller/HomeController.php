<?php
//PERMET D'IDENTIFIER MA CLASSE
namespace App\Controller;

use App\Repository\BooksRepository;   //IMPORT DU NAMESPACE POUR BooksRepository
use App\Repository\AuthorRepository;   //IMPORT DU NAMESPACE POUR AuthorRepository
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;   //IMPORT DU NAMESPACE POUR ABSTRACTCONTROLLER
use Symfony\Component\Routing\Annotation\Route; //IMPORT DU NAMESPACE POUR LES ROUTES


//LA CLASS "HomeController" ETEND LA CLASS "AbstractController" POUR BENEFICIER DE PLUS DE METHODES
class HomeController extends AbstractController{

    /**
     * @Route("/accueil", name="accueil")  //--> ANNOTATION
     */
    public function accueil(BooksRepository $booksRepository, AuthorRepository $authorRepository){

        $last_books = $booksRepository->findBy([], ['id' => 'DESC'], 3);
        $last_authors = $authorRepository->findBy([],['id' => 'DESC'], 3);

        return $this->render('accueil.html.twig', [
            'last_books' => $last_books,
            'last_authors' => $last_authors
        ]);
    }
}

    /********************************************************************/

