<?php
include 'baza_podataka.php';
session_start();
if(isset($_POST["unosaktivnosti"])){
  
    $nazivAktivnosti           = $_POST['NazivAktivnosti'];
    $opisAktivnosti       = $_POST['Opis'];
    $idProjekta          = $_POST['ZaProjekat'];
$conn = OpenCon();
$conn->query("SET NAMES 'utf8'");
$img=mysqli_fetch_assoc(mysqli_query($conn,'SELECT UUID() AS promenljiva'));
$id = $img["promenljiva"];
$sql = "INSERT INTO `aktivnosti` (`idAktivnosti`, `idProjekta`, `nazivAktivnosti`, `opisAktivnosti`, `statusAktivnosti`) VALUES  ('$id', '$idProjekta', '$nazivAktivnosti', '$opisAktivnosti', 'U toku');";
if($conn->query($sql)){
    header("Refresh:0; url=index.php");
}
else{
    echo '<script>alert("Nije uneto, greska.")</script>';
}
CloseCon($conn);
}
?>
<!DOCTYPE html>
<html>
    <head>

        <title>Dodavanje aktivnosti</title>

        <link rel="stylesheet" href="login.css">
        <link rel="stylesheet" href="style.css">

    </head>

    <body>
        <header>
            <nav>
              <?php 
              if($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Zaposleni'){

                echo'<ul class="main">
                
               
                
                                 
                      ';
                if($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Zaposleni'){
                  echo '
                  <div class="topnav">
                    <div class="search-container">
                    <form class="searchbox" action="/index.php">
                      <input type="search" placeholder="Pretraga po nazivu" name = "pretraga">
                      <button id = "dugmence" type="submit" value="search">&nbsp;</button>
                    </form>
                  </div>';
                }
                               
              echo '
              </div>
              <li class="">
              <form method=post action="/login.php?t=logout">
                <button class="button button3 name="logout" value="logout">Izloguj se</button>  
            </form>
            
                                                 
                      </li>
              </ul>';
              }
              else if($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Menadžer'){
                echo'<ul class="main"></div>
                <li class="">
                <form method=post action="/login.php?t=logout" style="margin-left: 1300px;">
                  <button class="button button3 name="logout" value="logout">Izloguj se</button>  
              </form>
              
                                                   
                        </li>
                </ul>';

              }
              
              ?>
              </nav>
        </header>

        <h1>Unos aktivnosti</h1>
        <div class="login-page">
            <div class="form">
              <form class="login-form" method="post" action="/dodavanjeaktivnosti.php">

              <input type="text" id="NazivAktivnosti" name="NazivAktivnosti" placeholder="Naziv aktivnosti">
              <input type="text" id="Opis" name="Opis" placeholder="Opis">
              <select id="ZaProjekat" name="ZaProjekat"  class="inputtabela">
              <?php
              $conn = OpenCon();
              $conn->query("SET NAMES 'utf8'");
              $sql="SELECT * FROM projekat";
              $rezultat=$conn->query($sql);
              if($rezultat->num_rows > 0){
                  while($red = $rezultat->fetch_assoc()){
                      if($_GET["t"]==$red["nazivProjekta"]){
                        echo ' <option value="'.$red["idProjekta"].'" selected="selected">'.$red["nazivProjekta"].'</option>';
                      }else{
                        echo ' <option value="'.$red["idProjekta"].'">'.$red["nazivProjekta"].'</option>';
                      }
                    }
                }
                CloseCon($conn);
                ?>
                </select>
                
                <button name="unosaktivnosti">Unos</button>


              </form>
            </div>
        </div> 

    </body>
</html>