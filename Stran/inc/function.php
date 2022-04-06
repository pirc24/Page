<?php

include('dbcon.php');


function register() { //FUNKCIJA ZA REGISTRACIJO NOVEGA UPROABNIKA
    $db = dbConnect(); //POVEZAVA Z BAZO
    global $url;
    $username = (isset($_POST['UserName']) && !empty($_POST['UserName'])) ? filter_input(INPUT_POST, 'UserName', FILTER_SANITIZE_ENCODED) : null;
    $priimek = (isset($_POST['Priimek']) && !empty($_POST['Priimek'])) ? filter_input(INPUT_POST, 'Priimek', FILTER_SANITIZE_ENCODED) : null;
    $password1 = (isset($_POST['Password1']) && !empty($_POST['Password1'])) ? filter_input(INPUT_POST, 'Password1', FILTER_SANITIZE_ENCODED) : null; 
    $password2 = (isset($_POST['Password2']) && !empty($_POST['Password2'])) ? filter_input(INPUT_POST, 'Password2', FILTER_SANITIZE_ENCODED) : null; 
    $profilimg = "img/profilepics/default.png"; //OB REGISTRACIJI SE DOLOČI PRIVZETA PROFILNA SLIKA, KI SE LAHKO SPPREMENI KASNEJE
     
    
    
    
    echo $username;
    $ze="SELECT * FROM users WHERE username='$username'  LIMIT 1";
    
    $rezu = (mysqli_query($db, $ze));
    $seznam = array ($rezu); //seznam uporabnika
    $upor = mysqli_fetch_assoc($rezu);
    
    
    if ($upor) { // if user exists, javi da je uporabnik že v bazi.. Gleda samo username (ime)
    if ($upor['username'] == $username) {
      echo '<script>alert("Uporabnik že obstaja!")</script>';
    
    }

    
  } else{
    
    
    if($password1 == $password2){ //PREVERI če je uporabnik vnesel geslo pravilno
   
    if (isset($_POST['Submit'])) {
        
        if(!in_array($username, $seznam)){
        
                
        $pass = password_hash($password1, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, priimek, password, profileimg) VALUES('$username','$priimek', '$pass', '$profilimg')";
        
        if (mysqli_query($db, $sql)){ //doda novega uporabnika v bazo in preusmeri v login page.
            echo '<script>alert("SUCCES! YOU MAY LOGIN NOW!")</script>';
            echo '<script>window.location="login"</script>';
        }
        else {echo "NEDELA";}

        // get id of the created user			
     }
        else{echo '<script>alert("JE ZE NOT!")</script>';}
    }
    
    }
    else{echo '<script>alert("GESLI SE NE UJEMATA")</script>';}
    mysqli_close($db);
    }
    //$_SESSION['profilna'] = "img/profilepics/defaul.png";
    //profilna("img/profilepics/defaul.png");
}
function login() { //Funkcija za prijavo v spletno stran
    global $url;
    global $login;
    $db = dbConnect(); 
    $UserName = (isset($_POST['UserName']) && !empty($_POST['UserName'])) ? filter_input(INPUT_POST, 'UserName', FILTER_SANITIZE_ENCODED) : null;
    $Password = (isset($_POST['Password1']) && !empty($_POST['Password1'])) ? filter_input(INPUT_POST, 'Password1', FILTER_SANITIZE_ENCODED) : null;
    
    
    $_SESSION['user'] = $UserName; 

    if(isset($_POST['Submit'])){ //ob kliku na gumb SUBMIT, se preveri če je geslo in uporabniško ime pravilno
        
        $sql= "SELECT UserName, password FROM users WHERE UserName= '".$UserName."' limit 1";
        //echo $sql;
        
        $result=mysqli_query($db, $sql);
        $gesl = mysqli_fetch_array($result);
        if($UserName==$login['UserName'] && $Password == $login['Password']){
            $_SESSION['Login'] = true;
             echo '<script>window.location="admin"</script>';
            
        }
        else if(mysqli_num_rows($result)==1 and password_verify($Password, $gesl['password'])){ //Gleda če je iz baze sploh kaj vzel, če je potem še preveri, če je pravilno geslo.
            $findUserID = mysqli_query($db, "SELECT id, priimek FROM users WHERE UserName = '".$UserName."'"); 
            
            $idpriimek = mysqli_fetch_array($findUserID);
            $userid = $idpriimek[0];
            $priimek = $idpriimek[1];
            
            $_SESSION['userid'] = $userid;
            $_SESSION['polnoime'] = $_SESSION['user'] .' '. $priimek; //to spremenit 
            $_SESSION['Login'] = true;
            echo '<script>window.location="index"</script>';
             
             
        }
        else{
            echo "Napačno geslo ali uporabniško ime!";
        }
    }
    
   
}

