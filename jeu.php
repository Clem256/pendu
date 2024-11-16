<?php
session_start();
header('Content-type: text/html; charset=utf-8');

// Vérification des sessions de pseudos
if (isset($_SESSION['pseudo2'])) {
    echo $_SESSION['pseudo1']." vs " . $_SESSION['pseudo2'] . "<br/>"."<br/>";
}
// Vérification données et méthode post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mot']) && isset($_POST['nbessai'])) {
    $_SESSION['mot'] = $_POST['mot'];
    $_SESSION['nbessai'] = (int)$_POST['nbessai'];
    $_SESSION['nbessaitot'] = (int)$_POST['nbessai'];
} else {
    if (!isset($_SESSION['mot']) || !isset($_SESSION['nbessai'])) {
        echo "Données incorrectes.";
        exit();
    }
}

// Initialiser les "_"
if (empty($_SESSION['res'])) {
    $_SESSION['res'] = str_repeat('_', mb_strlen($_SESSION['mot']));
}
if (!isset($_SESSION['lettres_essayer'])) {
    $_SESSION['lettres_essayer'] = array();
}

// Traitement de la lettre entrée
if (!empty($_POST['lettre'])) {
    $lettre = $_POST['lettre'];

    // gestion minuscule et majuscule
    $motArray = preg_split('//u', $_SESSION['mot'], - 1, PREG_SPLIT_NO_EMPTY); // Découpage en caractères
    $resArray = preg_split('//u', $_SESSION['res'], - 1, PREG_SPLIT_NO_EMPTY);
    $lettre_trouvee = false;

    // maj du résultat si la lettre est trouvée
    for ($i = 0; $i < count($motArray); $i++) {
        if (mb_strtolower($lettre) == ' ' && $motArray[$i] == ' ') {
            // Si l'utilisateur entre un espace et le mot a un espace
            $resArray[$i] = ' ';
            $lettre_trouvee = true;
        } elseif (mb_strtolower($motArray[$i]) == mb_strtolower($lettre)) {
            // Si la lettre correspond (peu importe la casse)
            $resArray[$i] = $motArray[$i];
            $lettre_trouvee = true;
        }
    }

    // nb essai - 1 si la lettre est incorrecte et ajout dans lettres essayer
    if (!$lettre_trouvee) {
        $_SESSION['nbessai']--;
        if (!in_array($lettre, $_SESSION['lettres_essayer'])) {
            $_SESSION['lettres_essayer'][] = $lettre;
        }
    }

    $_SESSION['res'] = implode('', $resArray);
}

echo "<div style='letter-spacing: 10px; font-family: monospace;'>".$_SESSION['res']."</div><br/>";
echo "<br/>"."Essais restants : " . $_SESSION['nbessai'] . "<br/>";
echo "<br/>"."Lettres essayer : " ."<br/>"."<br/>". implode(', ', $_SESSION['lettres_essayer']) . "<br/>"."<br/>";
// Vérification si le mot est trouvé
if ($_SESSION['res'] == $_SESSION['mot']) {
    echo "Bravo " . $_SESSION['pseudo2'] .  ", tu as trouvé le mot !<br/>";
    try {
        $connexion =  new PDO('mysql:host=localhost;dbname=php','root','');
        $connexion -> setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        $pseudo1 = $_SESSION['pseudo1'];
        $pseudo2 = $_SESSION['pseudo2'];
        $nbessaibd = $_SESSION['nbessai'];
        $mot =  $_SESSION['mot'];
        $nbessaiswin = $_SESSION['nbessaitot'];
        $stmt = $connexion->prepare("INSERT INTO pendu(pseudo1,pseudo2,mot,nbessai) VALUES(?,?,?,?)");
        $stmt->execute([$pseudo1, $pseudo2,$mot ,"$nbessaibd/$nbessaiswin" ]);

    }
    catch (PDOException $e){
        die ('Erreur pdo'.$e->getMessage());
    }
    catch (Exception $e){
        die('Erreur général'.$e->getMessage());
    }
    // Réinitialisation des variables
    $_SESSION['mot'] = "";
    $_SESSION['res'] = "";
    $_SESSION['nbessai'] = 0;
    $_SESSION['lettres_essayer'] = array();
}

?>

<!DOCTYPE html>
<html>
<body>
<?php if ($_SESSION['nbessai'] > 0): ?>
    <form name="inscription" method="post" action="">
        Entrer une lettre : <input type="text" name="lettre" maxlength="1"><br/>
        <button type="submit">Valider</button>
    </form>
<?php endif; ?>
<a href="index.php">
    <button>Retour</button>
</a>
<a href="historique.php">
    <button>Historique</button>
</a>
</body>
</html>

<style>
    body {
        text-align: center;
        font-size: 25px;
        font-family: 'Arial', sans-serif;
        margin: 50px;
    }
    input {
        padding: 10px 30px;
        text-align: left;
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
    div {
        letter-spacing: 10px;
        font-family: monospace;
    }
</style>
