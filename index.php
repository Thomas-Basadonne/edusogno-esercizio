<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM utenti
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();


    // Verifica se l'utente è stato trovato
    if ($user) {
        // Ottieni gli eventi associati all'utente
        $email = $user["email"];
        $eventiSql = "SELECT * FROM eventi WHERE FIND_IN_SET('{$email}', attendees)";
        $eventiResult = $mysqli->query($eventiSql);
        $eventi = $eventiResult->fetch_all(MYSQLI_ASSOC);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <h1>Home</h1>
    
    <?php if (isset($user)): ?>
        
        <p>Welcome <?= htmlspecialchars($user["nome"]) ?> <?= htmlspecialchars($user["cognome"]) ?></p>

        <?php if (isset($eventi) && count($eventi) > 0): ?>
            <h2>Eventi a cui partecipi:</h2>
            <ul>
                <?php foreach ($eventi as $evento): ?>
                    <li><?= htmlspecialchars($evento["nome_evento"]) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        
        <p><a href="logout.php">Log out</a></p>
        
    <?php else: ?>
        
        <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
        
    <?php endif; ?>

    
</body>
</html>
    
    