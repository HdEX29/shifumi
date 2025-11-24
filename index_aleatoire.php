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
  radial-gradient(circle at 25% 40%, rgba(200,255,241,0.9), transparent 60%),
  radial-gradient(circle at 75% 60%, rgba(212,230,255,0.9), transparent 60%),
  #f0e6ff;

}

 .game-card {
      background: rgba(239, 237, 243, 0.897);
      backdrop-filter: blur(8px);
      border-radius: 1.5rem;
    }
    .hand-icon {
      font-size: 2.5rem;
      color: #000 ;
      }
.game-container {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;     
    text-align: center;
}

.choice-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.5rem;
    width: 100%;
}
.choice-buttons span {
    color: #000;
}

.result-block {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.message-block {
    text-align: center;
    width: 100%;
    margin-top: 1rem;
    
}
#message {
    color: #000 !important;
    background-color: #d6ecff;
    border-color: transparent;
}
.small.text-white-50{
    color: #000;
    opacity: 1 ;
}
</style>

<body>
    <?php
    function signetonb($signe) 
    {
        if ($signe == 'Pierre') {return 1;}
        else if ($signe == 'Feuille') {return 2;}
        else if ($signe == 'Ciseaux') {return 3;}
    }

    function nbtosigne($nb) 
    {
            if ($nb == 1) {return 'Pierre';}
            else if ($nb == 2) {return 'Feuille';}
            else if ($nb == 3) {return 'Ciseaux';}
    }

    function shifumi($ia, $choix)
    {
        if ($ia == $choix) {
            return "Egalite !";
        }
        else if (($ia == $choix+1) || ($ia == 1 && $choix == 3))  {
            return "Defaite...";
        }
        else if (($ia+1 == $choix) || ($ia == 3 && $choix == 1)) {
            return "Victoire !";
        }
    }

    function addicon($signe) 
    {
        if (isset($signe)) {
            {try {
                if ($signe == 'Pierre') {return '<span class="hand-icon mb-1"><i class="fa-regular fa-hand-back-fist"></i></span>';}
                elseif ($signe == 'Feuille') {return '<span class="hand-icon mb-1"><i class="fa-regular fa-hand"></i></span>';}
                else {return '<span class="hand-icon mb-1"><i class="fa-regular fa-hand-scissors"></i></span>';}
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

    date_default_timezone_set('Europe/Paris');
    session_start();
    if (!isset($_SESSION['debut_session'])) {$_SESSION['debut_session'] = time();}
    if (!isset($_SESSION['nbpartie'])) { $_SESSION['nbpartie'] = 1; }
    if (!isset($_SESSION['nbvictoire'])) { $_SESSION['nbvictoire'] = 0; }
    if (!isset($_SESSION['nbdefaite'])) { $_SESSION['nbdefaite'] = 0; }
    if (!isset($_SESSION['numeroaleatoire'])) {$_SESSION['numeroaleatoire'] = random_int(1,3);}
    $resultat = '';
    if (!empty($_POST['value'])) {
        if ($_POST['value'] == 'Reset') {
            session_destroy();
            header("Location: ".$_SERVER['PHP_SELF']);
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
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light bg-opacity-75 sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">SHIFUMI –    Joueur 👤  vs Machine 💻 </a>
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
                                <p class="mt-3">Choisis une main pour affronter la machine 😉 </p>
                                <div class="container-m1">
                                    <p class="mt-3">
                                        Rappelez-vous❗
                                    <ul>
                                        <li>🔹Pierre🪨 bat Ciseaux✂</li>
                                        <li>🔹Ciseaux✂ battent Feuille📋</li>
                                        <li>🔹Feuille📋 bat Pierre🪨</li>
                                    </ul>
                                    </p>
                                </div>                            
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
                    <?= addicon($choix ?? null)?>
                    <div id="player-hand-text" class="small"><?= choice($choix ?? null) ?></div>  
                </div>  

                <div>  
                    <div class="small text-uppercase text-muted mb-1">Machine</div>  
                    <?= addicon(nbtosigne($ia ?? null) ?? null)?>  
                    <div id="computer-hand-text" class="small"><?= choice(nbtosigne($ia ?? null) ?? null) ?></div>  
                </div>  
            </div>  
        </div>  
        <a href="#" class="btn btn-start mt-3 a">Qui sera le champion 🥇 ? </a>

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

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>