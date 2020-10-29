
<?php $current = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_BASENAME); ?>
<nav class="navbar navbar-expand-xl navbar-light bg-light"> <!-- nav bar -->
    <a class="navbar-brand" href="index.php">Acceuil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li  <?php if ($current == 'list_article.php') echo 'class="d-none"'; ?> class="nav-item">
                <a class="nav-link" href="list_article.php">Tout les articles</a>
            </li>
            <li <?php if ($current == 'createArticle.php') echo 'class="d-none"'; ?> class="nav-item">
                <a class="nav-link" href="createArticle.php">Créer un article</a>
            </li>
        </ul>
    </div>
</nav>