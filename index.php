<?php
// On démarre une session
session_start();

// On inclut la connexion à la base
require_once('connect.php');
require('function.php');

$categorys = selectCategory();
//récupere l'url
$current = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_BASENAME);

// selection de toutes les colonnes de la table category et articles avec jointure de category.id
$sql = "SELECT * FROM category, articles  WHERE articles.category_id = category.id ORDER BY created_at DESC LIMIT 3";
// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$articles = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
              integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
              crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
                crossorigin="anonymous"></script>
        <title>Blog</title>
    </head>
    <body style="background-color: #fadcac">
        <?php include ('nav.php'); ?>
                            <!-- contenue -->
        <main class="container">
            <div class="row">
                <section class="col-12">
                    <h1 class="text-center p-2">Articles à la unes</h1>
                    <?php foreach($articles as $article){
                    ?>
                    <div class="card-deck shadow mb-5 p-3" style="border-radius: 2em;background-color: #fefefe">
                        <div class="card-body">
                            <h4 class="card-title"><?= $article['title'] ?></h4>
                            <p class="card-text"><?= excerpt($article['content']) ?></p>
                            <div class="card-footer">
                                <small class="text-muted">Publier le : <?= $article['created_at'] ?></small>
                                <a href="detailArticle.php?slug=<?= $article['slug'] ?>" class="btn btn-primary btn-sm ml-4">Voir l'article</a>
                            </div>
                        </div>
                    </div>
                        <?php
                    }
                    ?>
                </section>
            </div>
        </main>
    </body>
</html>