function checkLogin() { // funkcija za preverjanje prijave v sistemu
    global $url;

    $CheckLogin = (isset($_SESSION) && isset($_SESSION['Login'])) ? true : false;

    $CurrentUri = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : null;

    if($CheckLogin) { // sem prijavljen
        if(strpos($CurrentUri, $url['Login']) == true) { // preverim ce se nahajam na strani login, preusmerim na admin
            //header("Location: {$url['index']}");
           
        }
    }
    if(!$CheckLogin && strpos($CurrentUri, $url['Login']) == false){ //if login in session is not set
    header("Location: {$url['Login']}");
        }
    }


function blog() {   //DODAJ BLOG V BAZO PODATKOV
    $db = dbConnect();
    $blog = (isset($_POST['blog']) && !empty($_POST['blog'])) ? filter_input(INPUT_POST, 'blog', FILTER_SANITIZE_ENCODED) : null;
    $private = (isset($_POST['private']));
    $userid = $_SESSION['userid'];
    
    
    if(isset($_POST['Submit'])){ //Ko uporabnik klikne na gumb OBJAVI BLOG, se podatki dodaj v bazo podatkov.

    $vstavi = "INSERT INTO blog (Blog, userid, isprivate) VALUES('$blog', '$userid', '$private')"; //v bazo se doda blog, id userja, ali je blog privaten in še datum... 
    $neki= mysqli_query($db, $vstavi);
    echo '<script>window.location="index"</script>'; //Stran se osveži.

    }
    
    
    mysqli_close($db);
}


