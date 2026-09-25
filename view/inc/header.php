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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

<header class="site-header">
    <nav class="navbar navbar-expand-lg" aria-label="Navigation principale">
        <div class="container">
            <a class="navbar-brand" href="?page=accueil">Maison Rosalie</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Ouvrir le menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><?= navLink('accueil', 'Accueil', $currentPage) ?></li>

                    <!-- Menu déroulant Recettes, rempli depuis la base (FE-05) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?= $currentPage === 'recettes' ? ' active' : '' ?>" href="?page=recettes"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false"<?= $currentPage === 'recettes' ? ' aria-current="page"' : '' ?>>Recettes</a>
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

                    <li class="nav-item"><?= navLink('apropos', 'À propos', $currentPage) ?></li>
                    <li class="nav-item"><?= navLink('contact', 'Contact', $currentPage) ?></li>
                </ul>

                <!-- Compte : nom + déconnexion si connecté, sinon connexion / inscription -->
                <div class="d-flex align-items-center gap-2">
                    <?php if ($currentUser): ?>
                        <span class="navbar-text">Bonjour, <strong><?= h($currentUser['username']) ?></strong></span>
                        <form method="post" action="?page=deconnexion" class="m-0">
                            <button type="submit" class="btn btn-outline-rosalie btn-sm">Déconnexion</button>
                        </form>
                    <?php else: ?>
                        <button type="button" class="btn btn-outline-rosalie btn-sm" data-bs-toggle="modal" data-bs-target="#loginModal">Connexion</button>
                        <button type="button" class="btn btn-rosalie btn-sm" data-bs-toggle="modal" data-bs-target="#registerModal">Inscription</button>
                    <?php endif; ?>
                </div>
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
