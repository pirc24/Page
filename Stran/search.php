<?php 
	
	include('inc/function.php');
     include('inc/config.php');
	
checkLogin();  //preveri ce je uporabnik prijavljen
 if(!isset($_SESSION)) //ce session ni narejen ga zacne
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


	<title>MOJLAJF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include('tpl/menu_header.php');?>

</head>
<body>
	<div class="velikost container justify-content-center">
        <p>ISKANJE: <?php echo " ".$_GET['isci']; ?> </p>
        
        <?php $ljudje = search($_GET['isci']); 
         $i=0;
         while (($vrstica = mysqli_fetch_assoc($ljudje))) {
            if($i == 3){$i=0;}
            if ($_SESSION['userid'] != $vrstica['id']) { 
                if($i==0){
                
        ?>
        <div class="d-flex flex-row justify-content-center"> <?php } ?>
            <div class="card m-3" style="width: 18rem;">
                <img src="<?php echo $vrstica['profileimg']; ?>" class="card-img-top" style="height: 18rem;" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $vrstica['username']; echo "&nbsp"; echo $vrstica['priimek'];?></h5>
                        <div ><?php $checkfrend = jePrijatelj($vrstica['id']); if($checkfrend){ ?> <b>PRIJATELJ</b> <?php } ?></div>
					<form method="get" action="UserProfile">
                            <button name="idprofila" class="btn btn-light btn-outline-dark btn-sm" value="<?php echo $vrstica['id']; ?>">Poglej profil</button> 
					</form>
                    </div>
            </div>
        <?php if($i==2){ ?> </div> <?php } ?>
        <?php $i++;  } } if($i == 1 or $i == 2){?> </div> <?php } ?>
        
	</div> 





	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<script src="skript.js" crossorigin="anonymous"></script>


</body>

<?php include('tpl/menu_footer.php');?>

</html>