function vstaviBlog($iduporabnika){        //vtavi vse bloge od uporabnika/ov v stran
    $db = dbConnect();
    echo '<div class="dropdown filter">
            <form action="" method="GET">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Filter</button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><button type="submit" name="bydate1" class="dropdown-item" href="#">Datum, novejši najprej</button></li>
                <li><button type="submit" name="bydate2" class="dropdown-item" href="#">Datum, starejši najprej</button></li>
                <li><button type="submit" name="bylike" class="dropdown-item" href="#">Po številu všečkov</button></li>
            </ul>
            </form>
          </div>';
    //izberi podatke iz tabele BLOG in SORTIRANJE PO DATUMU ali številu všečkov
    if(isset($_GET["bydate2"])){   
        $blogi = mysqli_query($db, "SELECT * from blog ORDER BY Date ASC"); 
    }
    else if(isset($_GET["bylike"])){
        $blogi = mysqli_query($db, "SELECT * from blog ORDER BY likecount DESC"); 
    }
    else{
    $blogi = mysqli_query($db, "SELECT * from blog ORDER BY Date DESC");
    }
     
    $i = 1;
    $ids = array();
    //Lajki se zapisujejo v datoteko in nato se iz datoteke prebere kdo je všečkal kateri blog.
    $vsilajki1 = fopen("inc/VsiLajki.txt", "r") or die("Ne morem odpreti datoteke");
    $vsilajkistring = fread($vsilajki1, filesize("inc/VsiLajki.txt"));
   
    
    
    while (($vrstica = mysqli_fetch_assoc($blogi))) { //zanka, ki gre čez vse bloge
        $islike = strpos($vsilajkistring, ($vrstica['id']."-".$_SESSION['userid'])); //Če je prijavljen uporabnk, lajkav določen blog
        $i++;
        
        if(in_array($vrstica['userid'], $iduporabnika)){ //Ali je blog od uporabnika, ki je v seznamu uporabnikov, za vpis bloga v stran
            
            $userdata = getUserData($vrstica['userid']); //funkcija, ki pridobi podatke o uporabniku
            
            if($vrstica['isprivate'] == false or $_SESSION['userid'] == $vrstica['userid']){ //če blog ni private ali pa če je vpisan lastnik bloga
                
                
            echo "<div class='bloger col-sm-auto'> <form method='get' action='UserProfile'> <button name='idprofila' value=".$vrstica['userid']." class='btn lastnik border-bottom mb-3 ";
                if ($_SESSION['userid'] == $vrstica['userid']){ echo "unclickable'";} else echo "'"; echo "> <img src=".$userdata["profileimg"]." width='40' height='40'> ".$userdata["username"]." ".$userdata["priimek"]."</button> </form>";
            echo urldecode ("".$vrstica['Blog']."");
            
            if($islike){ //če je všekano potem, potem obarva gumb za like v črno
                echo "<div class='border-top w-auto lajkw' id='ajk".$vrstica['id']."'><button class='btn like' id='lajk".$vrstica['id']."'><img class='lajkpot' src='assets/lajk1.svg'></button> ";
            }
            else { //če ni všečkano potem je bel gumb
                echo "<div class='border-top w-auto lajkb' id='ajk".$vrstica['id']."'><button class='btn like' id='lajk".$vrstica['id']."'><img class='lajkpot' src='assets/lajk0.svg'></button>";
            }
            if($vrstica['likecount'] > 0)  { //če je vsaj 1 všeček pokaži število všečkov
            echo "<span id='jk".$vrstica['id']."' class='likecount'>".$vrstica['likecount']."</span> ";}
            
            if ($_SESSION['userid'] == $vrstica['userid']){ //če je lastnik bloga, lahko ureja in briše blog
            echo "<button class='btn edit-blog ' id=edit".$vrstica['id']."> Urejanje</button>
                  <button class='btn delite-blog ' id=delite".$vrstica['id']."> Izbriši blog</button>";
                
                }
            echo "</div> </div>";
            
                }
            }
    }
         
    mysqli_close($db);
}

