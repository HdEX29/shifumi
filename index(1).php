<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Shifumi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<style>
    body {
        min-height: 100vh;
        background:
            radial-gradient(circle at 25% 40%, rgba(200, 255, 241, 0.9), transparent 60%),
            radial-gradient(circle at 75% 60%, rgba(212, 230, 255, 0.9), transparent 60%),
            #f0e6ff;
    }

    .menu-dropdown {
        margin-right: 60px;


    }

    #staticBackdrop .modal-dialog {
        max-width: 1200px;
        height: 85vh;
    }

    .ranking-card {
        border-radius: 16px;
        background: linear-gradient(180deg, #1db3c4 0%, #c8d8f6 100%);
        padding: 18px;
    }

    .ranking-inner {
        background: #f3f4f6;
        border-radius: 14px;
        padding: 18px;
    }

    .ribbon {
        display: none;
    }

    .ranking-title {
        text-align: center;
        font-weight: 800;
        color: #2c3e50;
        margin: 10px 0 12px;
    }

    .ranking-head {
        display: grid;
        grid-template-columns: 80px 1fr 110px 120px;
        font-weight: 800;
        color: #3b4b5a;
        padding: 10px 8px;
    }

    .ranking-row {
        display: grid;
        grid-template-columns: 80px 1fr 110px 120px;
        align-items: center;
        padding: 14px 8px;
        border-top: 2px solid rgba(0, 0, 0, 0.12);
        font-weight: 700;
        color: #2c3e50;
    }

    .ranking-row .rank {
        font-size: 18px;
    }

    .ranking-row .parties,
    .ranking-row .victoires {
        text-align: right;
        font-size: 18px;
    }

    .ranking-row.me {
        outline: 3px solid rgba(245, 198, 136, 0.93);
        border-radius: 12px;
        background: rgba(255, 245, 220, 0.6);
    }
</style>

<body>
    <?php
    function signetonb($signe)
    {
        if ($signe == 'Pierre') {
            return 1;
        } else if ($signe == 'Feuille') {
            return 2;
        } else if ($signe == 'Ciseaux') {
            return 3;
        }
    }

    function nbtosigne($nb)
    {
        if ($nb == 1) {
            return 'Pierre';
        } else if ($nb == 2) {
            return 'Feuille';
        } else if ($nb == 3) {
            return 'Ciseaux';
        }
    }

    function shifumi($ia, $choix)
    {
        if ($ia == $choix) {
            return "Egalite !";
        } else if (($ia == $choix + 1) || ($ia == 1 && $choix == 3)) {
            return "Defaite...";
        } else if (($ia + 1 == $choix) || ($ia == 3 && $choix == 1)) {
            return "Victoire !";
        }
    }

    function addicon($signe)
    {
        if (isset($signe)) { {
                try {
                    if ($signe == 'Pierre') {
                        return '<span class="hand-icon mb-1"><i class="fa-regular fa-hand-back-fist"></i></span>';
                    } elseif ($signe == 'Feuille') {
                        return '<span class="hand-icon mb-1"><i class="fa-regular fa-hand"></i></span>';
                    } else {
                        return '<span class="hand-icon mb-1"><i class="fa-regular fa-hand-scissors"></i></span>';
                    }
                } catch (Throwable $t) {
                    return '<div id="player-hand-icon" class="hand-icon mb-1">?</div>';
                }
            }
        } else {
            return '<div id="player-hand-icon" class="hand-icon mb-1">?</div>';
        }
    }

    function choice($signe)
    {
        if (isset($signe)) {
            try {
                return $signe;
            } catch (Throwable $t) {
                return "En attente...";
            }
        } else {
            return "En attente...";
        }
    }

    date_default_timezone_set('Europe/Paris');
    session_start();
    require_once "db.php";

   if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = "invite";
}

$username = $_SESSION['username'];

$ip = $_SERVER['REMOTE_ADDR'];

if ($ip === '::1') {
    $ip = '127.0.0.1';
}

if (strpos($ip, '::ffff:') === 0) {
    $ip = substr($ip, 7);
}

