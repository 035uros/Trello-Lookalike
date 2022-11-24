<?php
session_start();
include 'baza_podataka.php';
if(!empty($_GET['t'])){
    $GLOBALS['id']= $_GET['t'];
}
if (isset($_POST['azuriraj'])) {
    $id= $_POST['azuriraj'];
    $idnovi        = $_POST['Id'];
    $naziv            = $_POST['nazivProjekta'];
    $lokacija         = $_POST['Lokacija'];
    $skolskaSprema    = $_POST['SkolskaSprema'];
    $opis             = $_POST['Opis'];
    $benefiti         = $_POST['Benefiti'];
    $rok         = $_POST['RokKonkursa'];
    $status         = $_POST['Status'];
    $conn = OpenCon();
    $conn->query("SET NAMES 'utf8'");
    $sql="UPDATE `projekat` SET `idProjekta` = '$idnovi', `nazivProjekta` = '$naziv', `lokacija` = '$lokacija', `skolskaSprema` = '$skolskaSprema', `opisPosla` = '$opis', `benefiti` = '$benefiti', `rokKonkursa` = '$rok', `statusProjekta` = '$status' WHERE `projekat`.`idProjekta` = '$id'";
   
    $conn->query($sql);
   
    $conn->close();
    header( 'location: /index.php' );
  }
?>
<!DOCTYPE html>
<html>
    <head>

        <title>Registracija</title>

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

        <h1>Izmena projekta</h1>
        <div class="login-page">
            <div class="form">
              <form class="login-form" method="post" action="/izmeniprojekat.php">

              <?php 

         $conn = OpenCon();
         $conn->query("SET NAMES 'utf8'");
         $id=$GLOBALS['id'];
    
         $sql="SELECT * FROM projekat WHERE idProjekta = '$id'";
     
         $rezultat=$conn->query($sql);
         $sprema=["Osnova", "Srednja", "Visoka"];
         $status2=["U toku", "Zavrseno"];

     
         if($rezultat->num_rows > 0){
         while($red = $rezultat->fetch_assoc()){
             echo '<label class="labela" for="Id">ID:</label>';
             echo '<input type="text" id="Id" name="Id" value="'. $red["idProjekta"].'">';
             echo '<label class="labela" for="nazivProjekta">Naziv:</label>';
             echo '<input type="text" id="nazivProjekta" name="nazivProjekta" value="'. $red["nazivProjekta"].'">';
             echo '<label class="labela" for="Lokacija">Lokacija:</label>';
             echo '<input type="text" id="Lokacija" name="Lokacija" value="'. $red["lokacija"].'">';
             echo '<label class="labela" for="SkolskaSprema">Sprema:</label>';
             echo '<select id="SkolskaSprema" name="SkolskaSprema" class="inputtabela">';
             foreach($sprema as $value){
                 if($value == $red["skolskaSprema"]){
                     echo '<option value="'.$value.'" selected="selected">'.$value.'</option>';
                 }
                 else{
                    echo '<option value="'.$value.'">'.$value.'</option>';
                 }
             }
             echo '</select></td>';
             echo '<label class="labela" for="Opis">Opis:</label>';
             echo '<input type="text" id="Opis" name="Opis" value="'. $red["opisPosla"].'"></td>';
             echo '<label class="labela" for="Benefiti">Benefiti:</label>';
             echo '<input type="text" id="Benefiti" name="Benefiti" value="'. $red["benefiti"].'">';
             echo '<label class="labela" for="RokKonkursa">Rok:</label>';
             echo '<input type="text" id="RokKonkursa" name="RokKonkursa" value="'. $red["rokKonkursa"].'">';
             echo '<label class="labela" for="Status">Status:</label>';
             echo '<select id="Status" name="Status" class="inputtabela">';
             foreach($status2 as $value){
                if($value == $red["statusProjekta"]){
                    echo '<option value="'.$value.'" selected="selected">'.$value.'</option>';
                }
                else{
                   echo '<option value="'.$value.'">'.$value.'</option>';
                }
            }
            echo ' </select>';
             echo '  <button name="azuriraj" value="'. $red["idProjekta"]. '">Ažuriraj</button></form>';
         }
         }
         $conn->close();
         ?>
            </div>
        </div> 

    </body>
</html>