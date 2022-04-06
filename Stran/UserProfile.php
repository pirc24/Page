<?php 
	
	include('inc/function.php');
     include('inc/config.php');

    
	
checkLogin(); 

 if(!isset($_SESSION)) 
    {   
        //echo '<script>window.location="login.php"</script>';
        session_start(); 
    } 

?>

<!doctype html>
<html lang="en">
   
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link href="css\style.css" type="text/css" rel="stylesheet">


	<!---TINYMCE SCRIPT-->
	<script src="https://cdn.tiny.cloud/1/gp4ajjq3mcwn4fu3jptwtf2ef7ghnm9bqq92p7ktrxi3h0ex/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


	<title>PROFILE</title>

	<?php include('tpl/menu_header.php');?>

</head>

<body onload="zamsliko();">
	<?php
	if (!isset($_GET['idprofila'])) { 
	?>
    <!-- OSEBNI PROFIL -->
	<div class="container mx-auto justify-content-center">
		  
        <div class="row justify-content-center" id="conte">
            <button id="vaba" class="btn rounded-circle"></button>
            <img id="psli" src="<?php zamProf()?>" alt="mdo" class="rounded-circle">
            <div class="btn text-center" id="nasliki"></div>
        </div>
        <div class="row justify-content-center uporab" id="test"><?php echo $_SESSION['polnoime']; ?></div>
        <div class="row justify-content-center"><button class="btn btn-light btn-outline-dark btn-sm w-auto " id="gumbek">Zamenjaj profilno sliko</button></div>
        <div class="row justify-content-center"> 
             
             <div class="col-8"> <button class="gumbprij" id="prijatelji">Prijatelji  <?php if($steviloProsenj > 0){  ?> <p class="stprosn"><?php echo $steviloProsenj;?></p><?php } ?></button> </div>  
        </div>
        <div class="row justify-content-center" id="zamprof">
            <form class="justify-content-center text-center" method="post" enctype="multipart/form-data">
                <input class="form-control-sm" type="file" name="fileToUpload" id="fileToUpload formFile"><br>
                <input class="btn btn-light btn-outline-dark btn-sm mt-2" type="submit" value="Upload Image" name="submit">
                <?php profilna();
               ?>
                
            </form>
        </div>
	</div>
    <div id="userblogs" class="velikost container mx-auto justify-content-center">
        <?php
		vstaviBlog(array($_SESSION['userid']));
	    ?>
    </div>
    <!-- PROŠNJE ZA PRIJATELJSTVO <div class="prosnjezapr"></div> -->
    <div id="userfriends" class="velikost container mx-auto justify-content-center" style = "display:none">
        <div class="container" id="incomingFriendReq">Prošnje za prijateljstvo:
            <div class="row">
        <?php $prosnje = vstaviProsnje(); 
            $k=0;
            while($vrstica = mysqli_fetch_assoc($prosnje)){
                $podatkipros = getuserdata($vrstica['user_id']); 
                if($k==0){ ?>
            <div class="d-flex flex-row justify-content-center"> <?php } ?>

            
                <div class='card m-3' style='width: 13rem;'>
                 <img src="<?php echo $podatkipros['profileimg']; ?>" class='card-img-top' style='height: 13rem;' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'><?php echo $podatkipros['username'].' '.$podatkipros["priimek"];?></h5>
                        <button id="sprejmi<?php echo $vrstica['user_id']; ?>" class='sprejmi btn btn-light btn-outline-dark btn-sm t'>SPREJMI</button>
                        <button id="zavrzi<?php echo $vrstica['user_id']; ?>" class='zavrzi btn-danger'>X</button>
                    </div>
                </div>
          <?php  $k= $k+1;
                if($k==3){ ?> </div>
          <?php $k=0; }  
                } ?>  
    
            
          </div>  
        <div class="row"> PRIJATELJI:   <!-- PRIJATELJI -->
        <?php $prijatli = prijatelji(); 
            $i=0;
            //<!-- PRIKAZI PRIJATELJE IN IZPUSTI LOGGED USERJA -->
            while ($vrstica = mysqli_fetch_assoc($prijatli)){
                
                if($i==0){ ?>
                <div class="d-flex flex-row justify-content-center"> <?php }
                if ($vrstica['user_id'] != $_SESSION['userid']) {  $podprijatelj = getUserData($vrstica['user_id']); ?>
                   
                    <div class="card m-3" style='width: 13rem;' id="conte">
                        <button id="vaba" class="btn rounded-circle" onclick="povecava(this.id)"></button>
                        <img id="" src="<?php echo $podprijatelj['profileimg']?>" alt="mdo" class='card-img-top' style='height: 13rem;'>
                        <div class="card-body">
                            <h5 class="card-title row justify-content-center uporab" id="test"><?php echo $podprijatelj['username']." ".$podprijatelj[ 'priimek']; ?> </h5>
                        
                            <form class="row justify-content-center"method="get" action="UserProfile">
                                <button name="idprofila" class="btn btn-light btn-outline-dark btn-sm w-50" value="<?php echo $vrstica['user_id']; ?>">Poglej profil<?php echo $vrstica['user_id']; ?></button> 
                            </form>
                        
                        </div>
                        </div>
               <?php } 
                else if ($vrstica['friend_id'] != $_SESSION['userid']){  $podprijatelj = getUserData($vrstica['friend_id']);?>

                     <div class="card m-3" style='width: 13rem;' id="conte">
                        <button id="vaba" class="btn rounded-circle" onclick="povecava(this.id)"></button>
                        <img id="" src="<?php echo $podprijatelj['profileimg']?>" alt="mdo" class='card-img-top' style='height: 13rem;'>
                        <div class="card-body">
                            <h5 class="card-title row justify-content-center uporab" id="test"><?php echo $podprijatelj['username']." ".$podprijatelj[ 'priimek']; ?> </h5>
                        
                            <form class="row justify-content-center" method="get" action="UserProfile">
                                <button name="idprofila" class="btn btn-light btn-outline-dark btn-sm w-50" value="<?php echo $vrstica['friend_id']; ?>">Poglej profil<?php echo $vrstica['friend_id']; ?></button> 
                            </form>
                        
                        </div>
                        </div>
                        
         <?php } 
                $i= $i+1;
                if($i==3){ ?> </div>
         <?php  $i=0; }  
                } ?> 
       </div>        
    </div>
    </div>
	<?php } else { 
            $iduser = $_GET['idprofila'];
	        $podatkiUporabnik = getUserData($iduser);
            $preveripros = preveriprosnjo($iduser);
            $jeprijatu = jePrijatelj($iduser);
            ?>
    <!-- ISKALNI PROFILi -->
	<div class="container mx-auto justify-content-center">
		  
        <div class="row justify-content-center"><?php echo $podatkiUporabnik['username']; ?></div>
        <div class="row justify-content-center" id="conte">
            <button id="vaba" class="btn rounded-circle"></button>
            <img id="psli" src="<?php echo $podatkiUporabnik['profileimg']?>" alt="mdo" class="rounded-circle">
            <div class="btn text-center" id="nasliki"></div>
        </div>
        <div class="row justify-content-center uporab" id="test"><?php echo $podatkiUporabnik['username']." ".$podatkiUporabnik['priimek']; ?></div>
        <div class="row justify-content-center" id="zamprof">
            <form class="justify-content-center text-center" method="post" enctype="multipart/form-data">
                <input class="form-control-sm" type="file" name="fileToUpload" id="fileToUpload formFile"><br>
                <input class="btn btn-light btn-outline-dark btn-sm mt-2" type="submit" value="Upload Image" name="submit">
                <?php profilna(); ?>
            </form>
        </div>
        <?php $jeaktiv = preveriposlano($_SESSION['userid'], $podatkiUporabnik['id']); 
                if ($_SESSION['userid'] != $podatkiUporabnik['id']) { ?>
        <div class="row justify-content-center">
            <?php if($preveripros == false and !$jeprijatu){ ?>
            <button <?php echo $jeaktiv; ?> id="addfriend" class="btn btn-light btn-outline-dark btn-sm" style="width:15%" onclick="friendrequest(this.id ,<?php echo $_SESSION['userid'] ?>, <?php echo $podatkiUporabnik['id']; ?>)"> <?php if ($jeaktiv != "disabled"){ ?> DODAJ PRIJATELJA <?php } else{ ?> POSLANO </button> <?php } } else if($jeprijatu){ ?>
                
                <button id="odstrani<?php echo $podatkiUporabnik['id']; ?>" class='zavrzi btn btn-light btn-outline-dark btn-sm w-auto'>Odstrani prijatelja</button>
               <?php }
                
                else { ?>
            <button id='sprejmi<?php echo $iduser; ?>' class='sprejmi btn btn-light btn-outline-dark btn-sm w-50' style="width:15%"> SPREJMI </button>
        
        <?php }  ?></div> <?php } ?>
	</div>
    <!-- BLOGI USER -->
    
    <div id="userblogs" class="velikost container mx-auto justify-content-center">
        <?php
		vstaviBlog(array($podatkiUporabnik['id']));
	    ?>
    </div>
	<?php } ?>
    
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<script src="skript.js" crossorigin="anonymous" async></script>


</body>

<?php include('tpl/menu_footer.php');?>

</html>
