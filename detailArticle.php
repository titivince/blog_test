<?php
// On démarre une session
session_start();
//récupere l'url
$current = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_BASENAME);

// Est-ce que le existe et n'est pas vide dans l'URL
if(isset($_GET['slug']) && !empty($_GET['slug'])){
    require_once('connect.php');

    // On nettoie le slug envoyé
    $slug = strip_tags($_GET['slug']);

    $sql = "SELECT * FROM  articles  WHERE  slug = :slug ";

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':slug', $slug, PDO::PARAM_STR);

    // On exécute la requête
    $query->execute();

    // On récupère l'article'
    $article = $query->fetch();

    $cat_id = $article['category_id'];
    $category = "SELECT category_name FROM category WHERE id = $cat_id";
    $req = $db->prepare($category);
    $req->execute();
    $cat = $req->fetch();

    // On vérifie si l'article existe
    if(!$article){
        $_SESSION['erreur'] = "Cet article n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: list_article.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Détails de l'article</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
    </head>
    <body style="background-color: #fadcac">
    <?php include ('nav.php'); ?>
        <main class="container">
            <div class="card mt-4 shadow" style="border-radius: 2em;">
                <div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $article['title'] ?></h4>
                        <div class="row no-gutters">
                            <div class="col-md-7 mr-5">
                                <p class="card-text"><?= $article['content'] ?></p>
                                <h5>#<?= $cat['category_name'] ?></h5>
                            </div>
                            <div class="col-md-4">
                                <img src="https://picsum.photos/450/550" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <div class="card-footer text-muted mt-2">
                            <small>Publié le <?=$article['created_at']?></small>
                            <a href="list_article.php" class="btn btn-primary ml-4">Retour</a>
                            <a href="updateArticle.php?id=<?= $article['id'] ?>" class="btn btn-warning ml-4">Modifier</a>
                            <a href="deleteArticle.php?id=<?= $article['id'] ?>" class="btn btn-danger ml-4" >Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html