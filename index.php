<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shifumi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <style>
        .h-100 {
            height: 100vh;
        }

        .w-50 {
            width: 50vw;
        }

        .align-center {
            margin: 0 auto;
            text-align: center;
        }

        .flex-col-justify-around {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }
    </style>
</head>
<body>
    <?php
    function signetonb($signe) 
    {
        if ($signe == 'Pierre') {return 1;}
        else if ($signe == 'Feuille') {return 2;}
        else if ($signe == 'Ciseaux') {return 3;}
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
    if ($_POST['value'] == 'Reset') {session_abort();}
    $choix = signetonb($_POST['value']);
    $ia = $_SESSION['numeroaleatoire'];
    echo $ia;
    $resultat = shifumi($ia, $choix);
    $_SESSION['numeroaleatoire'] = null;
    ?>
    <main class="h-100 w-50 align-center flex-col-justify-around">
        <form action="#" method="post">
            <p class = 'p_absolute1'>
                <span id = "message"><?php echo $resultat ?>
            </p>
            <input class="btn btn-primary" type="submit" value="Pierre" name="value">
            <input class="btn btn-primary" type="submit" value="Feuille"  name="value">
            <input class="btn btn-primary" type="submit" value="Ciseaux"  name="value">
            <input class="btn btn-primary" type="submit" value="Reset"  name="value">
        </form>
    </main>
</body>
</html>