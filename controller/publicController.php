<?php
use model\manager\RecipeManager;
$recipeManager = new RecipeManager($connectPDO);
$menuRecipes = $recipeManager->getRecipesForMenu();

$page = $_GET['page'] ?? 'accueil';
if ($page === 'accueil') {

    require_once __DIR__ . '/../view/accueil.php';
}
if ($page === 'accueil') {
    require_once __DIR__ . '/../view/accueil.php';
} elseif ($page === 'apropos') {
    require_once __DIR__ . '/../view/apropos.php';
}
