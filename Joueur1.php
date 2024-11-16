<?php
session_start();
header('Content-type: text/html; charset=utf-8');
if (isset($_SESSION['pseudo1'])) {
    echo "Pseudo du joueur 1 : " . $_SESSION['pseudo1'] . "<br/>";
} else {
    echo "Le pseudo est pas défini.";
}
?>

<!DOCTYPE html>
<html>
<body>

<form name="inscription" method="post" action="jeu.php">
    Entrer le mot à rechercher : <input type="password" name="mot" required><br/>
    Entrer le nombre  d'essais :  <input type="number" name="nbessai" required><br/>
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
    input {
        margin-top: 20px;
        padding: 10px 30px;
        text-align: left;
    }
    button {
        border-radius: 5px;
        border: none;
        color: white;
        background-color: dodgerblue;
        padding: 15px 30px;
        font-size: 20px;
        text-align: center;
        margin-top: 50px;
    }
    button:hover{
        background-color: darkblue;
    }
</style>
