<?php
function slugify($string, $delimiter = '-') {
    $oldLocale = setlocale(LC_ALL, '0');
    setlocale(LC_ALL, 'en_US.UTF-8');
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower($clean);
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    $clean = trim($clean, $delimiter);
    setlocale(LC_ALL, $oldLocale);
    return $clean;
}

function selectCategory() {
    try{
        // Connexion à la base
        $db = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
        $db->exec('SET NAMES "UTF8"');
    } catch (PDOException $e){
        echo 'Erreur : '. $e->getMessage();
        die();
    }

    // selection de toutes les colonnes de la table category
    $sql = "SELECT * FROM category";
// On prépare la requête
    $query = $db->prepare($sql);

// On exécute la requête
    $query->execute();

// On stocke le résultat dans un tableau associatif
    $categorys = $query->fetchAll(PDO::FETCH_ASSOC);
// On se déconnecte de la base
    $db = null;

    return $categorys;
}

function recupCat() {
    try{
        // Connexion à la base
        $db = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
        $db->exec('SET NAMES "UTF8"');
    } catch (PDOException $e){
        echo 'Erreur : '. $e->getMessage();
        die();
    }

    // selection de toutes les colonnes de la table category
    $sql = "SELECT * FROM  category,articles WHERE  articles[category_id]= category.id";
// On prépare la requête
    $query = $db->prepare($sql);

// On exécute la requête
    $query->execute();

// On stocke le résultat
    $category = $query->fetch();
// On se déconnecte de la base
    $db = null;

    return $category;
}