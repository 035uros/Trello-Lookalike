<?php
session_start();
if ($_SESSION["potvrdjenpristup"] != true || $_SESSION['rola']!='Administrator'){
  header( 'location: /index.php' );
 }
include 'baza_podataka.php';
if (isset($_POST['brisi'])) {
    $id= $_POST['brisi'];
    $conn = OpenCon();

    $sql="DELETE FROM `osoba` WHERE `osoba`.`idOsobe` = '$id'";
   
    $conn->query($sql);
   
    $conn->close();

  }
  if (isset($_POST['odobri'])) {
    $id= $_POST['odobri'];
    $conn = OpenCon();

    $sql="UPDATE `osoba` SET `verifikovan` = '1' WHERE `osoba`.`idOsobe` = '$id'";
   
    $conn->query($sql);
   
    $conn->close();

  }

  if(isset($_POST["unoskorisnika"])){
  
    $ime           = $_POST['Ime'];
    $prezime       = $_POST['Prezime'];
    $rola          = $_POST['Rola'];
    $user          = $_POST['Username'];
    $sifra         = $_POST['Sifra'];
$conn = OpenCon();
$conn->query("SET NAMES 'utf8'");
$img=mysqli_fetch_assoc(mysqli_query($conn,'SELECT UUID() AS promenljiva'));
$id = $img["promenljiva"];
$sql = "INSERT INTO `osoba` (`idOsobe`, `ime`, `prezime`, `rola`, `username`, `sifra`, `verifikovan`) VALUES ('$id', '$ime', '$prezime', '$rola', '$user', '$sifra', 1);";
if($conn->query($sql)){
    echo '<script>alert("Uneto.")</script>';
}
else{
    echo '<script>alert("Nije uneto, korisničko ime zauzeto.")</script>';
}
CloseCon($conn);
}

