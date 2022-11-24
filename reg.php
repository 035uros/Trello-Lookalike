<?php
include 'baza_podataka.php';
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
$sql = "INSERT INTO `osoba` (`idOsobe`, `ime`, `prezime`, `rola`, `username`, `sifra`, `verifikovan`) VALUES ('$id', '$ime', '$prezime', '$rola', '$user', '$sifra', 0);";
if($conn->query($sql)){
    header( 'location: /login.php' );
}
else{
    echo '<script>alert("Nije uneto, korisničko ime zauzeto.")</script>';
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
              <form class="login-form" method="post" action="/reg.php">

              <input type="text" id="Username" name="Username" placeholder="username">
              <input type="text" id="Ime" name="Ime" placeholder="Ime">
              <input type="text" id="Prezime" name="Prezime" placeholder="Prezime">
              <input type="password" id="Sifra" name="Sifra" placeholder="Šifra">
              <select id="Rola" name="Rola"  class="inputtabela">
                  <option value="Menadžer">Menadžer</option>
                  <option value="Zaposleni" selected="selected">Zaposleni</option>
                </select>
                
                <button name="unoskorisnika">Podnesi zahvtev</button>

                <p class="message"> Već ste registrovani? <a href="login.php"> Uloguj se, </a></p>

              </form>
            </div>
        </div> 

    </body>
</html>