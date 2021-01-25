<?php
    include_once 'conexion.php';
    session_start();
    if(!(isset($_SESSION['email'])))
    {
        header("location:login.php");
    }
    else
    {
        $nombre = $_SESSION['name'];
        $email = $_SESSION['email'];
        include_once 'conexion.php';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bienvenido</title>
    <link  rel="stylesheet" href="css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
    <link rel="stylesheet" href="css/welcome.css">
    <link  rel="stylesheet" href="css/font.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"  type="text/javascript"></script>
</head>
<body>
    <nav class="navbar navbar-default title1">
        <div class="container-fluid">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        <a class="navbar-brand" href="#"><b>LinkEx</b></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left">
			<li <?php if(@$_GET['q']==0) echo'class="active"'; ?>><a href="usuario.php?q=0">Inicio<span class="sr-only">(current)</span></a></li>
            <li <?php if(@$_GET['q']==1) echo'class="active"'; ?> ><a href="usuario.php?q=1">&nbsp;Examenes<span class="sr-only">(current)</span></a></li>
            <li <?php if(@$_GET['q']==2) echo'class="active"'; ?>> <a href="usuario.php?q=2"></span>&nbsp;Calificaciones</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
        <li <?php echo''; ?> > <a href="logout.php?q=usuario.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Salir</a></li>
        </ul>
        
            
           
       
        </div>
    </div>
    </nav>
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
				<?php if(@$_GET['q']==0)
					{
					}
                ?>
                <?php if(@$_GET['q']==1) 
                {
                    $result = mysqli_query($con,"SELECT * FROM examen ORDER BY fecha DESC") or die('Error');
                    echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
                    <tr><td><center><b>Examen</b></center></td><td><center><b>Tema</b></center></td><td><center><b>Calificacion</center></b></td><td><center><b>Accion</b></center></td></tr>';
                    $c=1;
                    while($row = mysqli_fetch_array($result)) {
                        $tema = $row['tema'];
                        $total = $row['total'];
                        $respuestaCorrecta = $row['respuestaCorrecta'];
						$tipoexamen = $row['tipoExamen'];
                        $idExamen = $row['idExamen'];
                    $q12=mysqli_query($con,"SELECT calificacion FROM calificacion WHERE idExamen='$idExamen' AND email='$email'" )or die('Error98');
                    $rowcount=mysqli_num_rows($q12);	
                    if($rowcount == 0){
                        echo '<tr><td><center>'.$c++.'</center></td><td><center>'.$tema.'</center></td><td><center>-</center></td><td><center><b><a href="usuario.php?q=examen&step=2&idExamen='.$idExamen.'&n=1&t='.$total.'" class="btn sub1" style="color:black;margin:0px;background:#1de9b6"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Iniciar Examen</b></span></a></b></center></td></tr>';
                    }
                    else
                    {
						if($tipoexamen==1)
							echo '<tr style="color:#99cc32"><td><center>'.$c++.'</center></td><td><center>'.$tema.'&nbsp;<span tema="ExamenResuelto" class="glyphicon glyphicon-ok" aria-hidden="true"></span></center></td><td><center>'.$respuestaCorrecta*$total.'</center></td><td><center><b><a href="examen.php?q=examenre&step=25&idExamen='.$idExamen.'&n=1&t='.$total.'" class="pull-right btn sub1" style="color:black;margin:0px;background:red"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Repetir Examen</b></span></a></b></center></td></tr>';
						else
							echo '<tr style="color:#99cc32"><td><center>'.$c++.'</center></td><td><center>'.$tema.'&nbsp;<span tema="ExamenResuelto" class="glyphicon glyphicon-ok" aria-hidden="true"></span></center></td><td><center>'.$respuestaCorrecta*$total.'</center></td><td><center><b>Examen Contestado</b></center></td></tr>';

						
					}
                    }
                    $c=0;
                    echo '</table></div></div>';
                }?>

                <?php
                    if(@$_GET['q']== 'examen' && @$_GET['step']== 2) 
                    {
                        $idExamen=@$_GET['idExamen'];
                        $numeroPregunta=@$_GET['n'];
                        $total=@$_GET['t'];
                        $q=mysqli_query($con,"SELECT * FROM pregunta WHERE idExamen='$idExamen' AND numeroPregunta='$numeroPregunta' " );
                        echo '<div class="panel" style="margin:5%">';
                        while($row=mysqli_fetch_array($q) )
                        {
                            $pregunta=$row['pregunta'];
                            $idPregunta=$row['idPregunta'];
                            echo '<b>Pregunta &nbsp;'.$numeroPregunta.'&nbsp;::<br /><br />'.$pregunta.'</b><br /><br />';
                        }
                        $q=mysqli_query($con,"SELECT * FROM incisos WHERE idPregunta='$idPregunta' " );
                        echo '<form action="examen.php?q=examen&step=2&idExamen='.$idExamen.'&n='.$numeroPregunta.'&t='.$total.'&idPregunta='.$idPregunta.'" method="POST"  class="form-horizontal">
                        <br />';

                        while($row=mysqli_fetch_array($q) )
                        {
                            $opciones=$row['opciones'];
                            $idOpciones=$row['idOpciones'];
                            echo'<input type="radio" name="ans" value="'.$idOpciones.'">&nbsp;'.$opciones.'<br /><br />';
                        }
                        echo'<br /><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;Contestar</button></form></div>';
                    }

                    if(@$_GET['q']== 'result' && @$_GET['idExamen']) 
                    {
                        $idExamen=@$_GET['idExamen'];
                        $q=mysqli_query($con,"SELECT * FROM calificacion WHERE idExamen='$idExamen' AND email='$email' " )or die('Error157');
                        echo  '<div class="panel">
                        <center><h1 class="title" style="color:#000000">Resultado</h1><center><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';

                        while($row=mysqli_fetch_array($q) )
                        {
                            $s=$row['calificacion'];
                            $w=$row['tipoExamen'];
                            $r=$row['respuestaCorrecta'];
                            $qa=$row['cantidadPregunta'];
                            echo '<tr style="color:#000000"><td>Numero de Preguntas</td><td>'.$qa.'</td></tr>
                                <tr style="color:#99cc32"><td>Respuestas Correctas&nbsp;<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></td><td>'.$r.'</td></tr> 
                                <tr style="color:red"><td>Respuestas Erroneas&nbsp;<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></td><td>'.$w.'</td></tr>
                                <tr style="color:#66CCFF"><td>Calificacion&nbsp;</td><td>'.$s.'</td></tr>';
                        }
                        
                    }
                ?>

                <?php
                    if(@$_GET['q']== 2) 
                    {
                        $q=mysqli_query($con,"SELECT * FROM calificacion WHERE email='$email' ORDER BY fecha DESC " )or die('Error197');
                        echo  '<div class="panel title">
                        <table class="table table-striped title1" >
                        <tr style="color:black;"><td><center><b>Examen</b></center></td><td><center><b>Tema</b></center></td><td><center><b>Preguntas</b></center></td><td><center><b>Respuestas Correctas</b></center></td><td><center><b>Respuestas Erroneas<b></center></td><td><center><b>Calificacion</b></center></td>';
                        $c=0;
                        while($row=mysqli_fetch_array($q) )
                        {
                        $idExamen=$row['idExamen'];
                        $s=$row['calificacion'];
                        $w=$row['tipoExamen'];
                        $r=$row['respuestaCorrecta'];
                        $qa=$row['cantidadPregunta'];
                        $q23=mysqli_query($con,"SELECT tema FROM examen WHERE  idExamen='$idExamen' " )or die('Error208');

                        while($row=mysqli_fetch_array($q23) )
                        {  $tema=$row['tema'];  }
                        $c++;
                        echo '<tr><td><center>'.$c.'</center></td><td><center>'.$tema.'</center></td><td><center>'.$qa.'</center></td><td><center>'.$r.'</center></td><td><center>'.$w.'</center></td><td><center>'.$s.'/'.$qa.'</center></td></tr>';
                        }
                        echo'</table></div>';
                    }

                   
                ?>
</body>
</html>