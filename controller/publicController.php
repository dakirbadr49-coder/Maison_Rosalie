<?php
// chemin vers les dépendances
use model\manager\RecipeManager;
$recipeManager = new RecipeManager($connectPDO);
$menuRecipes = $recipeManager->getRecipesForMenu();

$page = $_GET['page'] ?? 'accueil';
if ($page === 'accueil') {

    require_once RACINE_PATH . '/view/accueil.php';

} elseif ($page === 'apropos') {
    require_once RACINE_PATH. '/view/apropos.php';
<<<<<<< HEAD
} elseif ($page === 'contact') {
    require_once RACINE_PATH . '/view/contact.php';
}
=======
}
elseif ($page === 'contact') {
    require_once RACINE_PATH. '/view/contact.php';
}
elseif ($page === 'recettes') {
    require_once RACINE_PATH. '/view/recettes.php';
}
elseif ($page === 'detailsRecet') {
    require_once RACINE_PATH. '/view/recetteDetails.php';
}
>>>>>>> 6c33e1cbb1821dbcf585cd0e63081bd2a226373a
