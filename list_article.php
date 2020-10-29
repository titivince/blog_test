<?php
// On démarre une session
session_start();

// On inclut la connexion à la base
require_once('connect.php');
require('function.php');

$categorys = selectCategory();

// selection de toutes les colonnes de la table category et articles avec jointure de category.id 
$sql = "SELECT * FROM category, articles  WHERE articles.category_id = category.id ORDER BY created_at DESC";
// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$articles = $query->fetchAll(PDO::FETCH_ASSOC);

$cats = selectCategory();

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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
                crossorigin="anonymous"></script>
    </head>
    <body style="background-color: #fadcac">
    <?php include ('nav.php'); ?>
                    <!-- contenue -->
        <main class="container">
            <div class="row">
                <section class="col-12">
                    <?php
                        if(!empty($_SESSION['erreur'])):
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    '. $_SESSION['erreur'].'
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    $_SESSION['erreur'] = "";
                    endif;
                    ?>
                    <?php
                        if(!empty($_SESSION['message'])):
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    '. $_SESSION['message'].'
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    $_SESSION['message'] = "";
                    endif;
                    ?>
                    <h1 class="text-center m-3">Liste des articles </h1>
                    <form action="articlesByCat.php" method="GET">
                        <div class="form-group mt-3">
                        <select class="form-control " name="category_id">
                                <option type="text" value="<?= $articles['category_id']?>">Voir les articles par Catégorie</option>
                                <?php foreach($cats as $cat ): ?>
                                    <option value ="<?= $cat['id'] ?>"><?= $cat['category_name']?></option>
                                <?php
                                endforeach; ?>
                            </select>
                        </div>
                        <button class="btn btn-primary mb-5">Envoyer</button>
                    </form>
                    <div class="row">
                    </div>
                    <?php // On boucle sur la variable articles
                        foreach($articles as $article):
                    ?>
                    <div class="card-deck p-3 shadow mb-5" style="border-radius: 2em;background-color: #fefefe"> <!-- liste des articles -->
                        <div class="card-body">
                            <h4 class="card-title"><?= $article['title'] ?></h4>
                            <p class="card-text"><?= excerpt($article['content']) ?></p>
                            <p>#<?= $article['category_name'] ?></p>
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
        </main>
    </body>
</html>