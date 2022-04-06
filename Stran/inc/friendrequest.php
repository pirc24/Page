<?php 

//STRAN ZA RAZLIČNE FUKNCIJE V POVEZAVI Z SCRIPTOM 

if(!isset($_SESSION)) 
    {   
        //echo '<script>window.location="login.php"</script>';
        session_start(); 
    }
include('dbcon.php');

if ($_POST["action"]=='requestfriends'){ //VSTAVI prošnjo za prijateljstvo v bazo
$db = dbConnect();
$userid = $_POST['userid'];
$friendid = $_POST['friendid'];

//vstavi v tabelo
$friendreq = mysqli_query($db, "INSERT INTO friendrequest (user_id, friend_id, active) VALUES('$userid','$friendid', '1')");
mysqli_close($db);
}


if ($_POST["action"]=='incomingFriendReq'){ //izpiše prošnje za prijateljstvo.
    $db = dbConnect();
    //FRIEND id je priavljen uporabnik, user id so prošnje  
    $prosnje = mysqli_query($db, "SELECT user_id FROM friendrequest WHERE friend_id=".$_SESSION['userid']." AND accepted=0");
    
    while($vrstica = mysqli_fetch_assoc($prosnje)){
        $podatki = mysqli_query($db, "SELECT id, username, priimek, profileimg FROM users WHERE id = ".$vrstica['user_id']);
        $podatkipros = mysqli_fetch_assoc($podatki);
        echo "<div>".$vrstica['user_id']."</div>";
        echo "<div class='d-flex flex-row justify-content-center'>
                <div class='card m-3' style='width: 18rem;'>
                 <img src=".$podatkipros['profileimg']." class='card-img-top' style='height: 18rem;' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>".$podatkipros['username'].' '.$podatkipros["priimek"]."</h5>
                        <button id=".$vrstica['user_id']." class='sprejmi btn btn-primary'>SPREJMI</button>
                        <button id=".$vrstica['user_id']." class='zavrzi btn-danger'>X</button>
                    </div>
            </div>";
            
    }
    mysqli_close($db);
    
}

// ČE UPORABNIK SPREJME PROŠNJO ZA PRIJATELJSTVO, DODAJ KOT PRIJATELJA
if ($_POST["action"]=='acceptFriendReq'){
    $db = dbConnect();
    
    
    $sprejetocelo = $_POST['sprejeto'];
    $sprejeto = preg_replace('/[^0-9]/', '', $sprejetocelo); 
    
    mysqli_query($db, "UPDATE friendrequest SET accepted = '1' WHERE friend_id=".$_SESSION['userid']." AND user_id=".$sprejeto);
    mysqli_close($db);
    
    
} 

    //če uporabnik zavrne prosnjo
    
if ($_POST["action"]=='denyFriendReq'){
    $db = dbConnect();
    
    $zavrnjenocelo = $_POST['zavrnjeno'];
    $zavrnjeno = preg_replace('/[^0-9]/', '', $zavrnjenocelo); 
    
    
    mysqli_query($db, "DELETE FROM friendrequest WHERE (friend_id=".$_SESSION['userid']." AND user_id=".$zavrnjeno.") OR (user_id=".$_SESSION['userid']." AND friend_id=".$zavrnjeno.")");
    mysqli_close($db);
    
    
}

if ($_POST["action"] == 'deliteBlog'){  //FUKNCIJA ZA IZBRIS BLOGA iz baze
        $db = dbConnect();
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $blogDeliteidc = $_POST['deliteBlogId'];
        $blogDeliteId = preg_replace('/[^0-9]/', '', $blogDeliteidc);
        mysqli_query($db, "DELETE FROM blog WHERE id =".$blogDeliteId);
        mysqli_close($db);
        
        
        
    }

    if ($_POST["action"] == 'editBlog'){ //funkcija za ureditev bloga
        $db = dbConnect();
        
        $blogEditidc = $_POST['editBlogId'];
        $blogEditId = preg_replace('/[^0-9]/', '', $blogEditidc);
        
        $selectedblog = mysqli_query($db, "SELECT Blog FROM blog WHERE id =".$blogEditId);
        mysqli_close($db);
        echo urldecode(mysqli_fetch_assoc($selectedblog)["Blog"]);
        
    }

    if($_POST["action"] == "objaviEditBlog"){ //funkcija za objavo urejenega bloga
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $db = dbConnect();
        $zamenjajBlog = $_POST['editidb'];
        $zamBlog = preg_replace('/[^0-9]/', '', $zamenjajBlog);
        
    
        $sprememba = (isset($_POST['spremembe']) && !empty($_POST['spremembe'])) ? filter_input(INPUT_POST, 'spremembe', FILTER_SANITIZE_ENCODED) : null;
        
        echo $sprememba;
        
        mysqli_query($db, "UPDATE blog SET Blog = '".$sprememba."' WHERE id = ".$zamBlog);
        mysqli_close($db);
       
        
    }

    if($_POST["action"] == "lajked"){ //funkcije se izvede ob kliku na like gumb
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $lajk = preg_replace('/[^0-9]/', '', $_POST["idlajka"]);
        $db = dbConnect();
        //echo "TESTSTSTSTST";
        $vsilajki = fopen("VsiLajki.txt", "a") or die("Ne morem odpreti datoteke");
        fwrite($vsilajki, $lajk."-".$_SESSION['userid'].",");
        fclose($vsilajki);
        
        mysqli_query($db, "UPDATE blog SET likecount = likecount + 1 WHERE id =".$lajk);
        mysqli_close($db);
        
    }

    if($_POST["action"] == "unlajk"){ //funkcija za odstranitev všečka
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $lajk = preg_replace('/[^0-9]/', '', $_POST["idlajka"]);
        $db = dbConnect();
        //echo "TESTSTSTSTST";
        $vsilajki = fopen("VsiLajki.txt", "r") or die("Ne morem odpreti datoteke");
        $vsilajkistring = fread($vsilajki, filesize("VsiLajki.txt"));
        fclose($vsilajki);
        $zamenjaj = ($lajk."-".$_SESSION['userid'].",");
        $vsilajkistring2 = str_replace($zamenjaj,"",$vsilajkistring);
        
        echo $vsilajkistring;
        echo $vsilajkistring2;
        
        $vsilajki2 = fopen("VsiLajki.txt", "w") or die("Ne morem odpreti datoteke");
        fwrite($vsilajki2, $vsilajkistring2);
        fclose($vsilajki2);
        
        mysqli_query($db, "UPDATE blog SET likecount = likecount - 1 WHERE id =".$lajk);
        mysqli_close($db);
    }
