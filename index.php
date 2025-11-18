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
        else if ($ia == $choix+1 or $ia == 1 and $choix == 3) {
            return "Defaite...";
        }
        else if ($ia+1 == $choix or $ia == 3 and $choix == 1) {
            return "Victoire !";
        }
    }

    session_start();
    if (!isset($_SESSION['numeroaleatoire'])) {$_SESSION['numeroaleatoire'] = random_int(1,3);}
    $resultat = '';
    if ($_POST['value'] == 'Reset') {session_destroy();}
    $choix = signetonb($_POST['value']);
    $ia = $_SESSION['numeroaleatoire'];
    echo nbtosigne($ia);
    $resultat = shifumi($ia, $choix);
    $_SESSION['numeroaleatoire'] = null;
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
        <div class="container">
            <h1 class="fw-bold">SHIFUMI</h1>
            <p class="mt-3">Start Bootstrap can help you build better websites using the Bootstrap CSS framework! Just
                download your template and start going, no strings attached!</p>
            <a href="#" class="btn btn-start mt-3 a">FIND OUT MORE</a>
            <main class="h-100 w-50 align-center flex-col-justify-around butt">
                <form action="#" method="post">
                    <p class = 'p_absolute1'>
                        <span id = "message"><?php echo $resultat ?>
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