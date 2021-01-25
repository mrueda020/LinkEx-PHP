<?php
    include_once 'conexion.php';
    session_start();
    if(isset($_SESSION["email"]))
	{
		session_destroy();
    }
    
    $ref=@$_GET['q'];
    if(isset($_POST['submit']))
	{	
        $email = $_POST['email'];
        $password = $_POST['password'];

        $email = stripslashes($email);
        $email = addslashes($email);
        $password = stripslashes($password); 
        $password = addslashes($password);

        $email = mysqli_real_escape_string($con,$email);
        $password = mysqli_real_escape_string($con,$password);
        
        $result = mysqli_query($con,"SELECT email FROM admin WHERE email = '$email' and password = '$password'") or die('Error');
        $count=mysqli_num_rows($result);
        if($count==1)
        {
            session_start();
            if(isset($_SESSION['email']))
            {
                session_unset();
            }
            $_SESSION["nombre"] = 'Admin';
            $_SESSION["key"] ='admin';
            $_SESSION["email"] = $email;
            header("location:admin.php?q=0");
        }
        else
        {
            echo "<center><h3><script>alert('Contraseña incorrecta');</script></h3></center>";
            header("refresh:0;url=login_admin.php");
        }
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>LinkEx Admin</title>

		    <link  rel="stylesheet" href="css/w3.css"/>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='https://css.gg/user-list.css' rel='stylesheet'>
		<link rel="stylesheet" href="css/form.css">
        <style type="text/css">
            body{
                  width: 100%;
                  background: white ;
                  background-position: center center;
                  background-repeat: no-repeat;
                  background-attachment: fixed;
                  background-size: cover;
                }
          </style>
	</head>

	<body>
<div class="w3-bar w3-black w3-border-bottom w3-xlarge">

<h2 class=" w3-right w3-bar-item w3-mobile">LinkEx</h2>
</div>
		<section class="login first grey w3-border-0">
			<div class="container w3-border-0">
				<div class="box-wrapper w3-border-0">				
					<div class="box box-border w3-border-0">
						<div class="box-body w3-border-0 w3-white">
						<center> <p class="w3-center"><img src="image/lock.png" class="w3-circle" alt="Avatar"></p>
						<h4 style="font-family: Calibri;">Iniciar Sesion</h4></center>
							<form method="post" action="login_admin.php" enctype="multipart/form-data">
								<div class="form-group w3-round">
									<label style="font-family: Calibri;">Email</label>
									<input style="font-family: Calibri; font-size: medium " type="email" name="email" placeholder="Email" class="w3-input w3-round w3-border-blue">
								</div>
								<div class="form-group w3-round">
									<label class="fw" style="font-family: Calibri;">Contraseña:
									</label>
									<input style="font-family: Calibri; font-size: medium" type="password" name="password" placeholder="Contraseña" class="w3-input w3-round w3-border-blue">
								</div> 
								<div class="input-block w3-border-0">
									<button class="w3-button w3-indigo w3-block w3-round " name="submit">Iniciar Sesion</button>
									
								</div>
								<center><p style="font-family: Calibri; font-size:small">Copyright @LinkEx 2021</p></center>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>

		<script src="js/jquery.js"></script>
		<script src="scripts/bootstrap/bootstrap.min.js"></script>
	</body>
</html>