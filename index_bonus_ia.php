<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Shifumi vs AM TBBT</title>
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
</style>

<body>
    <?php
    function shifumi($ia, $choix)
    {
        if ($ia == $choix) {
            return "Egalite !";
        }
        else if (in_array($ia, beats($choix)))  {
            return "Defaite...";
        }
        else if (in_array($choix, beats($ia))) {
            return "Victoire !";
        }
    }

    function beats($choix) {
        return [
            'Pierre'  => ['Feuille','Spock'],
            'Feuille' => ['Ciseaux','Lezard'],
            'Ciseaux' => ['Pierre','Spock'],
            'Lezard' => ['Ciseaux','Pierre'],
            'Spock' => ['Feuille','Lezard']
        ][$choix];
    }

    function addicon($signe) 
    {
        if (isset($signe)) {
            {try {
                if ($signe == 'Pierre') {return '<span class="hand-icon mb-1"><i class="fa-regular fa-hand-back-fist"></i></span>';}
                elseif ($signe == 'Feuille') {return '<span class="hand-icon mb-1"><i class="fa-regular fa-hand"></i></span>';}
                elseif ($signe == 'Ciseaux') {return '<span class="hand-icon mb-1"><i class="fa-regular fa-hand-scissors"></i></span>';}
                elseif ($signe == 'Lezard') { return '<span class="hand-icon mb-1"><i class="fa-regular fa-hand-lizard"></i></span>';}
                else { return '<span class="hand-icon mb-1"><i class="fa-regular fa-hand-spock"></i></span>';}
            } catch (Throwable $t) {return '<div id="player-hand-icon" class="hand-icon mb-1">?</div>';}}
            
        } else {return '<div id="player-hand-icon" class="hand-icon mb-1">?</div>';}
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

    function am_choice($player_choice = null)
    {
        $tour  = $_SESSION['am_tour'];
        $histo = &$_SESSION['am_history'];
        $histo_player = &$_SESSION['player_history'];

        // Sauvegarde du choix joueur si donné
        if ($player_choice !== null) {
            $histo_player[] = $player_choice;
        }

        $options = ['Pierre', 'Feuille', 'Ciseaux', 'Lezard', 'Spock'];
        $choice = null;

        // ---- LOGIQUE DE HAL ----

        switch ($tour) {

            case 1: // Tour 1 : HAL choisit aléatoirement
                $choice = $options[array_rand($options)];
                break;

            case 2: // Tour 2 : HAL bat le choix joueur du tour 1
                $choice = beats($histo_player[count($histo_player) - 2])[random_int(0,1)];  
                break;

            case 3: // Tour 3 : HAL répète son tour 1
                $choice = $histo[count($histo)-2];  
                break;

            case 4: // Tour 4 : HAL choisit ce qu'il n'a pas encore dit ou pas depuis longtemps
                // On trie les options selon leur ancienneté dans l'historique
                $unused = array_diff($options, $histo);

                if (!empty($unused)) {
                    // Si HAL n'a jamais dit une option → il la dit maintenant
                    $choice = array_values($unused)[0];
                } else {
                    // Sinon : il choisit l'option la moins utilisée
                    $counts = array_count_values($histo);
                    asort($counts); // plus faible utilisation en premier
                    $choice = array_key_first($counts);
                }
                break;

            case 5: // Tour 5 : HAL répète ce que le joueur a choisi au tour 4
                $choice = $histo_player[count($histo_player) - 2];
                break;
    }

    // HAL dit l'option trouvée
    $histo[] = $choice;

    // Prochain tour
    $_SESSION['am_tour']++;
    if ($_SESSION['am_tour'] > 5) {
        $_SESSION['am_tour'] = 1;
    }

    return $choice;
    }

    date_default_timezone_set('Europe/Paris');
    session_start();
    if (!isset($_SESSION['am_tour'])) {$_SESSION['am_tour'] = 1; $_SESSION['am_history'] = []; $_SESSION['player_history'] = [];}
    if (!isset($_SESSION['debut_session'])) {$_SESSION['debut_session'] = time();}
    if (!isset($_SESSION['nbpartie'])) { $_SESSION['nbpartie'] = 1; }
    if (!isset($_SESSION['nbvictoire'])) { $_SESSION['nbvictoire'] = 0; }
    if (!isset($_SESSION['nbdefaite'])) { $_SESSION['nbdefaite'] = 0; }
    if (!isset($_SESSION['numeroaleatoire'])) {$_SESSION['numeroaleatoire'] = 1;}
    $resultat = '';
    if (!empty($_POST['value'])) {
        if ($_POST['value'] == 'Reset') {
            session_destroy();
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        }
        $choix = $_POST['value'];
        $choixMachine = am_choice($choix);
        $resultat = shifumi($choixMachine, $choix);
        $_SESSION['nbpartie'] += 1;
        if ($resultat === "Victoire !") {
            $_SESSION['nbvictoire'] += 1;
        } elseif ($resultat !== "Egalite !") {
            $_SESSION['nbdefaite'] += 1;
        }
        $_SESSION['numeroaleatoire'] = null;
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light bg-opacity-75 sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">SHIFUMI –    Joueur 👤  vs AM 💻 – Version The Big Bang Theory</a>
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
                                Heure de début <span id="round-number"><?= date("H:i", $_SESSION['debut_session'])?></span>
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
    </nav>

    
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card game-card shadow-lg text-light">
                    <div class="card-body p-4 p-md-5 game-container">
                        
                        <section class="hero">
                            <div class="container">
                                <h1 class="fw-bold">Jeu Shifumi</h1>
                                <a href="index_aleatoire.php" class="btn btn-start mt-3 a"><strong>Tester la version originale du Shifumi !</strong></a><br>
                                <p class="mt-3">Choisis une main pour affronter la machine 😉 </p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Rappel des règles
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

                <button class="btn btn-outline-dark d-flex flex-column align-items-center px-3 py-2"  
                        type="submit" name="value" value="Lezard">  
                    <span class="hand-icon mb-1">  
                        <i class="fa-regular fa-hand-lizard"></i>  
                    </span>  
                    <span class="small text-uppercase fw-semibold">Lézard</span>  
                </button>

                <button class="btn btn-outline-dark d-flex flex-column align-items-center px-3 py-2"  
                        type="submit" name="value" value="Spock">  
                    <span class="hand-icon mb-1">  
                        <i class="fa-regular fa-hand-spock"></i>  
                    </span>  
                    <span class="small text-uppercase fw-semibold">Spock</span>  
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
                    <?= addicon($choix ?? null)?>
                    <div id="player-hand-text" class="small"><?= choice($choix ?? null) ?></div>  
                </div>  

                <div>  
                    <div class="small text-uppercase text-muted mb-1">AM</div>  
                    <?= addicon($choixMachine ?? null)?>  
                    <div id="computer-hand-text" class="small"><?= choice($choixMachine ?? null)?></div>  
                </div>  
            </div>  
        </div>
        <a href="index_bonus.php" class="btn btn-start mt-3 a"><strong>Tester la version avec l'IA aléatoire !</strong></a><br>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Rappelez-vous❗</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul>
            <li>🔹La Pierre🪨 bat Les Ciseaux✂ et Le Lézard🦎​</li>
            <li>🔹Les Ciseaux✂ battent La Feuille📋 et Le Lézard🦎​</li>
            <li>🔹La Feuille📋 bat La Pierre🪨 et Spock🖖</li>
            <li>🔹Le Lézard🦎 bat La Feuille📋 et Spock🖖</li>
            <li>🔹Spock🖖 bat La Pierre🪨 et Les Ciseaux✂</li>
        </ul>
        <p style="margin-bottom: 0; font-size: 20px">AM est doté d'intelligence et il vous déteste,</p>
        <p style ="font-size: 20px">le hasard ne vous ménera pas à la victoire</p>
      </div>
    </div>
  </div>
</div>
  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>