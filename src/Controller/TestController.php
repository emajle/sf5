<?php

// App fait ref à src
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{

    /**
     * Toutes les méthodes d'un contrôleur (qui correspondent à une route) doivent retourner un objet de la classe Response
     * 
     * @Route("/test", name= "test")
     */
    public function index(): Response // response: la fonction va retourner un objet de la classe response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }

    /**
     * @Route("/test/accueil", name="test_accueil")
     */
    public function accueil()
    {


        $nombre = 45;
        $prenom = "Roger";
        return $this->render("base.html.twig", ["nombre" => $nombre, "prenom" => $prenom]);
    }

    /**
     * @Route("/test/heritage")
     */
    public function heritage()
    {


        return $this->render("test/heritage.html.twig");
    }

    /**
     * @Route("/test/transitif")
     */
    public function transitif()
    {

        return $this->render("test/transitif.html.twig");
    }

    /**
     * @Route("/test/tableau")
     */
    public function tableau()
    {
        $tab = ["jour" => "07", "mois" => "mai", "annee" => 2021];
        return $this->render("test/variables.html.twig", [
            "tableau" => $tab,
            "tableau2" => [45, "test", true],
            "nombre" => 5,
            "chaine" => ""
        ]);
    }

    /**
     * @Route("/test/salutation/{prenom}")
     */
    public function salutation($prenom = "inconnu")
    {
        // Si on donne une valeur par défaut à prenom dans les param de la fonction salutation, cela rend le param de la route optionnel
        //Si on ne met pas de paramètre par défaut, on peut mettre un point d'interrogation après prenom dans la route. 
        // $prenom = $prenom ?? "inconnu" -> si $prenom n'existe pas, afficher inconnu. (autre possibilité de valeur par défaut si on met un point d'interrogation dans la route)
        return $this->render("test/salutation.html.twig", ["prenom" => $prenom]);
        // EXO : créer la vue et afficher dans la balise <h1></h1>
        // Bonjour "prenom"
    }

    /**
     * @Route("/test/calculer/{n1}/{n2}", name="test_calcul", requirements={"nb1"="[0-9]+", "nb2"="[0-9]+"})
     */
    // Route ancienne version


    #[Route('/test/calculer/{n1}/{n2}', name: 'test_operations', requirements: ['n1' => '[0-9]+', 'n2' => '[0-9]+'])]
    public function calculer($n1, $n2)
    {
        return $this->render("test/calculer.html.twig", [
            "n1" => $n1,
            "n2" => $n2
        ]);
    }

    /**
     * EXO : Créer une nouvelle route qui va prendre 2 paramètres dans l'url *      et     qui va afficher la valeur de l'addition, la multiplication
     * la soustraction et la division des 2 nombres passés en paramètres.
     * 
     * Si le 2ième paramètres est 0, il ne faut pas afficher
     * le résultat de la division (affichez "Division par 0 impossible")

     */
}