if (isset($_POST['azuriraj'])) {
  $id= $_POST['azuriraj'];
  $idnovi        = $_POST['Id'];
  $ime           = $_POST['Ime'];
  $prezime       = $_POST['Prezime'];
  $rola          = $_POST['Rola'];
  $user          = $_POST['Username'];
  $sifra         = $_POST['Sifra'];
  $conn = OpenCon();
  $conn->query("SET NAMES 'utf8'");
  $sql="UPDATE `osoba` SET `idOsobe` = '$idnovi', `ime` = '$ime', `prezime` = '$prezime', `rola` = '$rola', `username` = '$user', `sifra` = '$sifra' WHERE `osoba`.`idOsobe` = '$id'";
 
  $conn->query($sql);
 
  $conn->close();

}
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Kontrolna tabla</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Cookie">
    </head>

    <body style="background-image: url(bg2.jpg); background-repeat:repeat-y;"> 
    <header>
            <nav>
              <?php if($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Administrator'){
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

        <table id="tabela">
  <?php 

  $conn = OpenCon();
  $conn->query("SET NAMES 'utf8'");

  $sql="SELECT * FROM osoba WHERE `verifikovan` = '0'";

  $rezultat=$conn->query($sql);

  if($rezultat->num_rows > 0){
    echo '
             <h1>Odobravanje novih korisnika</h1>
             <thead>
                 <tr>
                     <th >Id</th>
                     <th >Ime</th>
                     <th >Prezime</th>
                     <th >Rola</th>
                     <th >Korisničko ime</th>
                     <th >Šifra</th>
                 </tr>
             </thead>';
  while($red = $rezultat->fetch_assoc()){
      echo "<tr>";
      echo '<td>'. $red["idOsobe"].'</td>';
      echo '<td>'. $red["ime"]. '</td>';
      echo '<td>'. $red["prezime"]. '</td>';
      echo '<td>'. $red["rola"]. '</td>';
      echo '<td>'. $red["username"]. '</td>';
      echo '<td>'. $red["sifra"]. '</td>';
      echo '<form method="post" action="/kontrolnatabla.php" ><td><button class="dugme" name="odobri" onclick="return confirm(\'Sigurno?\')" value="'. $red["idOsobe"]. '">Odobri</button></td>';
      echo '<td><button name="brisi" class="dugme" onclick="return confirm(\'Sigurno, nakon brisanja nema povratka informacija?\')" value="'. $red["idOsobe"]. '">Obrisi</button></td></form></tr>';
  }
  }
$conn->close();
?>
  </tr>
</table>

<h1>Unos novog korisnika</h1>
<div class="login-page">
            <div class="form">
              <form class="login-form" method="post" action="/kontrolnatabla.php">

              <input type="text" id="Username" name="Username" placeholder="username">
              <input type="text" id="Ime" name="Ime" placeholder="Ime">
              <input type="text" id="Prezime" name="Prezime" placeholder="Prezime">
              <input type="password" id="Sifra" name="Sifra" placeholder="Šifra">
              <select  class="inputtabela"  id="Rola" name="Rola">
                  <option value="Menadžer">Menadžer</option>
                  <option value="Zaposleni" selected="selected">Zaposleni</option>
                  <option value="Administrator">Administrator</option>
                </select>
                
                <button name="unoskorisnika">Unesi</button>

              </form>
            </div>
        </div> 

        <table id="tabela">
  <?php 

  $conn = OpenCon();
  $conn->query("SET NAMES 'utf8'");

  $sql="SELECT * FROM osoba WHERE `verifikovan` = '1'";

  $rezultat=$conn->query($sql);

  if($rezultat->num_rows > 0){
    echo '
             <h1>Brisanje korisnika</h1>
             <thead>
                 <tr>
                  <th >Id</th>
                  <th >Ime</th>
                  <th >Prezime</th>
                  <th >Rola</th>
                  <th >Korisničko ime</th>
                  <th >Šifra</th>
                 </tr>
             </thead>';
  while($red = $rezultat->fetch_assoc()){
    echo "<tr>";
    echo '<td>'. $red["idOsobe"].'</td>';
    echo '<td>'. $red["ime"]. '</td>';
    echo '<td>'. $red["prezime"]. '</td>';
    echo '<td>'. $red["rola"]. '</td>';
    echo '<td>'. $red["username"]. '</td>';
    echo '<td>'. $red["sifra"]. '</td>';
    echo '<form method="post" action="/kontrolnatabla.php" ><td><button class="dugme" name="brisi" onclick="return confirm(\'Sigurno?\')" value="'. $red["idOsobe"]. '">Obriši</button></td></form></tr>';
  }
  }
$conn->close();
?>
</table>

<table id="tabela">
  <?php 

  $conn = OpenCon();
  $conn->query("SET NAMES 'utf8'");

  $sql="SELECT * FROM osoba WHERE `verifikovan` = '1'";
  $role=["Administrator", "Menadžer", "Zaposleni"];
  $rezultat=$conn->query($sql);

  if($rezultat->num_rows > 0){
    echo '
             <h1>Ažuriranje korisnika</h1>
             <thead>
                 <tr>
                 <th >Id</th>
                 <th >Ime</th>
                 <th >Prezime</th>
                 <th >Korisničko ime</th>
                 <th >Šifra</th>
                 <th >Rola</th>
                 </tr>
             </thead>';
  while($red = $rezultat->fetch_assoc()){
    echo '<form method="post" action="/kontrolnatabla.php" ><tr>';
    echo '<td><input class="inputtabela" type="text" id="Id" name="Id" value="'. $red["idOsobe"].'"></td>';
    echo '<td><input class="inputtabela" type="text" id="Ime" name="Ime" value="'. $red["ime"].'"></td>';
    echo '<td><input class="inputtabela" type="text" id="Prezime" name="Prezime" value="'. $red["prezime"].'"></td>';
    echo '<td><input class="inputtabela" type="text" id="Username" name="Username" value="'. $red["username"].'"></td>';
    echo '<td><input class="inputtabela" type="text" id="Sifra" name="Sifra" value="'. $red["sifra"].'"></td>';
    echo '<td><select  class="inputtabela"  id="Rola" name="Rola">';
    foreach($role as $value){
        if($value == $red["rola"]){
            echo '<option value="'.$value.'" selected="selected">'.$value.'</option>';
        }
        else{
           echo '<option value="'.$value.'">'.$value.'</option>';
        }
    }
    echo '</select></td>';
    echo '<td><button class="dugme" name="azuriraj" onclick="return confirm(\'Sigurno, nakon azuriranja nema povratka starih informacija?\')" value="'. $red["idOsobe"]. '">Ažuriraj</button></td></form></tr>';
  }
  }
$conn->close();
?>
</table>

    </body>
</html>