<?php
//PERMET D'IDENTIFIER MA CLASSE
namespace App\Controller;


use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;//IMPORT DU NAMESPACE POUR ABSTRACTCONTROLLER
use Symfony\Component\Routing\Annotation\Route;


//LA CLASS "AdminAuthorController" ETEND LA CLASS "AbstractController" POUR BENEFICIER DE PLUS DE METHODES
class AdminAuthorController extends AbstractController{

    /**
     * @Route("/admin/authors", name="admin_authors")
     */
    public function AdminAuthors(AuthorRepository $authorRepository){

        $authors = $authorRepository->findAll();

        return $this->render('admin/admin_authors.html.twig',[
            'authors' => $authors
        ]);
    }

    /********************************************************************/


    /**
     * @Route("/admin/authors/delete/{id}", name="admin_author_delete")
     */
    public function AdminAuthorDelete(AuthorRepository $authorRepository, EntityManagerInterface $entityManager, $id){

        //JE SELECT UNE ENTITE AVEC LA METHODE "find"
        $author = $authorRepository->find($id);

        $entityManager->remove($author); //METHODE POUR SUPPRIMER
        $entityManager->flush(); //EQUIVALENT A "PUSH" MAIS POUR LA BDD

        return $this->redirectToRoute('admin_authors');
    }


    /********************************************************************/

    /**
     * @Route("/admin/authors/insert", name="admin_author_insert")
     */
    public function AdminAuthorInsert(Request $request, EntityManagerInterface $entityManager){

        $author = new Author();

        $authorForm = $this->createForm(AuthorType::class, $author);

        $authorForm->handleRequest($request);

        if($authorForm->isSubmitted() && $authorForm->isValid()){
            $entityManager->persist($author);
            $entityManager->flush();

            $this->addFlash('sucess', 'Votre auteur à bien été ajouter bravo !') ;

            return $this->redirectToRoute('admin_authors');
        }

        return $this->render('admin/admin_authors_insert.html.twig',[
            'authorform' => $authorForm->createView(),
        ]);


    }

    /********************************************************************/


    /**
     * @Route("/admin/authors/update/{id}", name="admin_author_update")
     */
    public function AdminAuthorUpdate(Request $request, EntityManagerInterface $entityManager, AuthorRepository $authorRepositorysRepository, $id){

        $author = $authorRepositorysRepository->find($id);

        $authorForm = $this->createForm(AuthorType::class, $author);

        $authorForm->handleRequest($request);

        if($authorForm->isSubmitted() && $authorForm->isValid()){
            $entityManager->persist($author);
            $entityManager->flush();
            return $this->redirectToRoute('admin_authors');
        }
        return $this->render('admin/admin_authors_update.html.twig',[
            'authorform' => $authorForm->createView(),
        ]);
    }

    /********************************************************************/


}