function profilna(){ //funkcija za zamenjavo profilne slike
date_default_timezone_set('UTC'); //določi se časovni pas, da se doda k imenu slike.
$datum = date("h:i:sa");
//UPLOAD NA SERVER IN DODAJANJE V DATABASE
if(isset($_POST["submit"])) { 
$target_dir = "img/profilepics/"; //pot kamor se bodo profilne slike shranile
$target_file = $target_dir . str_replace(' ', '', basename($_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Pogleda če je slika res slika

  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }



// Preveri, da velikost slike ni prevelika
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

//Dovoli samo določene formate
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Če je nekaj narobe javi
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// Če je vse ok potem naloži sliko
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      $_SESSION['profilna'] = $target_file;  //NASTAVI SE POT DO SLIKE, KI SE JO NATO DODA V DATABASE
      //echo '<script>console.log("'.$_SESSION['profilna'].'")</script>';
     // echo '<script>console.log("eqweqweqw")</script>';
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
    //DODAJANJE V DATABASE
   //$profilna = $_SESSION['profilna'];
    $userid2 = $_SESSION['userid'];
    echo '<script>console.log("asd")</script>';
    echo '<script>console.log('.$userid2.')</script>';

    //echo '<script>console.log('.$profilna.')</script>';
    $db = dbConnect();
    
    $vstaviProf = mysqli_query($db, "UPDATE users SET profileimg = '".$_SESSION['profilna']."' WHERE id = ".$userid2);
    echo '<script>window.location="UserProfile"</script>';
    
    
      }
    
}

function zamProf() {
    //ZAMENJAJ OBSTOJEČO SLIKO Z NOVO
    $userid = $_SESSION['userid'];
    $db = dbConnect();
    echo mysqli_fetch_assoc(mysqli_query($db, "SELECT profileimg from users WHERE id = ".$userid))['profileimg']; //izberi pot slike 
    mysqli_close($db);
    
}

function search($iskalnik) { //ISKANJE UPORABNIKOV
    $db = dbConnect();
    $ljudje = mysqli_query($db, "SELECT id, username, priimek, profileimg FROM users WHERE username LIKE '%".$iskalnik."%' OR priimek LIKE '%".$iskalnik."%'");
    
    return $ljudje;
    mysqli_close($db);
}

function getUserData($iduporabnika) {//Funkcija vrne podatke o uporabniku
	$db = dbConnect();
	//echo $iduporabnika;
	$userdata = mysqli_query($db, "SELECT id, username, priimek, profileimg FROM users WHERE id = ".$iduporabnika);
	
	return mysqli_fetch_assoc($userdata);
    mysqli_close($db);
}

function preveriposlano($user, $friend){ //Preveri če je bila prošnja za prijateljstvo že poslana.
    $db = dbConnect();
    $poizvedba = mysqli_query($db, "SELECT active FROM friendrequest WHERE user_id=".$user." AND friend_id=".$friend);
    $isactive = mysqli_fetch_assoc($poizvedba);
    if (null != $isactive and $isactive['active'] == 1){
        mysqli_close($db);
        return "disabled";
    }
    else{mysqli_close($db); return "";}
}

function vstaviProsnje(){ //friend_id= logged user, vrni prosnje za prijateljstvo.
    
    $db = dbConnect();
   
    $prosnje = mysqli_query($db, "SELECT user_id FROM friendrequest WHERE friend_id=".$_SESSION['userid']." AND accepted=0");
    
    mysqli_close($db);  
    return $prosnje;
}

function prijatelji(){ //Funkcija vrne vse prijatelje prijavljenega uporabnika
    
    $db = dbConnect();
    $prijatelji = mysqli_query($db, "SELECT user_id, friend_id FROM friendrequest WHERE (friend_id=".$_SESSION['userid']." OR user_id =".$_SESSION['userid'].") AND accepted = 1");
    echo '<script>console.log("'.$_SESSION['userid'].'")</script>';
    mysqli_close($db);
    return $prijatelji;
}

function preveriprosnjo($sender){ //preveri ce je prosnja ze poslana, da ne moreta dodat drug drucga
    $db = dbConnect();
    $prosnje = mysqli_query($db, "SELECT user_id FROM friendrequest WHERE friend_id =".$_SESSION['userid']);
    
    while ($vrstica = mysqli_fetch_assoc($prosnje)) {
    if($vrstica["user_id"]==$sender){return true;}}
    mysqli_close($db);
    
}

function jePrijatelj($checkid){ //funckija preveri če je uporabnik prijatelj
    $db = dbConnect();
    $isFrend = mysqli_query($db, "SELECT user_id, friend_id FROM friendrequest WHERE (friend_id =".$_SESSION['userid']." OR user_id= ".$_SESSION['userid'].") AND (friend_id =".$checkid." OR user_id= ".$checkid.") AND accepted = 1");
    
    while($vrstica = mysqli_fetch_assoc($isFrend)){
        return true;
    }
    mysqli_close($db);
}


function blogiPrijateljev(){  //izpiši bloge prijateljev na začetno stran
    
    $prijatl = prijatelji();
    $frendi = [];
    while ($vrstica = mysqli_fetch_assoc($prijatl)){
        
        if ($vrstica['user_id'] != $_SESSION['userid']) {
            
            array_push($frendi, $vrstica['user_id']);
        }
        else if ($vrstica['friend_id'] != $_SESSION['userid']){
            
            array_push($frendi, $vrstica['friend_id']);
        }
    }
    
    vstaviBlog($frendi);
    
        
}



?>
