<?php
include 'baza_podataka.php';
if(isset($_POST["unosprojekta"])){
  
    $naziv            = $_POST['nazivProjekta'];
    $lokacija         = $_POST['Lokacija'];
    $skolskaSprema    = $_POST['SkolskaSprema'];
    $opis             = $_POST['Opis'];
    $benefiti         = $_POST['Benefiti'];
    $rok         = $_POST['RokKonkursa'];
$conn = OpenCon();
$conn->query("SET NAMES 'utf8'");
$img=mysqli_fetch_assoc(mysqli_query($conn,'SELECT UUID() AS promenljiva'));
$id = $img["promenljiva"];
$sql = "INSERT INTO `projekat` (`idProjekta`, `nazivProjekta`, `lokacija`, `skolskaSprema`, `opisPosla`, `benefiti`, `rokKonkursa`, `statusProjekta`) VALUES ('$id', '$naziv', '$lokacija', '$skolskaSprema', '$opis', '$benefiti', '$rok', 'U toku');";
$out=$conn->query($sql);
if($out){
    header( 'location: /index.php' );
}
else{
    echo '<script>alert("Nije uneto, greska '.$out.'")</script>';
    echo $out;

}
CloseCon($conn);
}
?>
<!DOCTYPE html>
<html>
    <head>

        <title>Registracija</title>

        <link rel="stylesheet" href="login.css">

    </head>

    <body>

        <div class="login-page">
            <div class="form">
              <form class="login-form" method="post" action="/dodavanjeprojekta.php">

              <input type="text" id="nazivProjekta" name="nazivProjekta" placeholder="Naziv Projekta">
              <input type="text" id="Lokacija" name="Lokacija" placeholder="Lokacija">
                <select id="SkolskaSprema" name="SkolskaSprema"  class="inputtabela">
                  <option value="Osnovna">Osnovna</option>
                  <option value="Srednja" >Srednja</option>
                  <option value="Visoka" selected="Visoka">Visoka</option>
                </select>
            <input type="text" id="Opis" name="Opis" placeholder="Opis posla">
            <input type="text" id="Benefiti" name="Benefiti" placeholder="Benefiti">
            <input type="text" id="RokKonkursa" name="RokKonkursa" placeholder="Rok">
                
                <button name="unosprojekta">Unos</button>


              </form>
            </div>
        </div> 

    </body>
</html>