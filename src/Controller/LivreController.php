<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
// objet request, qu'il faudra instancier. Il permet de récup le contenu de $_POST
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LivreRepository;

class LivreController extends AbstractController
{
    #[Route('/livre', name: 'livre')]
    public function index(LivreRepository $livreRepository): Response
    {
        // Pour récupérer la liste de tous les livres enregistrés en bdd, je vais utiliser la classe LivreRepository. 
        // Les classes Repository permettent de faire des requêtes SQL sur la table correspondante.
        // Vous ne pouvez pas instancier un objet de la classe Repository (comme Request, EntityManager, ...), il faut donc utiliser l'injection de dépendance, c-a-d que la classe à utiliser est passée en param d'une fonction et sera directement instanciée par Symfony

        //La méhode 'findAll' récupère tous les enregistrements d'une table et retourne une liste d'objets Entity
        $livres = $livreRepository->findAll();
        return $this->render('livre/index.html.twig', [
            'livres' => $livres
        ]);
    }

    /**
     * @Route("/livre/ajouter", name="livre_ajouter")
     */
    public function ajouter(Request $request, EntityManager $em)
    // instanciation de EntityManager dans les param de la fonction
    // request s'instancie automatiquement
    {
        //dump($request);
        if ($request->isMethod("POST")) {
            /*l'objet de la classe request a des propriétés qui contiennent les valeurs d toutes les variables superglobales de PHP ($_GET, $_POST, ...)
            Pour $_GET, la propriété 'query'
            Pour $_POST, la propriété 'request'

            Ces propriétés sont des objets. Avec la fonction get, je peux récupérer la valeur de l'indice demandé. 
            */
            $titre = $request->request->get("titre");
            $auteur = $request->request->get("auteur");

            $livre = new Livre;
            $livre->setTitre($titre);
            $livre->setAuteur($auteur);
            // La classe EntityManager va  permettre d'enregistrer en base de données
            // La méthode 'persist' permet de préparer une requête INSERT INTO à partir d'un objet d'une classe Entity
            $em->persist($livre);
            // La méthode 'flush" execute toutes les requêtes SQL en attente
            $em->flush();

            // Pour faire une redirection vers une route existante, on utilise redirectToRoute avec le name d'une route en paramètre
            return $this->redirectToRoute("livre");



            // La fonction dd (dump & die) affiche un var-dump et arrête l'execution du php (fonction die)
            //dd($titre, $auteur);
        }
        return $this->render("livre/formulaire.html.twig");
    }

    /**
     * @Route("/livre/nouveau", name="livre_nouveau")
     */
    public function nouveau(Request $request, EntityManager $em)
    {
        $livre = new Livre;
        $formLivre = $this->createForm(LivreType::class, $livre);
        // handleRequest : permet à la variable $formLivre de gérer les infos envoyées par le navigateur
        $formLivre->handleRequest($request);
        if ($formLivre->isSubmitted() && $formLivre->isValid()) {
            $em->persist($livre);
            $em->flush();
            return $this->redirectToRoute("livre");
        }
        return $this->render("livre/form.html.twig", ["form" => $formLivre->createView()]);
    }

    /**
     * @Route("/livre/modifier/{id}", name="livre_modifier", requirements={"id" = "\d+"})
     */
    public function modifier(EntityManager $em, Request $request, LivreRepository $lr, $id)
    {
        $livre = $lr->find($id); // find() permet de récupérer les infos du livre qui à l'identifiant passé en param
        $formLivre = $this->createForm(LivreType::class, $livre);
        // handleRequest : permet à la variable $formLivre de gérer les infos envoyées par le navigateur
        $formLivre->handleRequest($request);
        if ($formLivre->isSubmitted() && $formLivre->isValid()) {
            //$em->persist($livre);
            // Pour modifier un enregistrement, pas besoin d'utiliser persist() d'EntityManager.
            // Toutes les variables entités qui ont un id non null vont être enregistrées en bdd quand la méthode 'flush' sera appelé
            $em->flush();
            return $this->redirectToRoute("livre");
        }
        return $this->render("livre/form.html.twig", ["form" => $formLivre->createView()]);
    }

    /**
     * @Route("/livre/supprimer/{id}", name="livre_supprimer", requirements={"id" = "\d+"})
     * 
     * En passant un objet Livre comme paramètre de la méthode supprimer, $livre sera récupéré dans la bdd selon la valeur {id} passée dans l'URL de la route
     */
    public function supprimer(EntityManager $em, Request $request, Livre $livre)
    {
        if ($request->isMethod("POST")) {
            // remove() prépare la requête DELETE
            $em->remove($livre);
            $em->flush();
            return $this->redirectToRoute("livre");
        }
        return $this->render("livre/supprimer.html.twig", ["livre" => $livre]);
    }
}
