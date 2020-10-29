<?php
// On démarre une session
session_start();

if(isset($_GET['category_id']) && !empty($_GET['category_id'])){

// On inclut la connexion à la base
    require_once('connect.php');
    require('function.php');

    $sql = "SELECT * FROM  articles WHERE category_id = $_GET[category_id] ORDER BY created_at DESC ";
    $query = $db->prepare($sql);

// On exécute la requête
    $query->execute();

// On stocke le résultat dans un tableau associatif
    $articles = $query->fetchAll(PDO::FETCH_ASSOC);

    $category = "SELECT category_name FROM category WHERE id = $_GET[category_id]";
    $req = $db->prepare($category);
    $req->execute();
    $cat = $req->fetch();
}
require_once('close.php');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>articles</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
    </head>
    <body style="background-color: #fadcac;">
        <?php include ('nav.php'); ?>
        <main class="container">
            <div class="row">
                <section class="col-12">
                    <?php
                    if(!empty($_SESSION['erreur'])):
                        echo '<div class="alert alert-danger" role="alert">
                        '. $_SESSION['erreur'].'
                </div>';
                        $_SESSION['erreur'] = "";
                    endif;
                    ?>
                    <?php
                    if(!empty($_SESSION['message'])):
                        echo '<div class="alert alert-success" role="alert">
                '. $_SESSION['message'].'
                </div>';
                        $_SESSION['message'] = "";
                    endif; ?>
                    <h1 class="text-center m-3">Liste des articles <?= $cat['category_name'] ?></h1>
                    <?php
                        // On boucle sur la variable articles
                        foreach($articles as $article):
                    ?>
                        <div class="card-deck p-3 shadow mb-4" style="border-radius: 2em;background-color: #fefefe">
                            <div class="card-body">
                                <h4 class="card-title"><?= $article['title'] ?></h4>
                                <p class="card-text"><?= $article['content'] ?></p>
                                <div class="card-footer">
                                    <small class="text-muted">Date de création : <?= $article['created_at'] ?></small>
                                    <small class="text-muted">Date de dernière modification : <?= $article['updated_at'] ?></small>
                                    <a class="btn btn-primary ml-3 btn-sm" href="detailArticle.php?slug=<?= $article['slug'] ?>">Voir</a>
                                    <a class="btn btn-warning ml-3 btn-sm" href="updateArticle.php?id=<?= $article['id'] ?>">Modifier</a>
                                    <a class="btn btn-danger ml-3 btn-sm" href="deleteArticle.php?id=<?= $article['id'] ?>">Supprimer</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </section>
            </div>
            <a class="btn btn-primary" href="list_article.php">Retour</a>
        </main>
    </body>
</html>