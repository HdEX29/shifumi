<?php
//Classemment

include "config.php"; 

$pdo = new PDO(
  "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
  $username,
  $password,
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
