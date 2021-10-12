<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
require_once '_connec.php';
$pdo = new \PDO(DSN, USER, PASS);       
?>
    <form method="post">
    <div>
      <label  for="firstName">Firstname :</label>
      <input  type="text" id="firstName" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" name="firstName" required>
    </div>
    <div>
      <label  for="lastName">Lastname :</label>
      <input  type="text" id="lastName" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" name="lastName" required>
    </div>
    <div  class="button">
    <button  type="submit">Envoyer votre message</button>
    </div>
    </form>
<?php 
function test_input($datas) 
{
    $datas = trim($datas);
    $datas = stripslashes($datas);
    $datas = htmlspecialchars($datas);
    return $datas;
}
if (!empty($_POST)) 
{
$firstName = test_input($_POST["firstName"]);
$lastName = test_input($_POST["lastName"]);
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstName, :lastName)";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':firstName', $firstName, \PDO::PARAM_STR);
    $statement->bindValue(':lastName', $lastName, \PDO::PARAM_STR);
    $statement->execute();
}
    $queryShow = "SELECT firstname, lastname FROM friend";
    $statementShow = $pdo->query($queryShow);
    $friends = $statementShow->fetchAll(PDO::FETCH_ASSOC);
    foreach($friends as $friend) {
        echo $friend['firstname'].' '.$friend['lastname']. "<br>";
    }
} else {
    $queryShow = "SELECT firstname, lastname FROM friend";
    $statementShow = $pdo->query($queryShow);
    $friends = $statementShow->fetchAll(PDO::FETCH_ASSOC);
    foreach($friends as $friend) {
        echo $friend['firstname'].' '.$friend['lastname']. "<br>";
    }
} 
?>
</body>
</html>
