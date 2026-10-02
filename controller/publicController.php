<?php
use model\manager\RecipeManager;
$recipeManager = new RecipeManager($connectPDO);
$menuRecipes = $recipeManager->getRecipesForMenu();

$page = $_GET['page'] ?? 'accueil';
if ($page === 'accueil') {

    require_once RACINE_PATH . '/view/accueil.php';

} elseif ($page === 'apropos') {
    require_once RACINE_PATH. '/view/apropos.php';
} elseif ($page === 'contact') {
    require_once RACINE_PATH . '/view/contact.php';
}