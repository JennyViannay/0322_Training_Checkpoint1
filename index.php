<?php

require_once('connec.php');

$pdo = new PDO(DB_HOST, DB_USER, DB_PASS);

$query = "SELECT * FROM user";

$statement = $pdo->query($query);

$users = $statement->fetchAll(PDO::FETCH_ASSOC);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['username']) && !empty($_POST['age'])) {
        $query = "INSERT INTO user (username, age) VALUES (:username, :age)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
        $statement->bindValue(':age', $_POST['age'], PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();
        var_dump($result);
    } else {
        $error = "Tous les champs sont requis !";
    }
}

$total = 0;
foreach ($users as $user) {
    $total += $user['age'];
}
$alphabet = range('A', 'Z');
$numbers = range(1, 10);
var_dump($alphabet);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <?php foreach($alphabet as $letter) { ?>
           <a href="user.php?letter=<?= $letter?>"><?= $letter?></a>
        <?php } ?>
    </ul>
    <ul>
        <?php foreach($users as $user) { ?>
            <li><?= $user['username'] .' ' .$user['age'] ?></li>
        <?php } ?>
    </ul>
    <p><?= !empty($error) ? $error : ''; ?></p>
    <form method="POST">
        <div class="form-control">
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
        </div>
        <div class="form-control">
            <label for="age">Age</label>
            <input type="text" id="age" name="age">
        </div>
        <div class="form-control">
            <button type="submit">Create</button>
        </div>
    </form>
    <p>Total des âges : <?= $total ?></p>
    <p>Moyenne des âges : <?= $total / count($users) ?></p>
</body>
</html>