<?php
include 'baza_podataka.php';
session_start();
if(isset($_GET["t"])){
  $_SESSION["potvrdjenpristup"] = false;
}
set_url("http://localhost:3000/login.php");

?>

<!DOCTYPE html>
<html>
    <head>

        <title>Prijava</title>

        <link rel="stylesheet" href="login.css">

    </head>

    <body>

        <div class="login-page">
            <div class="form">
              <form class="login-form">

                <input type="text" placeholder="username"  name="user" />
                <input type="password" placeholder="password"  name="pass" />

                <button name="logovanje">PRIJAVA</button>
                
                <p class="message"> Nisi registrovan? <a href="reg.php"> Napravi nalog </a></p>

                <?php
                    if(isset($_GET["logovanje"])){
                      
                      $conn = OpenCon();
                      $conn->query("SET NAMES 'utf8'");
                      $sql = "SELECT * FROM osoba WHERE verifikovan = 1";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        while($red = $result->fetch_assoc()) {
                          if($_GET["pass"]==$red["sifra"] && $_GET["user"]==$red["username"]){
                            $_SESSION['potvrdjenpristup']=true;
                            $_SESSION['korisnik']=$red["idOsobe"];
                            $_SESSION['rola']=$red["rola"];
                            if($_SESSION['rola'] == "Administrator"){
                              echo '<script>window.open("kontrolnatabla.php", "_self")</script>';
                            }
                            else{
                              echo '<script>window.open("index.php", "_self")</script>';
                            }
                          }
                        }
                        echo '<script>alert("Korisničko ime i šifra se ne poklapaju.")</script>';
                      }
                    }
                    ?>
              </form>
            </div>
        </div>

    </body>
</html>