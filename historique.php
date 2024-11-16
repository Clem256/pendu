<?php
session_start();
header('Content-type: text/html; charset=utf-8');

try {
    $connexion = new PDO('mysql:host=localhost;dbname=php', 'root', '');
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur connexion BD: ' . $e->getMessage());
}

try {
    $stmt = $connexion->query("SELECT id, pseudo1, pseudo2, mot, nbessai, Time FROM pendu");
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erreur requête: ' . $e->getMessage());
}


?>

<!DOCTYPE html>
<html>
<body>
<h2>Historique des parties</h2>
<table style="width:100%; text-align: center;">
<thead>
    <tr>
        <th>ID</th>
        <th>Joueur 1</th>
        <th>Joueur 2</th>
        <th>Mot</th>
        <th>Nombre d'essais</th>
        <th>Date</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($resultats as $row): ?>
        <tr>
            <td><?php echo ($row['id']); ?></td>
            <td><?php echo ($row['pseudo1']); ?></td>
            <td><?php echo ($row['pseudo2']); ?></td>
            <td><?php echo ($row['mot']); ?></td>
            <td><?php echo ($row['nbessai']); ?></td>
            <td><?php echo ($row['Time']); ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>

<br/><br/>
<a href="index.php"><button>Retour</button></a>
</body>
</html>

<style>
    body {
        text-align: center;
        font-size: 20px;
        font-family: 'Arial', sans-serif;
        margin: 50px;
    }
    table {
        margin: auto;
        border-collapse: collapse;
        width: 80%;
    }
    th {
        background-color: dodgerblue;
        color: white;
    }
    td, th {
        padding: 15px;
        border: 1px solid black;
    }
    button {
        background-color: dodgerblue;
        color: white;
        border-radius: 5px;
        padding: 15px 30px;
        text-align: center;
        font-size: 20px;
        margin: 25px;
    }
    button:hover {
        background-color: darkblue;
    }
</style>
