<?php
    include_once 'conexion.php';
    session_start();
    if(!(isset($_SESSION['email'])))
    {
        header("location:login.php");
    }
    else
    {
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];
        include_once 'conexion.php';
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrador</title>
    <link  rel="stylesheet" href="css/w3.css"/>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='https://css.gg/user-list.css' rel='stylesheet'>
    <link  rel="stylesheet" href="css/test.css"/>

    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"  type="text/javascript"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">

</head>
<style>
.w3-lobster {
  font-family: Lobster, cursive;
}
.tabulacion:first-letter {
	margin-left: 25px;
}
.alto{
	
	height:600px;
}
</style>

<body class="w3-theme-l5" background="image/fondo3.png">

<div class="w3-bar w3-black w3-border-bottom w3-xlarge">

<h2 class="w3-lobster w3-right w3-bar-item w3-mobile">LinkEx</h2>
</div>
   
<div class="w3-container w3-content" style="max-width:1920px">    

  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile -->
	  <br/>
      <div class="w3-card w3-round w3-white ">
        <div class="w3-container w3-round">
         <h2 class="w3-center">Bienvenido</h2>
         <p class="w3-center"><img src="image/pro.png" class="w3-circle" style="height:106px;" alt="Avatar"></p>
         <hr>
        </div>
      </div>
      <br>

      <!-- Accordion -->
      <div class="w3-card w3-round ">
        <div class="w3-white w3-round"><h4>
		<br/>
		 <p class="tabulacion">Menu Principal</p>
          <a href="admin.php?q=0"class="w3-button w3-block w3-hover-blue w3-left-align"><i class="fa fa-home fa-fw w3-margin-right"></i><?php if(@$_GET['q']==0) ?>Inicio</a>

          <?php if(@$_GET['q']==1) ?><a href="admin.php?q=1" class="w3-button w3-block w3-hover-blue w3-left-align"><i class="fa fa-male fa-fw w3-margin-right"></i>Gestionar Usuarios</a>

         <a href="admin.php?q=4" class="w3-button w3-block  w3-hover-blue w3-left-align"><i class="fa fa-book fa-fw w3-margin-right"></i>Crear Examen</a>
		 
		 <a href="admin.php?q=5" class="w3-button w3-block  w3-hover-blue w3-left-align"><i class="fa fa-remove fa-fw w3-margin-right"></i>Eliminar Examen</a>
		 <?php echo''; ?> <a href="logout1.php?q=admin.php" class="w3-button w3-block w3-hover-blue w3-left-align"><i class="fa fa-arrow-left fa-fw w3-margin-right"></i>&nbsp;Salir</a>
		 </h4>
          </div>
        </div>      
      </div>
      <br>
      

    <div class="w3-col m7 w3-border-0">
    
      <div class="w3-row-padding w3-border-0">
        <div class="w3-col m12 w3-border-0">
          <div class="w3-card w3-round w3-white w3-border-0">
            <div class="w3-container w3-padding w3-border-0">
              <div class="w3-col m12 w3-border-0">
                <?php if(@$_GET['q']==0)
                {
                   echo '<div class="w3-container w3-blue w3-border-0 "> <h2>Bienvenido</h2></div>
				   <p class="w3-center alto"><img src="image/logo.png" style="height:512px;" class="w3-circle" alt="Avatar"></p>
				   ';
                }
                ?>
                <?php 
                    if(@$_GET['q']==1) 
                    {
                        $result = mysqli_query($con,"SELECT * FROM evaluado") or die('Error');
                        echo  '<div class="w3-container w3-blue w3-border-0"> <h2><i class="fa fa-male"></i> Gestionar Usuarios</h2></div>
						<br />
						<div class="w3-container w3-responsive alto"><table class="w3-table w3-centered">
                        <tr class="w3-black"><td><center><b>Id</b></center></td><td><center><b>Nombre</b></center></td><td><center><b>Apellidos</b></center></td><td><center><b>Correo electronico</b></center></td><td><center><b>Eliminar</b></center></td></tr>';
                        $c=1;
                        while($row = mysqli_fetch_array($result)) 
                        {
                            $nombre = $row['nombre'];
                            $email = $row['email'];
                            $apellido = $row['apellido'];
                            echo '<tr class="w3-white w3-hover-blue" ><td><center>'.$c++.'</center></td><td><center>'.$nombre.'</center></td><td><center>'.$apellido.'</center></td><td><center>'.$email.'</center></td><td><center><a tema="Eliminar usuario" href="examen.php?demail='.$email.'"><b><span class="w3-xxlarge fa fa-remove" aria-hidden="true"></span></b></a></center></td></tr>';
                        }
                        $c=0;
                        echo '</table><br />
						</div></div>';
                    }
                ?>

                <?php
                    if(@$_GET['q']==4 && !(@$_GET['step']) ) 
                    {
                        echo '<div class="w3-container w3-blue w3-border-0"> <h2><i class="fa fa-pencil"></i> Crear Examen</h2>
    </div>
                        <div class="w3-container w3-padding w3-border-0"></div><div class="col-md-6"> 					
                        <form class="w3-border-0" name="form" action="examen.php?q=addexamen"  method="POST"><center><h4>
                            <fieldset class=" w3-container w3-border-0 alto">
							<br /><br />
                                <div class="w3-input w3-border-blue w3-border-0">
                                    <label class="col-md-12 control-label" for="nombre"></label>  
                                    <div class="col-md-12">
									<label><b>Titulo Examen</b></label>
                                        <input id="nombre" name="nombre" placeholder="Titulo del examen" class="w3-input w3-border-blue " type="text" required style="width:50%">
                                    </div>
                                </div>

                                <div class="w3-input w3-border-blue w3-border-0">
                                    <label class="col-md-12 control-label" for="total"></label>  
                                    <div class="col-md-12">
									<label><b>Numero Preguntas</b></label>
                                        <input id="total" name="total" placeholder="Numero de preguntas" class="w3-input w3-border-blue" type="number"  required  min="1" style="width:50%">
                                    </div>
                                </div>

                                <div class="input-block w3-border-0">

									<b>Permitir al usuario repetir examen</b>:<br />
                                    <select id="tipoExamen" name="tipoExamen" placeholder="Permitir al usuario repetir examen" class="w3-select w3-border-blue  " style="width:50%" >
                                    <option value="0">No Repetir Examen</option>
                                    <option value="1">Repetir Examen</option>
</select><br /><br />
                                </div>
                                
                                <div class="input-block w3-border-0">
                                    <label class="col-md-12 control-label" for=""></label>
                                    <div class="col-md-12"> 
										<button class="w3-button w3-blue w3-round" type="submit"> Siguiente</button>
                                    </div>
                                </div>
							</h4>
                            </fieldset>
							</center>
                        </form></div>';
                    }
                ?>

                <?php
                    if(@$_GET['q']==4 && (@$_GET['step'])==2 ) 
                    {
                        echo '<div class="w3-container w3-blue w3-border-0"> <h2><i class="fa fa-pencil"></i> Crear Examen</h2>
    </div>
                        <div class="w3-container w3-responsive w3-padding w3-border-0"></div><div class="col-md-6">   <h4>
						<form class="w3-border-0 w3-responsive" name="form" action="examen.php?q=addpregunta&n='.@$_GET['n'].'&idExamen='.@$_GET['idExamen'].'&ch=4 "  method="POST"><center>
                        <fieldset class="w3-border-0 w3-responsive alto">
                        ';
                
                        for($i=1;$i<=@$_GET['n'];$i++)
                        {
                            echo '<b ><div class="w3-container w3-indigo w3-border-0">Pregunta #&nbsp;'.$i.'&nbsp;:</b></div><br />
                                    <div class=" w3-input w3-border-blue w3-border-0">
                                        <label class="col-md-12 control-label" for="pregunta'.$i.' "></label>  
                                        <div class="col-md-12">
                                            <textarea rows="3" cols="5" name="pregunta'.$i.'" class="w3-input w3-border-blue" required style="width:50%" placeholder="Escribe la pregunta #'.$i.' aqui..."></textarea>  
                                        </div>
                                    </div>
                                    <div class="w3-input w3-border-blue w3-border-0">
                                        <label class="col-md-12 control-label" for="'.$i.'1"></label>  
                                        <div class="col-md-12">
                                            <input id="'.$i.'1" name="'.$i.'1" placeholder="Escribe opcion a" class="w3-input w3-border-blue" type="text" required style="width:50%">
                                        </div>
                                    </div>
                                    <div class="w3-input w3-border-blue w3-border-0">
                                        <label class="col-md-12 control-label" for="'.$i.'2"></label>  
                                        <div class="col-md-12">
                                            <input id="'.$i.'2" name="'.$i.'2" placeholder="Escribe opcion b" class="w3-input w3-border-blue" type="text" required style="width:50%">
                                        </div>
                                    </div>
                                    <div class="w3-input  w3-border-blue w3-border-0">
                                        <label class="col-md-12 control-label" for="'.$i.'3"></label>  
                                        <div class="col-md-12">
                                            <input id="'.$i.'3" name="'.$i.'3" placeholder="Escribe opcion c" class="w3-input w3-border-blue" type="text" required style="width:50%">
                                        </div>
                                    </div>
                                    <div class="w3-input  w3-border-blue w3-border-0">
                                        <label class="col-md-12 control-label" for="'.$i.'4"></label>  
                                        <div class="col-md-12">
                                            <input id="'.$i.'4" name="'.$i.'4" placeholder="Escribe opcion d" class="w3-input w3-border-blue" type="text" required style="width:50%">
                                        </div>
                                    </div>
                                    <br />
                                    <b>Respuesta correcta</b>:<br />
                                    <select id="ans'.$i.'" name="ans'.$i.'" placeholder="Elige la opcion correcta " class="w3-select w3-border-blue " style="width:50%">
                                    <option value="a">Selecciona la respuesta de la pregunta '.$i.'</option>
                                    <option value="a"> Opcion a</option>
                                    <option value="b"> Opcion b</option>
                                    <option value="c"> Opcion c</option>
                                    <option value="d"> Opcion d</option> </select><br /><br />'; 
                        }
                        echo '<div class="input-block w3-border-0">
                                <label class="col-md-12 control-label" for=""></label>
                                <div class="col-md-12"> 
								<button class="w3-button w3-blue w3-round" type="submit">Crear Examen</button>
                                </div>
                              </div>
</h4>
                        </fieldset>
						
						</center>
                        </form></div>';
                    }
                ?>

                <?php 
                    if(@$_GET['q']==5) 
                    {
                        $result = mysqli_query($con,"SELECT * FROM examen ORDER BY fecha DESC") or die('Error');
                        echo  '<div class="w3-container w3-blue w3-border-0"> <h2><i class="fa fa-remove"></i> Eliminar Examen</h2></div>
						<br /><div class="panel alto"><div class="w3-container w3-responsive"><table class="w3-table w3-centered">
                        <tr class="w3-black"><td><center><b>Examen</b></center></td><td><center><b>Tema</b></center></td><td><center><b>Preguntas</b></center></td><td><center><b>Calificacion</b></center></td><td><center><b>Eliminar</b></center></td></tr>';
                        $c=1;
                        while($row = mysqli_fetch_array($result)) {
                            $tema = $row['tema'];
                            $total = $row['total'];
                            $respuestaCorrecta = $row['respuestaCorrecta'];
                            $idExamen = $row['idExamen'];
                            echo '<tr class="w3-white w3-hover-blue" ><td><center>'.$c++.'</center></td><td><center>'.$tema.'</center></td><td><center>'.$total.'</center></td><td><center>'.$respuestaCorrecta*$total.'</center></td>
                            <td><center><b><a href="examen.php?q=rmexamen&idExamen='.$idExamen.'"><b><span class="w3-xxlarge fa fa-remove" aria-hidden="true"></span></b></a></b></center></td></tr>';
                        }
                        $c=0;
                        echo '</table></div></div>';
                    }
                ?>
            </div>
            </div>
          </div>
        </div>
      </div>
</div>
</body>
</html>
