<?php
  include_once 'conexion.php';
  session_start();
  $email=$_SESSION['email'];

  if(isset($_SESSION['key']))
  {
    if(@$_GET['demail']) 
    {
      $demail=@$_GET['demail'];
      $r2 = mysqli_query($con,"DELETE FROM calificacion WHERE email='$demail' ") or die('Error');
      $result = mysqli_query($con,"DELETE FROM evaluado WHERE email='$demail' ") or die('Error');
      header("location:admin.php?q=1");
    }
  }

  if(isset($_SESSION['key']))
  {
    if(@$_GET['q']== 'rmexamen') 
    {
      $idExamen=@$_GET['idExamen'];
      $result = mysqli_query($con,"SELECT * FROM pregunta WHERE idExamen='$idExamen' ") or die('Error');
      while($row = mysqli_fetch_array($result)) 
      {
        $idPregunta = $row['idPregunta'];
        $r1 = mysqli_query($con,"DELETE FROM incisos WHERE idPregunta='$idPregunta'") or die('Error');
        $r2 = mysqli_query($con,"DELETE FROM respuesta WHERE idPregunta='$idPregunta' ") or die('Error');
      }
      $r3 = mysqli_query($con,"DELETE FROM pregunta WHERE idExamen='$idExamen' ") or die('Error');
      $r4 = mysqli_query($con,"DELETE FROM examen WHERE idExamen='$idExamen' ") or die('Error');
      $r4 = mysqli_query($con,"DELETE FROM calificacion WHERE idExamen='$idExamen' ") or die('Error');
      header("location:admin.php?q=5");
    }
  }

  if(isset($_SESSION['key']))
  {
    if(@$_GET['q']== 'addexamen') 
    {
      $nombre = $_POST['nombre'];
      $nombre= ucwords(strtolower($nombre));
      $total = $_POST['total'];
      $respuestaCorrecta = 1;
      $tipoExamen = $_POST['tipoExamen'];
      $id=uniqid();
      $q3=mysqli_query($con,"INSERT INTO examen VALUES  ('$id','$nombre' , '$respuestaCorrecta' , '$tipoExamen','$total', NOW())");
      header("location:admin.php?q=4&step=2&idExamen=$id&n=$total");
    }
  }

  if(isset($_SESSION['key']))
  {
    if(@$_GET['q']== 'addpregunta') 
    {
      $n=@$_GET['n'];
      $idExamen=@$_GET['idExamen'];
      $ch=@$_GET['ch'];
      for($i=1;$i<=$n;$i++)
      {
        $idPregunta=uniqid();
        $pregunta=$_POST['pregunta'.$i];
        $q3=mysqli_query($con,"INSERT INTO pregunta VALUES  ('$idExamen','$idPregunta','$pregunta' , '$ch' , '$i')");
        $oaid=uniqid();
        $obid=uniqid();
        $ocid=uniqid();
        $odid=uniqid();
        $a=$_POST[$i.'1'];
        $b=$_POST[$i.'2'];
        $c=$_POST[$i.'3'];
        $d=$_POST[$i.'4'];
        $qa=mysqli_query($con,"INSERT INTO incisos VALUES  ('$idPregunta','$a','$oaid')") or die('Error61');
        $qb=mysqli_query($con,"INSERT INTO incisos VALUES  ('$idPregunta','$b','$obid')") or die('Error62');
        $qc=mysqli_query($con,"INSERT INTO incisos VALUES  ('$idPregunta','$c','$ocid')") or die('Error63');
        $qd=mysqli_query($con,"INSERT INTO incisos VALUES  ('$idPregunta','$d','$odid')") or die('Error64');
        $e=$_POST['ans'.$i];
        switch($e)
        {
          case 'a': $idRespuesta=$oaid; break;
          case 'b': $idRespuesta=$obid; break;
          case 'c': $idRespuesta=$ocid; break;
          case 'd': $idRespuesta=$odid; break;
          default: $idRespuesta=$oaid;
        }
        $qans=mysqli_query($con,"INSERT INTO respuesta VALUES  ('$idPregunta','$idRespuesta')");
      }
      header("location:admin.php?q=0");
    }
  }

  if(@$_GET['q']== 'examen' && @$_GET['step']== 2) 
  {
    $idExamen=@$_GET['idExamen'];
    $numeroPregunta=@$_GET['n'];
    $total=@$_GET['t'];
    $ans=$_POST['ans'];
    $idPregunta=@$_GET['idPregunta'];
    $q=mysqli_query($con,"SELECT * FROM respuesta WHERE idPregunta='$idPregunta' " );
    while($row=mysqli_fetch_array($q) )
    {  $idRespuesta=$row['idRespuesta']; }
    if($ans == $idRespuesta)
    {
      $q=mysqli_query($con,"SELECT * FROM examen WHERE idExamen='$idExamen' " );
      while($row=mysqli_fetch_array($q) )
      {
        $respuestaCorrecta=$row['respuestaCorrecta'];
      }
      if($numeroPregunta == 1)
      {
        $q=mysqli_query($con,"INSERT INTO calificacion VALUES('$email','$idExamen' ,'0','0','0','0',NOW())")or die('Error');
      }
      $q=mysqli_query($con,"SELECT * FROM calificacion WHERE idExamen='$idExamen' AND email='$email' ")or die('Error115');
      while($row=mysqli_fetch_array($q) )
      {
        $s=$row['calificacion'];
        $r=$row['respuestaCorrecta'];
      }
      $r++;
      $s=$s+$respuestaCorrecta;
      $q=mysqli_query($con,"update `calificacion` SET `calificacion`=$s,`cantidadPregunta`=$numeroPregunta,`respuestaCorrecta`=$r, fecha= NOW()  WHERE  email = '$email' AND idExamen = '$idExamen'")or die('Error124');
    } 
    else
    {
      $q=mysqli_query($con,"SELECT * FROM examen WHERE idExamen='$idExamen' " )or die('Error129');
      while($row=mysqli_fetch_array($q) )
      {
        $tipoExamen=$row['tipoExamen'];
      }
      if($numeroPregunta == 1)
      {
        $q=mysqli_query($con,"INSERT INTO calificacion VALUES('$email','$idExamen' ,'0','0','0','0',NOW() )")or die('Error137');
      }
      $q=mysqli_query($con,"SELECT * FROM calificacion WHERE idExamen='$idExamen' AND email='$email' " )or die('Error139');
      while($row=mysqli_fetch_array($q) )
      {
        $s=$row['calificacion'];
        $w=$row['tipoExamen'];
      }
      $w++;
      $q=mysqli_query($con,"update `calificacion` SET `calificacion`=$s,`cantidadPregunta`=$numeroPregunta,`tipoExamen`=$w, fecha=NOW() WHERE  email = '$email' AND idExamen = '$idExamen'")or die('Error147');
    }
    if($numeroPregunta != $total)
    {
      $numeroPregunta++;
      header("location:usuario.php?q=examen&step=2&idExamen=$idExamen&n=$numeroPregunta&t=$total")or die('Error152');
    }
    else if( $_SESSION['key'])
    {
      $q=mysqli_query($con,"SELECT calificacion FROM calificacion WHERE idExamen='$idExamen' AND email='$email'" )or die('Error156');
      while($row=mysqli_fetch_array($q) )
      {
        $s=$row['calificacion'];
      }
     
      header("location:usuario.php?q=result&idExamen=$idExamen");
    }
    else
    {
      header("location:usuario.php?q=result&idExamen=$idExamen");
    }
  }

  if(@$_GET['q']== 'examenre' && @$_GET['step']== 25 ) 
  {
    $idExamen=@$_GET['idExamen'];
    $n=@$_GET['n'];
    $t=@$_GET['t'];
    $q=mysqli_query($con,"SELECT calificacion FROM calificacion WHERE idExamen='$idExamen' AND email='$email'" )or die('Error156');
    while($row=mysqli_fetch_array($q) )
    {
      $s=$row['calificacion'];
    }
    $q=mysqli_query($con,"DELETE FROM `calificacion` WHERE idExamen='$idExamen' AND email='$email' " )or die('Error184');

    header("location:usuario.php?q=examen&step=2&idExamen=$idExamen&n=1&t=$t");
  }
?>



