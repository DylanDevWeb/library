<?php

//PERMET D'IDENTIFIER MA CLASSE
namespace App\Controller;

//SYMFONY INSTANCIE LA CLASSE "AuthorRepository"
use App\Repository\AuthorRepository;
//IMPORT DU NAMESPACE POUR ABSTRACTCONTROLLER
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//IMPORT DU NAMESPACE POUR LES ROUTES
use Symfony\Component\Routing\Annotation\Route;

//LA CLASS "AuthorController" ETEND LA CLASS "AbstractController" POUR BENEFICIER DE PLUS DE METHODES
class AuthorController extends AbstractController{

    /**
     * @Route("/authors", name="authors_list")  //--> ANNOTATION
     */
    //METHODE AVEC EN PARAMETRE LA CLASSE VOULUE SUIVIE D'UNE VARIABLE DANS LAQUELLE JE VEUX QUE SYMFONY INSTANCIE MA CLASSE
    //(l'AuthorRepository EST LA CLASSE QUI PERMET DE FAIRE DES REQUETES "SELECT" DANS LA TABLE "authors")
    public function AuthorsList(AuthorRepository $authorRepository)
    {
        //LA METHODE "findAll" SERT A RECUPERER TOUS LE ELEMENTS DE MA TABLE "authors"
        $authors = $authorRepository->findAll();
        return $this->render('authors.html.twig', [  //--> RENVOI HTML/TWIG, EN UTILISANT LA METHODE "RENDER"
            'authors' => $authors   //--> VARIABLE A UTILISER DANS LE HTML/TWIG
        ]);
    }

    /********************************************************************/

    /**
     * @Route("/author/{id}", name="author_show")  //--> ANNOTATION
     */
    //METHODE AVEC EN PARAMETRE LA CLASSE VOULUE SUIVIE D'UNE VARIABLE DANS LAQUELLE JE VEUX QUE SYMFONY INSTANCIE MA CLASSE
    //(l'AuthorRepository EST LA CLASSE QUI PERMET DE FAIRE DES REQUETES "SELECT" DANS LA TABLE "authors")
    public function AuthorsShow(AuthorRepository $authorRepository, $id){

        //LA METHODE "find" + LE "($id)" SERT A RECUPERER UN ELEMENT DE MA TABLE "authors" EN FONCTION DE SON ID
        $author = $authorRepository->find($id);

        return $this->render('author_show.html.twig', [  //--> RENVOI HTML/TWIG, EN UTILISANT LA METHODE "RENDER"
            'author' => $author   //--> VARIABLE A UTILISER DANS LE HTML/TWIG
        ]);
    }
}