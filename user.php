<?php

require_once('connec.php');

$pdo = new PDO(DB_HOST, DB_USER, DB_PASS);

$query = "SELECT * FROM user WHERE username LIKE :letter";

$valueLetter = $_GET['letter'] .'%';
$statement = $pdo->prepare($query);
$statement->bindValue(':letter', $valueLetter, PDO::PARAM_STR);

$statement->execute();

$results = $statement->fetchAll(PDO::FETCH_ASSOC);

var_dump($results);