  # Projet découverte Symfony
  *Un petit projet qui suit le cours de Symfony dispensé par l'école Wf3*

  ## Jour 1 :

  ## Commandes d'installations : 
  
   - server:ca:install<br>
    *Permet de rajouter une simulation de licence*

    - require maker --dev

    - require annotations
    *Rajoute des annotations sur les classes*

    - symfony console make:controller
    *Créé un controller*

    - composer require twig 
    *Créé un dossier templates avec un fichier base.html.twig qui sera l'affichage de notre page*

    ## Découverte de twig

    - Commentaires : {# #}
    - Block : Parties de page pouvant être modifiées par un autre template
    - Extends d'un template
    - Boucle for
    - Structures conditionnelles (IF, TESTS)
    - Les filtres (|upper : ex d'utilisation de filtre)
    - https://twig.symfony.com/ 

    ## Apprendre à gérer les routes avec annotations

## Jour 2 :

- Paramètre optionnel dans une route
- Valeur par défaut d'une fonction de route
- Nature d'un paramètre d'une route (requirements=regex)
- Syntax nouvelle annotation de route

### Connexion à la base de donnée

- <code>composer require orm</code> (gestion de la bdd)
- Création de la bdd (vide) avec <code>symfony console doctrine:database:create</code>
- Modif dans .env pour connexion bdd

### Gestion / intéractions BDD
- création nvlle route + vue -> <code>symfony console make:controller</code>
- Récupération info formulaire
- Utilisation de EntityManager <code>symfony console make:entity</code>
  -> <code>symfony console make:migration</code>
    -><code>symfony console doctrine:migrations:migrate</code>
- Classe Entity 
- Méthode persist et flush
- Utilisation de la classe Repository, méthode find et findAll

### Formulaires :

- Installation de <code>composer require form validator</code> (générer des formulaires)
- make:form (création fichier, gérer un formulaire / générer )
- creatForm et createView 
- Composant form -> personnalisation
- Classe Request 
- Ajout de contraintes

## Jour 3 :

### Modifier un objet de la BDD
- param dans url
- methode find() 
- Ajustement du tableau / récupération id

### Supprimer un objet de la BDD
- Nouvelle route
- Vue "supprimer.html.twig" (page de confirmation)
- Remove()

### Home

- <code>symfony console make:controller Home</code>
- Home en racine du projet
- Boucler sur un include

### Gérer des utilisateurs

- <code>composer require security</code> (composant de sécurité)
- classe user  : <code>symfony console make:user</code>
- <code>symfony console make:entity</code>
- <code>php bin/console make:migration</code>
- <code>symfony console d:m:m</code> (modification de la bdd)
- Mapped / gestion mdp / contraints
- Contrôle d'accès -> is_granted()
- Route controleur "/admin" 

## Jour 4 : 

### CRUD

- <code>symfony console make:crud</code>
- Formulaire (regex, option help, ...)
- Gérer le mot de passe

### Relation entre table de bdd

- Relation -> ManyToOne