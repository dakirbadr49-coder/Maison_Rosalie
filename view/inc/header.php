<?php
/*
 * En-tête commun à toutes les pages (FE-04, FE-05, FE-06, FE-50).
 *
 * Variables attendues (toutes facultatives) :
 *   $pageTitle   string       titre de l'onglet
 *   $currentPage string       page courante : accueil, recettes, apropos, contact
 *   $menuRecipes array        recettes du menu déroulant, chacune avec 'title' et 'slug'
 *   $currentUser array|null   utilisateur connecté (avec 'username'), null si visiteur
 */
$pageTitle   = $pageTitle ?? 'Maison Rosalie';
$currentPage = $currentPage ?? '';
$menuRecipes = $menuRecipes ?? [];
$currentUser = $currentUser ?? null;

// Échappe un texte avant de l'afficher (protection XSS)
if (!function_exists('h')) {
    function h(?string $text): string
    {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}

// Lien de navigation avec repérage de la page courante (FE-06)
function navLink(string $page, string $label, string $currentPage): string
{
    $active = $page === $currentPage;
    return '<a class="nav-link' . ($active ? ' active' : '') . '" href="?page=' . h($page) . '"'
        . ($active ? ' aria-current="page"' : '') . '>' . h($label) . '</a>';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Abhaya+Libre&family=Josefin+Sans&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <!-- Icônes de la maquette (solar, guidance) -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@2.1.0/dist/iconify-icon.min.js" defer></script>
</head>
<body>

<header class="site-header">
    <!-- Bandeau d'information en haut -->
    <p class="header-banner">Livraison standard gratuite avec commande à 125 $ vers toutes les destinations avec des températures inférieures à 75ºF.</p>

    <nav class="navbar navbar-expand-lg header-main" aria-label="Navigation principale">
        <!-- Logo + slogan (le logo ramène à l'accueil) -->
        <a class="header-brand" href="?page=accueil">
            <img src="assets/img/logo.png" alt="Maison Rosalie" class="header-logo">
            <span class="header-tagline">L'art de l'artisanat Belge depuis 1928</span>
        </a>

        <div class="header-right">
            <!-- Recherche + icônes compte et recettes -->
            <div class="header-tools">
                <form class="header-search" role="search" method="get">
                    <input type="hidden" name="page" value="recettes">
                    <input type="search" name="q" placeholder="recherche" aria-label="Rechercher une recette">
                    <button type="submit" aria-label="Lancer la recherche">
                        <iconify-icon icon="solar:magnifer-linear"></iconify-icon>
                    </button>
                </form>

                <div class="header-icons">
                    <!-- Compte : menu avec déconnexion si connecté, sinon modale de connexion -->
                    <?php if ($currentUser): ?>
                        <div class="dropdown">
                            <button type="button" class="header-icon" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Mon compte">
                                <iconify-icon icon="solar:user-bold"></iconify-icon>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <span class="dropdown-item-text">Bonjour, <strong><?= h($currentUser['username']) ?></strong></span>
                                <hr class="dropdown-divider">
                                <form method="post" action="?page=deconnexion" class="m-0">
                                    <button type="submit" class="dropdown-item">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <button type="button" class="header-icon" data-bs-toggle="modal" data-bs-target="#loginModal" aria-label="Connexion">
                            <iconify-icon icon="solar:user-bold"></iconify-icon>
                        </button>
                    <?php endif; ?>

                    <a class="header-icon" href="?page=recettes" aria-label="Nos recettes">
                        <iconify-icon icon="solar:chef-hat-minimalistic-line-duotone"></iconify-icon>
                    </a>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                        aria-controls="mainNav" aria-expanded="false" aria-label="Ouvrir le menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Menu principal (replié sur mobile) -->
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav header-menu">
                    <li class="nav-item"><?= navLink('apropos', 'À propos', $currentPage) ?></li>

                    <!-- Menu déroulant Recette, rempli depuis la base (FE-05) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?= $currentPage === 'recettes' ? ' active' : '' ?>" href="?page=recettes"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false"<?= $currentPage === 'recettes' ? ' aria-current="page"' : '' ?>>Recette</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=recettes">Toutes les recettes</a></li>
                            <?php if ($menuRecipes): ?>
                                <li><hr class="dropdown-divider"></li>
                                <?php foreach ($menuRecipes as $recipe): ?>
                                    <li><a class="dropdown-item" href="?page=recette&amp;slug=<?= h($recipe['slug']) ?>"><?= h($recipe['title']) ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="nav-item"><?= navLink('contact', 'Contact', $currentPage) ?></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<?php if (!$currentUser): ?>
<!-- Modales connexion / inscription (FE-50) -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="?page=connexion">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="loginModalTitle">Connexion</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">Adresse e-mail</label>
                    <input type="email" class="form-control" id="loginEmail" name="email" required autocomplete="email">
                </div>
                <div class="mb-3">
                    <label for="loginPassword" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="loginPassword" name="password" required autocomplete="current-password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#registerModal">Pas encore de compte ?</button>
                <button type="submit" class="btn btn-rosalie">Se connecter</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="?page=inscription">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="registerModalTitle">Inscription</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="registerUsername" class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="registerUsername" name="username" required maxlength="50" autocomplete="username">
                </div>
                <div class="mb-3">
                    <label for="registerEmail" class="form-label">Adresse e-mail</label>
                    <input type="email" class="form-control" id="registerEmail" name="email" required maxlength="254" autocomplete="email">
                </div>
                <div class="mb-3">
                    <label for="registerPassword" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="registerPassword" name="password" required minlength="8" autocomplete="new-password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#loginModal">Déjà inscrit ?</button>
                <button type="submit" class="btn btn-rosalie">Créer mon compte</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
