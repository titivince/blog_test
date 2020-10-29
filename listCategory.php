<?php
// On démarre une session
session_start();

// On inclut la connexion à la base
require_once('connect.php');

// selection de toutes les colonnes de la table category et articles avec jointure de category.id
$sql = "SELECT * FROM category";
// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$categorys = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>categorie</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
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
                    <?php
                    if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                        '. $_SESSION['message'].'
                                    </div>';
                        $_SESSION['message'] = "";
                    }
                    ?>
                    <h1>categories </h1>
                    <table class="table">
                        <thead>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Slug</th>
                        </thead>
                        <tbody>
                        <?php
                        // On boucle sur la variable category
                        foreach($categorys as $category){
                            ?>
                            <tr>
                                <td><?= $category['id'] ?></td>
                                <td><?= $category['category_name'] ?></td>
                                <td><?= $category['slug'] ?></td>
                                <td><a href="updateCategory.php?id=<?= $category['id'] ?>">Modifier</a> <a href="deleteCategory.php?id=<?= $category['id'] ?>">Supprimer</a></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <a href="createCategory.php" class="btn btn-primary">Ajouter une catégorie</a>
                    <a href="index.php" class="btn btn-primary">Retour</a>
                </section>
            </div>
        </main>
    </body>
</html>
