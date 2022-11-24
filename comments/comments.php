<?php
include 'baza_podataka.php';
session_start();
$id_projekta= $_GET['idprojekta'];
$id_osobe=$_GET['idosobe'];
$id_aktivnosti=$_GET['idaktivnosti'];

if (isset($_POST['odgovor'])) {
  $id= $_POST['odgovor'];
  $odg = $_POST["Odgovor"];
  $conn = OpenCon();
  $conn->query("SET NAMES 'utf8'");
  $sql="INSERT INTO `odgovorkomentara` (`idKomentara`, `tekstOdgovora`) VALUES ('$id', '$odg');";
 
  $conn->query($sql);
 
  $conn->close();


}
if (isset($_POST['komentar'])) {
  $id= $_POST['komentar'];
  $tekst = $_POST["TekstKomentara"];
  $conn = OpenCon();
  $conn->query("SET NAMES 'utf8'");
  $img=mysqli_fetch_assoc(mysqli_query($conn,'SELECT UUID() AS promenljiva'));
  $idkom = $img["promenljiva"];
  $sql="INSERT INTO `komentar` (`idKomentara`, `idAktivnosti`, `tekstKomentara`) VALUES ('$idkom', '$id', '$tekst')";
 
  $conn->query($sql);
 
  $conn->close();


}
if (isset($_POST['pregled'])) {
  $id= $_POST['pregled'];
  $status = $_POST["statusAktivnosti"];
  $conn = OpenCon();
  $conn->query("SET NAMES 'utf8'");
  $sql="UPDATE `aktivnosti` SET `statusAktivnosti` = '$status' WHERE `aktivnosti`.`idAktivnosti` = '$id'";
 
  $conn->query($sql);
 
  $conn->close();


}

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <title>Detalji</title>
    </head>
    <body>
    <header>
            <nav>
              <?php 
              if($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Zaposleni'){

                echo'<ul class="main" style="padding-left: 1180px; padding-top:12px;">
                  <div class="topnav">
                    <div class="search-container">
                    
                  </div>';
                               
              echo '
              </div>
              <li class="">
              <form method=post action="/index.php?t=logout">
                <button class="button button3 name="logout" value="logout">Početna strana</button>  
            </form>
            
                                                 
                      </li>
              </ul>';
              }
              else if($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Menadžer'){
                echo'<ul class="main" style="padding-left: 1180px; padding-top:12px;"></div>
                <li class="">
                <form method=post action="/index.php?t=logout">
                <button class="button button3 name="logout" value="logout">Početna strana</button>  
            </form>
              
                                                   
                        </li>
                </ul>';

              }
              
              ?>
              </nav>
        </header>

    <?php 
    
    if($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Zaposleni'){
    $conn = OpenCon();
    $conn->query("SET NAMES 'utf8'");

    $sql="SELECT * FROM projekat JOIN aktivnosti ON projekat.idProjekta = aktivnosti.idProjekta JOIN dodeljeniprojekti ON dodeljeniprojekti.idAktivnosti=aktivnosti.idAktivnosti JOIN osoba ON dodeljeniprojekti.idOsobe=osoba.idOsobe WHERE dodeljeniprojekti.idOsobe = '$id_osobe' and projekat.idProjekta = '$id_projekta' AND aktivnosti.idAktivnosti ='$id_aktivnosti'"; 

    $rezultat=$conn->query($sql);

    $flegnaslov = 1;
    if($rezultat->num_rows > 0){
    while($red = $rezultat->fetch_assoc()){
      $ime = $red["ime"];
      $prezime = $red["prezime"];

      if($flegnaslov == 1){
        echo '<div id="">
        <section class="">
            <div class="container">
                <div class="">
                    <h1 class="naziv_projekta"> '.$red["nazivProjekta"].'</h1>
                    <div class="">
                        <h2 class="opis">'.$red["nazivAktivnosti"].'</h2>';
                  $sql2="SELECT statusAktivnosti FROM `dodeljeniprojekti` JOIN aktivnosti ON dodeljeniprojekti.idAktivnosti = aktivnosti.idAktivnosti JOIN projekat ON projekat.idProjekta = aktivnosti.idProjekta JOIN osoba ON dodeljeniprojekti.idOsobe = osoba.idOsobe WHERE aktivnosti.idAktivnosti = '$id_aktivnosti'"; // dodati WHERE dodeljeniprojekti.idOsobe = '$id'  
     
     $rezultat4=$conn->query($sql2);
     $faza=["Izrada", "U toku", "Završeno"];
 
     if($rezultat4->num_rows > 0){
     while($red4 = $rezultat4->fetch_assoc()){
         echo '<form method="post" action="/comments/comments.php?idosobe='.$_SESSION['korisnik'].'&idprojekta='.$id_projekta.'&idaktivnosti='.$id_aktivnosti.'"> <select id="statusAktivnosti" name="statusAktivnosti" class="statusmali">';
         foreach($faza as $value){
             if($value == $red4["statusAktivnosti"]){
                 echo '<option value="'.$value.'" selected="selected">'.$value.'</option>';
             }
             else{
                echo '<option value="'.$value.'">'.$value.'</option>';
             }
         }
         echo '</select><button name="pregled" value="'. $id_aktivnosti. '" class="button button3">Ažuriraj status</button></form></div>';
     }
         }
                        echo '
                        <span class="opis_projekta">Opis: </span>
                            <p class="opis_projekta">'.$red["opisPosla"].'</p>
                    </div>
                </div>
            </div>
            
        </section>
    </div>';
    
    $flegnaslov=0;
      }

      echo '<div class="container">
        <div class="row">
          <div class="col-12">
            <div class="comments">';
      //$sql="SELECT * FROM komentar JOIN odgovorkomentara ON komentar.idKomentara = odgovorkomentara.idKomentara WHERE komentar.idAktivnosti = '$id_aktivnosti'"; 

      $sql="SELECT * FROM komentar WHERE komentar.idAktivnosti = '$id_aktivnosti'"; 
      

            $rezultat2=$conn->query($sql);
     
            if($rezultat2->num_rows > 0){
            while($red2 = $rezultat2->fetch_assoc()){

              echo '<div class="comment-box">
              <span class="commenter-pic">
                <img src="" class="img-fluid">
              </span>
              <span class="commenter-name">
                <a href="#">'.$ime.' '.$prezime.'</a> 
              </span>       
              <p class="comment-txt more">'.$red2["tekstKomentara"].'</p>
              
              <div class="comment-box add-comment reply-box">
                <span class="commenter-pic">
                  <img src="" class="img-fluid">
                </span>

              </div>';

            $id_kom=$red2["idKomentara"];
            $sql="SELECT * FROM odgovorkomentara WHERE odgovorkomentara.idKomentara = '$id_kom'"; 

            $rezultat3=$conn->query($sql);
     
            if($rezultat3->num_rows > 0){
            while($red3 = $rezultat3->fetch_assoc()){
              echo '<div class="comment-box replied">
              <span class="commenter-pic">
                <img src="" class="img-fluid">
              </span>
              <span class="commenter-name">
                <a href="#">Menadžer</a> 
              </span>       
              <p class="comment-txt more">'.$red3["tekstOdgovora"].'</p>
            </div>';
            }
          }
          echo '</div>';


      }
    }
    }

    }
    echo '
    <div class="comment-box add-comment">
                <span class="commenter-pic"></span>
                <span class="commenter-name">
                <form method="post" action="/comments/comments.php?idosobe='.$_SESSION['korisnik'].'&idprojekta='.$id_projekta.'&idaktivnosti='.$id_aktivnosti.'">
                  <input type="text" id="TekstKomentara" name="TekstKomentara" placeholder="Vaš komentar ovde...">
                  <button type="submit" class="btn btn-default" name="komentar" value="'.$id_aktivnosti. '">Komentariši</button>
                  <button type="cancel" class="btn btn-default">Cancel</button></form>
                </span>
              </div></div>
    </div>
  </div>
</div>';
  }
  else if ($_SESSION["potvrdjenpristup"] == true && $_SESSION['rola'] =='Menadžer'){ 
     $conn = OpenCon();
    $conn->query("SET NAMES 'utf8'");


    $sql="SELECT * FROM projekat JOIN aktivnosti ON projekat.idProjekta = aktivnosti.idProjekta JOIN dodeljeniprojekti ON dodeljeniprojekti.idAktivnosti=aktivnosti.idAktivnosti JOIN osoba ON dodeljeniprojekti.idOsobe=osoba.idOsobe WHERE projekat.idProjekta = '$id_projekta' AND aktivnosti.idAktivnosti ='$id_aktivnosti'"; 

    $rezultat=$conn->query($sql);

    $flegnaslov = 1;
    if($rezultat->num_rows > 0){
    while($red = $rezultat->fetch_assoc()){
      $ime = $red["ime"];
      $prezime = $red["prezime"];

      if($flegnaslov == 1){
        echo '<div id="">
        <section class="">
            <div class="container">
                <div class="">
                    <h1 class="naziv_projekta"> '.$red["nazivProjekta"].'</h1>
                    <div class="">
                        <h2 class="opis">'.$red["nazivAktivnosti"].'</h2>';
                  $sql2="SELECT statusAktivnosti FROM `dodeljeniprojekti` JOIN aktivnosti ON dodeljeniprojekti.idAktivnosti = aktivnosti.idAktivnosti JOIN projekat ON projekat.idProjekta = aktivnosti.idProjekta JOIN osoba ON dodeljeniprojekti.idOsobe = osoba.idOsobe WHERE aktivnosti.idAktivnosti = '$id_aktivnosti'"; // dodati WHERE dodeljeniprojekti.idOsobe = '$id'  
     
     $rezultat4=$conn->query($sql2);
     $faza=["Izrada", "U toku", "Završeno"];
 
     if($rezultat4->num_rows > 0){
     while($red4 = $rezultat4->fetch_assoc()){
         echo '<form method="post" action="/comments/comments.php?idosobe='.$_SESSION['korisnik'].'&idprojekta='.$id_projekta.'&idaktivnosti='.$id_aktivnosti.'"> <select id="statusAktivnosti" name="statusAktivnosti" disabled class="statusmali">';
         foreach($faza as $value){
             if($value == $red4["statusAktivnosti"]){
                 echo '<option value="'.$value.'" selected="selected">'.$value.'</option>';
             }
             else{
                echo '<option value="'.$value.'">'.$value.'</option>';
             }
         }
         echo '</select></form></div>';
     }
         }
                        echo '
                        <span class="opis_projekta">Opis: </span>
                            <p class="opis_projekta">'.$red["opisPosla"].'</p>
                    </div>
                </div>
            </div>
            
        </section>
    </div>';
    
    $flegnaslov=0;
      }

      echo '<div class="container">
        <div class="row">
          <div class="col-12">
            <div class="comments">';
      //$sql="SELECT * FROM komentar JOIN odgovorkomentara ON komentar.idKomentara = odgovorkomentara.idKomentara WHERE komentar.idAktivnosti = '$id_aktivnosti'"; 

      $sql="SELECT * FROM komentar WHERE komentar.idAktivnosti = '$id_aktivnosti'"; 
      

            $rezultat2=$conn->query($sql);
     
            if($rezultat2->num_rows > 0){
            while($red2 = $rezultat2->fetch_assoc()){

              echo '<div class="comment-box">
              <span class="commenter-pic">
                <img src="" class="img-fluid">
              </span>
              <span class="commenter-name">
                <a href="#">'.$ime.' '.$prezime.'</a> 
              </span>       
              <p class="comment-txt more">'.$red2["tekstKomentara"].'</p>
              
              <div class="comment-box add-comment reply-box">
                <span class="commenter-pic">
                  <img src="" class="img-fluid">
                </span>

              </div>';

            $id_kom=$red2["idKomentara"];
            $sql="SELECT * FROM odgovorkomentara WHERE odgovorkomentara.idKomentara = '$id_kom'"; 

            $rezultat3=$conn->query($sql);
     
            if($rezultat3->num_rows > 0){
            while($red3 = $rezultat3->fetch_assoc()){
              echo '<div class="comment-box replied">
              <span class="commenter-pic">
                <img src="" class="img-fluid">
              </span>
              <span class="commenter-name">
                <a href="#">Menadžer</a>
              </span>       
              <p class="comment-txt more">'.$red3["tekstOdgovora"].'</p>
            </div>';
            }
          }
          echo '
          <div class="comment-box add-comment">
                      <span class="commenter-pic"></span>
                      <span class="commenter-name">
                      <form method="post" action="/comments/comments.php?idosobe='.$_SESSION['korisnik'].'&idprojekta='.$id_projekta.'&idaktivnosti='.$id_aktivnosti.'">
                        <input type="text" id="Odgovor" name="Odgovor" placeholder="Vaš komentar ovde...">
                        <button type="submit" class="btn btn-default" name="odgovor" value="'.$id_kom. '">Komentariši</button>
                        <button type="cancel" class="btn btn-default">Cancel</button></form>
                      </span>
                    </div></div>';


      }
    }
    }

    }
    else{
      echo '<h1 style="text-align: center; padding-top:350px; padding-bottom:30px;">Trenutno ni jednom zaposlenom nije delegirana ova aktivnost.</h1>';
    }
    echo '</div>
    </div>
  </div>
</div>';
  }
  else{
    echo '<script>alert("aaa")</script>';
  }
    ?>


<div><form method=post action="/delegiranje.php?t=logout" style= "margin-left: 43%;">
<button class="button button3" name="logout" value="logout">Delegiraj ovu aktivnost</button>  
</form>
</div>

</body>
</html>