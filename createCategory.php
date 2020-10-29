<?php
// On démarre une session
session_start();
require_once('connect.php');
require('function.php');


if($_POST){
    if(isset($_POST['category']) && !empty($_POST['category'])){

        // On nettoie les données envoyées
        $category = strip_tags($_POST['category']);
        //fonction permettant de générer un slug
        $slug = slugify($category);

        //on prepare l'insertion des champs dans la table articles (created_at et slug sont générer automatiquement)
        $sql = "INSERT INTO category (category_name, slug) VALUES (:category, :slug)";
        $query = $db->prepare($sql);

        //on inclue des paramètre à la requète
        $query->bindValue(':category', $category, PDO::PARAM_STR);
        $query->bindValue(':slug', $slug, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "Catégorie ajouté";
        require_once('close.php');

        header('Location: listCategory.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajouter une Catégorie</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <main class="container">
            <div class="row">
                <section class="col-12">
                    <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                        '. $_SESSION['erreur'].'
                                    </div>';
                        $_SESSION['erreur'] = "";
                    }
                    ?>
                    <h1>Ajouter une Catégorie</h1>
                    <form method="POST">
                        <div class="form-group">
                            <label for="category">Nom</label>
                            <input type="text"  name="category" class="form-control">
                        </div>
                        <button class="btn btn-primary">Envoyer</button>
                    </form>
                </section>
            </div>
        </main>
    </body>
</html>