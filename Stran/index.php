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


	<title>MOJLAJF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include('tpl/menu_header.php');?>

</head>
<body>
    
	<div class="velikost container" id="mainblogs">
		<?php 

	    	blogiPrijateljev(); //vstavi vse bloge od prijateljev
	       
	    ?>
        


	</div>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<script src="skript.js" crossorigin="anonymous"></script>


</body>

<?php include('tpl/menu_footer.php');?>

</html>
