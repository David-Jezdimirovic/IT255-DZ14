<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization, Token, token, TOKEN');

include("functions.php");

if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['username']) && isset($_POST['password'])){

  $firstname = $_POST['firstName'];
  $lastname = $_POST['lastName'];
  $username = $_POST['username'];
  $password = ($_POST['password']);

  echo register($username,$password,$firstname,$lastname);
  // $stmt = $conn->prepare("INSERT INTO korisnici (ime, prezime, username, sifra) VALUES (?, ?, ?, ?)");
  // $stmt->bind_param("ssss", $ime, $prezime, $username, $sifra);
  // $stmt->execute();
  // echo "ok";
}
?>