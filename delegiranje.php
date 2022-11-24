<?php
include 'baza_podataka.php';
if(isset($_POST["unosaktivnosti"])){
  
    $idAktivnosti  = $_POST['Aktivnost'];
    $idOsobe       = $_POST['Zaposleni'];
$conn = OpenCon();
$conn->query("SET NAMES 'utf8'");
$img=mysqli_fetch_assoc(mysqli_query($conn,'SELECT UUID() AS promenljiva'));
$id = $img["promenljiva"];
$sql = "INSERT INTO `dodeljeniprojekti` (`idOsobe`, `idAktivnosti`) VALUES  ('$idOsobe', '$idAktivnosti');";
if($conn->query($sql)){
    echo '<script>alert("Dodeljeno.")</script>';
    header( 'location: /index.php' );
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

        <title>Delegiranje</title>

        <link rel="stylesheet" href="login.css">

    </head>

    <body>

        <div class="login-page">
            <div class="form">
              
              <form class="login-form"method="post" action="/delegiranje.php">
              <label for="Aktivnost">Aktivnost:</label>
              <select id="Aktivnost" name="Aktivnost" class="inputtabela">
                <?php
                $conn = OpenCon();
                $conn->query("SET NAMES 'utf8'");
                $sql="SELECT * FROM `aktivnosti` JOIN `projekat` ON aktivnosti.idProjekta=projekat.idProjekta";
                $rezultat=$conn->query($sql);
                if($rezultat->num_rows > 0){
                  while($red = $rezultat->fetch_assoc()){
                    echo '<option value="'.$red["idAktivnosti"].'">'.$red["nazivAktivnosti"].' | '.$red["nazivProjekta"].'</option>';
                  }
                }
                ?>
                </select>
                <label for="Zaposleni">Zaposleni:</label>
                <select id="Zaposleni" name="Zaposleni" class="inputtabela">
                  <?php
                  $sql="SELECT * FROM `osoba` WHERE `rola` = 'Zaposleni'";
                  $rezultat=$conn->query($sql);
                  if($rezultat->num_rows > 0){
                    while($red = $rezultat->fetch_assoc()){
                      echo ' <option value="'.$red["idOsobe"].'">'.$red["ime"].' '.$red["prezime"].' | '.$red["username"].'</option>';
                    }
                  }
                  CloseCon($conn);
                  ?>
                  </select>
                  <button name="unosaktivnosti" type= "submit" value="unosaktivnosti">Dodeli</button>
                </form>

              
            </div>
        </div>

    </body>
</html>