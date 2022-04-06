<?php include('inc/function.php');
      include('inc/config.php');

checkLogin();
if(!isset($_SESSION)) 
    {   
        
        session_start(); 
    } 
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet">
        <title>Prijava</title>
        
    </head>
    <body class=" mt-5">
    
    
        <div class="velikost container logi mt-5">
            <div class="row justify-content-center ">
                
                    <div class="col col-sm-5">
                        <form class="login" method="post">
                            
                            <div class="form-group">
                                <label for="UserName">Uporabniško ime</label>
                                <input type="text" class="form-control" id="UserName" aria-describedby="UserName" name="UserName" >
                            </div>
                            <div class="form-group">
                                <label for="Password">Geslo</label>
                                <input type="password" class="form-control" id="Password1" name="Password1">
                            </div>
                            
                            <input type="submit" value="LOGIN" name="Submit" class="btn btn-dark">
                            <?php login();?>
                        </form>
                    </div>
                    
                </div>
                <div class="col col-sm-5">Not a member yet? <a href=register> REGISTER </a></div>
            </div>
       
    <a href=index>home</a>

    <?php include('tpl/menu_footer.php');?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </body>
    
</html>
