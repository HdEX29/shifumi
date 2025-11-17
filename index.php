<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shifumi</title>
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['numeroaleatoire'])) {$_SESSION['numeroaleatoire'] = random_int(1,3);}
    $choix = $_GET('value');
    $ia = $_SESSION['numeroaleatoire'];
    echo $ia;
    if ($ia == $choix) {
        $resultat = "Egalite !";
        $_SESSION['numeroaleatoire'] = null;
    }
    else if ($ia == $choix+1 or $ia == 1 and $choix == 3) {
        $resultat = "Defaite...";
        $_SESSION['numeroaleatoire'] = null;
    }
    else if ($ia+1 == $choix or $ia == 3 and $choix == 1) {
        $resultat = "Victoire !";
         $_SESSION['numeroaleatoire'] = null;
    }
    $replay = $_GET('rejouer');
    if ($replay == "oui") {$choix = int(input("Pierre, Feuille ou Ciseaux ? (1, 2 ou 3 ?)  "));}
    ?>
</body>
</html>