$stmt = $pdo->prepare("
    INSERT INTO scores (nom_utilisateur, mot_de_passe)
    SELECT :username, ''
    WHERE NOT EXISTS (
        SELECT 1 FROM scores WHERE nom_utilisateur = :username
    )
");
$stmt->execute([':username' => $username]);

$stmt = $pdo->prepare("
    UPDATE scores
    SET ip_address = :ip
    WHERE nom_utilisateur = :username
");
$stmt->execute([
    ':ip' => $ip,
    ':username' => $username
]);

    if (!isset($_SESSION['debut_session'])) {
        $_SESSION['debut_session'] = time();
    }
    if (!isset($_SESSION['nbpartie'])) {
        $_SESSION['nbpartie'] = 1;
    }
    if (!isset($_SESSION['nbvictoire'])) {
        $_SESSION['nbvictoire'] = 0;
    }
    if (!isset($_SESSION['nbdefaite'])) {
        $_SESSION['nbdefaite'] = 0;
    }
    if (!isset($_SESSION['numeroaleatoire'])) {
        $_SESSION['numeroaleatoire'] = random_int(1, 3);
    }
    if (!isset($_SESSION['username'])) {
        $_SESSION['username'] = "invite";
    }
    $resultat = '';
    if (!empty($_POST['value'])) {
        if ($_POST['value'] == 'Reset') {
            session_destroy();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
        $choix = $_POST['value'];
        $nbchoix = signetonb($_POST['value']);
        $ia = $_SESSION['numeroaleatoire'];
        $resultat = shifumi($ia, $nbchoix);
        $_SESSION['nbpartie'] += 1;
        if ($resultat === "Victoire !") {
            $_SESSION['nbvictoire'] += 1;
        } elseif ($resultat !== "Egalite !") {
            $_SESSION['nbdefaite'] += 1;
        }
        $_SESSION['numeroaleatoire'] = null;
    }
    $joueur = $_SESSION['username'];

    $gagnants = 0;
    $perdants = 0;

    if ($resultat === "Victoire !") {
        $gagnants = 1;
    } elseif ($resultat === "Defaite...") {
        $perdants = 1;
    }
    $_SESSION['numeroaleatoire'] = random_int(1, 3);
    $stmt = $pdo->prepare("
  INSERT INTO classement (joueurs, games, gagnants, perdants)
  VALUES (:j, 1, :g, :p)
  ON DUPLICATE KEY UPDATE
    games = games + 1,
    gagnants = gagnants + :g,
    perdants = perdants + :p
");
    $stmt->execute([
        ":j" => $joueur,
        ":g" => $gagnants,
        ":p" => $perdants
    ]);

    $ranking = $pdo->query("
  SELECT joueurs, games, gagnants
  FROM classement
  ORDER BY gagnants DESC, games DESC
  LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light bg-opacity-75 sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">SHIFUMI – Joueur 👤 vs Machine 💻 </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarStats">
                <ul class="navbar-nav align-items-lg-center gap-lg-3">
                    <ul class="navbar-nav align-items-lg-center gap-lg-3">
                        <li class="nav-item">
                            <span class="badge bg-info text-dark">
                                Heure de début <span id="round-number"><?= date("H:i", $_SESSION['debut_session']) ?></span>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="badge bg-info text-dark">
                                Partie n° <span id="round-number"><?= $_SESSION['nbpartie'] ?></span>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="badge bg-success">
                                Victoires joueur : <span id="player-wins"><?= $_SESSION['nbvictoire'] ?></span>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="badge bg-danger">
                                Victoires machine : <span id="computer-wins"><?= $_SESSION['nbdefaite'] ?></span>
                            </span>
                        </li>
                    </ul>
            </div>
        </div>
        <div class="dropdown menu-dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Menu
            </button>

            <ul class="dropdown-menu">
                <li>
                    <button type="button" class="dropdown-item btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModalConnection" data-bs-whatever="@mdo">
                        Se connecter
                    </button>
                </li>

                <li>
                    <button type="button" class="dropdown-item btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">
                        Classement
                    </button>
                </li>
            </ul>
        </div>


    </nav>


    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card game-card shadow-lg text-light">
                    <div class="card-body p-4 p-md-5 game-container">

                        <section class="hero">
                            <div class="container">
                                <h1 class="fw-bold">Jeu Shifumi</h1>
                                <p class="mt-3">Choisis une main pour affronter la machine 😉 </p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Rappel
                                </button>
                                <div class="row g-4">
                                    <div class="game-center">
                                        <h5 class="text-uppercase small fw-semibold mb-3 mt-4">Ton choix</h5>

                                        <form action="#" method="post" class="choice-buttons">
                                            <button class="btn btn-outline-dark d-flex flex-column align-items-center px-3 py-2"
                                                type="submit" name="value" value="Pierre">
                                                <span class="hand-icon mb-1">
                                                    <i class="fa-regular fa-hand-back-fist"></i>
                                                </span>
                                                <span class="small text-uppercase fw-semibold">Pierre</span>
                                            </button>


                                            <button class="btn btn-outline-dark d-flex flex-column align-items-center px-3 py-2"
                                                type="submit" name="value" value="Feuille">
                                                <span class="hand-icon mb-1">
                                                    <i class="fa-regular fa-hand"></i>
                                                </span>
                                                <span class="small text-uppercase fw-semibold">Feuille</span>
                                            </button>


                                            <button class="btn btn-outline-dark d-flex flex-column align-items-center px-3 py-2"
                                                type="submit" name="value" value="Ciseaux">
                                                <span class="hand-icon mb-1">
                                                    <i class="fa-regular fa-hand-scissors"></i>
                                                </span>
                                                <span class="small text-uppercase fw-semibold">Ciseaux</span>
                                            </button>
                                        </form>

                                        <div class="text-center mt-3">
                                            <form action="#" method="post">
                                                <button class="btn btn-dark btn-sm text-uppercase fw-semibold"
                                                    type="submit" name="value" value="Reset">
                                                    Reset
                                                </button>
                                            </form>
                                        </div>


                                        <h5 class="text-uppercase small fw-semibold mb-3 mt-4"><?php echo $resultat ?></h5>

                                        <div class="result-block">
                                            <div class="d-flex gap-4 justify-content-center">
                                                <div>
                                                    <div class="small text-uppercase text-muted mb-1">Toi</div>
                                                    <?= addicon($choix ?? null) ?>
                                                    <div id="player-hand-text" class="small"><?= choice($choix ?? null) ?></div>
                                                </div>

                                                <div>
                                                    <div class="small text-uppercase text-muted mb-1">Machine</div>
                                                    <?= addicon(nbtosigne($ia ?? null) ?? null) ?>
                                                    <div id="computer-hand-text" class="small"><?= choice(nbtosigne($ia ?? null) ?? null) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="index_ia.php" class="btn btn-start mt-3 a"><strong>Affronter AM au Shifumi ! </strong></a>

                                        <div id="message" class="alert alert-info mt-2 mb-0 message-block">
                                            Clique sur une main pour commencer la partie.
                                        </div>

                                    </div>

                                    <hr class="my-4">


                                    <div class="d-flex flex-md-row justify-content-center align-items-md-center gap-3">
                                        <span class="small text-black-50">
                                            Conseil : enchaîne les parties pour voir qui domine sur le long terme !
                                        </span>
                                    </div>

                                </div>
                            </div>
                    </div>
                </div>
    </main>
</body>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Rappelez-vous❗</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>🔹La Pierre🪨 bat Les Ciseaux✂</li>
                    <li>🔹Les Ciseaux✂ battent La Feuille📋</li>
                    <li>🔹La Feuille📋 bat La Pierre🪨</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalConnection" tabindex="-1"
    aria-labelledby="exampleModalConnectionLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalConnectionLabel">Connexion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <form method="POST" action="login.php">

                    <div class="mb-3">
                        <label class="col-form-label">Nom et prénom</label>
                        <input type="text" name="nom_utilisateur" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label">Mot de passe</label>
                        <input type="password" name="mot_de_passe" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        Se connecter
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Classement</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="ranking-card">

                    <div class="ranking-inner">
                        <div class="ranking-title">CLASSEMENT FINAL</div>

                        <div class="ranking-head">
                            <div>RANG</div>
                            <div>NOM</div>
                            <div>PARTIES</div>
                            <div>VICTOIRES</div>
                        </div>

                        <?php if (empty($ranking)): ?>
                            <div class="text-center text-muted py-4">Aucun score</div>
                        <?php else: ?>
                            <?php foreach ($ranking as $i => $row):
                                $isMe = isset($_SESSION['username']) && strtolower($_SESSION['username']) === strtolower($row['joueurs']);
                            ?>
                                <div class="ranking-row <?= $isMe ? 'me' : '' ?>">
                                    <div class="rank"><?= $i + 1 ?></div>
                                    <div><?= htmlspecialchars($row['joueurs']) ?></div>
                                    <div><?= (int)$row['games'] ?></div>
                                    <div class="score"><?= (int)$row['gagnants'] ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
            </div>

        </div>
    </div>
</div>

</div>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>