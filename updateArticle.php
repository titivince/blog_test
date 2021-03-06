<?php
// On démarre une session
session_start();
require('function.php');
$categorys = selectCategory();

if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
        && isset($_POST['title']) && !empty($_POST['title'])
        && isset($_POST['content']) && !empty($_POST['content'])
        && isset($_POST['category']) && !empty($_POST['category'])){
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['id']);
        $title = strip_tags($_POST['title']);
        $content = strip_tags($_POST['content']);
        $category = strip_tags($_POST['category']);
        //fonction permettant de générer un slug
        $slug = slugify($title);

        $sql = "UPDATE articles SET title = :title, content = :content, updated_at = NOW(),category_id = :category, slug = :slug WHERE id = :id";

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':title', $title, PDO::PARAM_STR);
        $query->bindValue(':content', $content, PDO::PARAM_STR);
        $query->bindValue(':category', $category, PDO::PARAM_INT);
        $query->bindValue(':slug', $slug, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "Article modifié";
        require_once('close.php');

        header('Location: list_article.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}
// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = "SELECT * FROM articles WHERE id = :id";

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le title
    $title = $query->fetch();

    // On vérifie si le title existe
    if(!$title){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modifier un Article</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
    </head>
    <body style="background-color: #fadcac">
        <nav class="navbar navbar-expand-xl navbar-light bg-light"> <!-- nav bar -->
            <a class="navbar-brand" href="index.php">Acceuil</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="list_article.php">Tout les articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="createArticle.php">Créer un article</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="container">
            <div class="row">
                <section class="col-12">
                    <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                        '. $_SESSION['erreur'].'
                                    </div>';
                        $_SESSION['erreur'] = "";
                    } ?>
                    <h1 class="mt-3">Modifier un Article</h1>
                    <form method="POST">
                        <div class="form-group">
                            <h5 for="title">Titre</h5>
                            <input type="text" id="title" name="title" class="form-control" value="<?= $title['title']?>">
                        </div>
                        <div class="form-group">
                            <h5 for="content">Contenue</h5>
                            <textarea style="resize:none;" type="text" id="content" rows="10" name="content" class="form-control" value="<?= htmlentities($title['content']) ?>"><?= htmlentities($title['content']) ?></textarea>
                        </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="category">
                                <option type="text" value="<?= $title['category_id']?>">choisir une catégorie</option>
                                <?php foreach($categorys as $category ): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['category_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" value="<?= $title['id']?>" name="id">
                        <button class="btn btn-success">Modifier</button>
                    </form>
                </section>
            </div>
        </main>
    </body>
</html>
