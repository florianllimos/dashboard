<?php

  require_once("component/database.php");
  session_start();

  if (!empty($_POST)) {
    if (isset($_POST["email"], $_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {

      if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

        $sql = "SELECT * FROM users WHERE email = :email";
        $query = $db->prepare($sql);
        $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch();

        if ($user && password_verify($_POST["password"], $user["password"])) {
          $_SESSION = [
            "id" => $user["id"],
            "email" => $user["email"]
          ];

          header("Location: dashboard.php");
          exit();
        }
      }
    }
  }
  
?>
   
<form method="POST">
  <div>
    <input type="email" name="email" required>
  </div>
  <div>
    <input type="password" name="password" required>
  </div>
  <div>
    <button type="submit">Connexion</button>
  </div>
</form>