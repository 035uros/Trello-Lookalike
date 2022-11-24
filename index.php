<?php
session_start();
error_reporting(0);
include 'baza_podataka.php';
set_url("http://localhost:3000/index.php");
if(!isset($_SESSION['potvrdjenpristup'])){
  $_SESSION['potvrdjenpristup'] = False;
}
if(!isset($_SESSION['rola'])){
  $_SESSION['rola'] = 'False';
}


if (!empty($_GET['t'])) {
  
  $id= $_GET['t'];
  $conn = OpenCon();

  $img=mysqli_fetch_assoc(mysqli_query($conn, "SELECT idAktivnosti AS idAktivnosti FROM `aktivnosti` WHERE aktivnosti.idProjekta = '$id'"));
  $idaktivnosti = $img["idAktivnosti"];

  $sql="DELETE FROM `dodeljeniprojekti` WHERE dodeljeniprojekti.idAktivnosti= '$idaktivnosti'";

  $conn->query($sql);
  
  $sql="DELETE FROM `aktivnosti` WHERE `aktivnosti`.`idProjekta` = '$id'";
 
  $conn->query($sql);

  $sql="DELETE FROM `projekat` WHERE `projekat`.`idProjekta` = '$id'";
 
  $conn->query($sql);
 
  $conn->close();

}
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Projekat - Upravljanje projektima </title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Cookie">
    </head>

    <body>
        <header>
            <nav>
              <?php 
              if($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Zaposleni'){

                echo'<ul class="main">
                  <div class="topnav">
                    <div class="search-container">
                    <form class="searchbox" action="/index.php">
                      <input type="search" placeholder="Pretraga po nazivu" name = "pretraga">
                      <button id = "dugmence" type="submit" value="search">&nbsp;</button>
                    </form>
                  </div>';
                               
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

        <main>


        <div class="board-lists">
        <?php 
        if ($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Menadžer'){
         $conn = OpenCon();
         $conn->query("SET NAMES 'utf8'");
    
         $sql="SELECT * FROM `projekat`"; 

         $rezultat=$conn->query($sql);
     
         if($rezultat->num_rows > 0){
         while($red = $rezultat->fetch_assoc()){
          echo '
          <div class="board-list">
            <div class="list-title">'. $red["nazivProjekta"]. '</div>';

            $id = $red["idProjekta"];
            $sql="SELECT * FROM `aktivnosti` WHERE aktivnosti.idProjekta = '$id'"; 

            $rezultat2=$conn->query($sql);
     
            if($rezultat2->num_rows > 0){
            while($red2 = $rezultat2->fetch_assoc()){
                echo '
                <div class="card"><a href="http://localhost:3000/comments/comments.php?idosobe='.$_SESSION['korisnik'].'&idprojekta='.$id.'&idaktivnosti='.$red2["idAktivnosti"].'">'.$red2["nazivAktivnosti"].'</a></div>';
              }
            }
            echo '<div>
            <button class="add-card-btn btn" onclick="window.location.href=\'dodavanjeaktivnosti.php?t='.$red["nazivProjekta"].'\'">+ Dodaj aktivnost</button>
            </div>
            <div>
            <button class="add-card-btn btn" onclick="window.location.href=\'izmeniprojekat.php?t='.$red["idProjekta"].'\'">+ Izmeni projekat</button>
            </div>
            <div>
            <button class="add-card-btn btn" onclick="window.location.href=\'index.php?t='.$red["idProjekta"].'\'">- Obriši projekat</button>
            </div>

            </div>';
            
          }
          echo '<button class="add-list-btn btn" onclick="window.location.href=\'dodavanjeprojekta.php\'">+ Unesi projekat</button>';
        }
        }
        else if($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Zaposleni'){
          $conn = OpenCon();
         $conn->query("SET NAMES 'utf8'");
         $idzaposlenog = $_SESSION["korisnik"];

         if(isset($_GET["pretraga"])){
           $pretraga=$_GET["pretraga"];
           $sql="SELECT * FROM projekat JOIN aktivnosti ON projekat.idProjekta =aktivnosti.idProjekta JOIN dodeljeniprojekti ON aktivnosti.idAktivnosti = dodeljeniprojekti.idAktivnosti WHERE dodeljeniprojekti.idOsobe ='$idzaposlenog' AND projekat.nazivProjekta = '$pretraga'"; 
         }
         else{
          $sql="SELECT * FROM projekat JOIN aktivnosti ON projekat.idProjekta =aktivnosti.idProjekta JOIN dodeljeniprojekti ON aktivnosti.idAktivnosti = dodeljeniprojekti.idAktivnosti WHERE dodeljeniprojekti.idOsobe ='$idzaposlenog'"; 
         }
    

         $rezultat=$conn->query($sql);
         $niz = array();
         if($rezultat->num_rows > 0){
         while($red = $rezultat->fetch_assoc()){
          if (!in_array($red["nazivProjekta"], $niz)) {
          echo '
          <div class="board-list">
            <div class="list-title">'. $red["nazivProjekta"]. '</div>';
            array_push($niz, $red["nazivProjekta"]);
            $id = $red["idProjekta"];
            $sql="SELECT * FROM `aktivnosti` JOIN dodeljeniprojekti ON aktivnosti.idAktivnosti = dodeljeniprojekti.idAktivnosti WHERE aktivnosti.idProjekta = '$id' AND dodeljeniprojekti.idOsobe =  '$idzaposlenog'"; 

            $rezultat2=$conn->query($sql);
     
            if($rezultat2->num_rows > 0){
            while($red2 = $rezultat2->fetch_assoc()){
                echo '
                <div class="card"><a href="http://localhost:3000/comments/comments.php?idosobe='.$_SESSION['korisnik'].'&idprojekta='.$id.'&idaktivnosti='.$red2["idAktivnosti"].'">'.$red2["nazivAktivnosti"].'</a></div>';
              }
            }
            echo '</div>';
          }
        }
        }

        }else if($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Administrator'){
          echo'<script>window.open("kontrolnatabla.php" , "_self")</script>';
        }else{
          echo'<script>window.open("login.php", "_self")</script>';
         }
        
        
        ?>
        <!--<button class="add-list-btn btn" onclick="window.location.href='dodavanjeprojekta.php'">+ Unesi projekat</button>    -->
        
              
            </div>           
        </main>   
    </body>
</html>