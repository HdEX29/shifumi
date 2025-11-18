<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>

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

    session_start();
    if (!isset($_SESSION['numeroaleatoire'])) {$_SESSION['numeroaleatoire'] = random_int(1,3);}
    $resultat = '';
    if (!empty($_POST['value'])) {
        if ($_POST['value'] == 'Reset') {
            session_destroy();
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        }
        $choix = signetonb($_POST['value']);
        $ia = $_SESSION['numeroaleatoire'];
        $resultat = shifumi($ia, $choix);
        $_SESSION['numeroaleatoire'] = null;
    }
    ?>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">MENU </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">ABOUT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">SERVICES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link -toggle" href="#" aria-expanded="false">
                            PORTFOLIO
                        </a>
                    <li class="nav-item">
                        <a class="nav-link" href="#">CONTACT</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container h-100">
            <h1 class="fw-bold">SHIFUMI</h1>
            <p class="mt-3">Votre adversaire joue : <?php if (isset($ia)) {try {echo nbtosigne($ia);} catch (Throwable $t) {echo "Rien, pour l'instant...";}} else {echo "Rien, pour l'instant...";} ?> !</p>
            <p class="btn btn-start mt-3 a"><?php echo $resultat ?></p>
            <main class="w-50 align-center flex-col-justify-around butt">
                <form action="#" method="post">
                    <p class = 'p_absolute1'>
                        <span id = "message">
                    </p>
                    <input class="btn btn-primary" type="submit" value="Pierre" name="value">
                    <input class="btn btn-primary" type="submit" value="Feuille" name="value">
                    <input class="btn btn-primary" type="submit" value="Ciseaux" name="value">
                    <input class="btn btn-primary" type="submit" value="Reset" name="value">
                </form>
            </main>
        </div>
    </section>


</html>