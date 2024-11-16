<?php
session_start();
header('Content-type: text/html; charset=utf-8');

// Vérifier la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si le pseudo 1 existe
    if (!empty($_POST['pseudo1'])) {
        $_SESSION['pseudo1'] = $_POST['pseudo1'];
        $_SESSION['pseudo2'] = $_POST['pseudo2'];

        // redirection 2nd page
        header("Location: Joueur1.php");
        exit();
    } else {
        echo "Veuillez entrer des pseudos pour les deux joueurs.";
    }
}
$_SESSION['mot'] = "";
$_SESSION['res'] = "";
$_SESSION['nbessai'] = 0;
?>

<html>
<body>
<form action="joueur.php" method="post">
    Entrer le pseudo du joueur 1 :
    <input type="text" name="pseudo1" required> <br/> <br/>
    Entrer le pseudo du joueur 2 :
    <input type="text" name="pseudo2" required> <br/>
    <button type="submit">Valider</button>
</form>
</body>
</html>
<style>
    body {
        font-family: 'Arial', sans-serif;
        font-size: 25px;
        text-align: center;
    }

    button {
        background-color: dodgerblue;
        border: none;
        color: white;
        padding: 15px 30px;
        text-align: center;
        font-size: 20px;
        border-radius: 5px ;
        margin-top:  50px;
    }
    button:hover {
        background-color: darkblue;
    }
    input {
        padding: 10px 30px;
        text-align: left;

    }

</style>