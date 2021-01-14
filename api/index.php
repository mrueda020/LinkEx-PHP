<?php 

$type = $_GET['tp']; 
if($type=='signup') signup(); 
else if($type=='login') login(); 
else if($type=='getGrades') getGrades();
function login() 
{ 
    require 'config.php'; 
    $json = json_decode(file_get_contents('php://input'), true); 
    $email = $json['email']; $password = $json['password']; 
    $userData =''; $query = "select * from evaluado where email='$email' and password='$password'"; 
    $result= $db->query($query);
    $rowCount=$result->num_rows;
            
    if($rowCount>0)
    {
        $userData = $result->fetch_object();
        $user_id=$userData->email;
        $userData = json_encode($userData);
        echo '{"userData":'.$userData.'}';

        
    }
    else 
    {
        echo '{"error":"Wrong email and password"}';
    }

    
}



function signup() {
    
    require 'config.php';

            
    $json = json_decode(file_get_contents('php://input'), true);
    $lastname = $json['lastname'];
    $password = $json['password'];
    $email = $json['email'];
    $firstname = $json['firstname'];

    // $lastname_check = preg_match("/^[A-Za-z0-9_]{4,10}$/i", $lastname);
    $email_check = preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$/i', $email);
    $password_check = preg_match('/^[A-Za-z0-9!@#$%^&*()_]{4,20}$/i', $password);
    
    // if($lastname_check==0) 
        // echo '{"error":"Invalid lastname"}';
    if($email_check==0) 
        echo '{"error":"Invalid email"}';
    elseif($password_check ==0) 
        echo '{"error":"Invalid password"}';

    elseif ( strlen(trim($password))>0 && strlen(trim($email))>0 && 
        $email_check>0 &&  $password_check>0)
    {
        

        $userData = '';
        
        $result = $db->query("select * from evaluado where  email='$email'");
        $rowCount=$result->num_rows;
        //echo '{"text": "'.$rowCount.'"}';
        
        if($rowCount==0)
        {
                            
           $db->query("INSERT INTO evaluado(nombre,apellido,email,password)
                        VALUES('$firstname','$lastname','$email','$password')");

            $userData ='';
            $query = "select * from evaluado where apellido='$lastname' and password='$password'";
            $result= $db->query($query);
            $userData = $result->fetch_object();
            $user_id=$userData->email;
            $userData = json_encode($userData);
            echo '{"userData":'.$userData.'}';
        } 
        else {
            echo '{"error":" email exists"}';
        }

    }
    else{
        echo '{"text":"Enter valid data"}';
    }

}

function getGrades(){
    
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $email = "alumno1@gmail.com";
    $email = $json['email'];
    $result = mysqli_query($db,"select * FROM examen ORDER BY fecha DESC") or die('Error');
    $i = 0;
    $calificaciones =  new ArrayObject();
    while($row = mysqli_fetch_array($result)) {
      
        $tema = $row['tema'];
        $total = $row['total'];
        $respuestaCorrecta = $row['respuestaCorrecta'];
        $tipoexamen = $row['tipoExamen'];
        $idExamen = $row['idExamen'];
        $q12=mysqli_query($db,"select calificacion FROM calificacion WHERE idExamen='$idExamen' AND email='$email'" )or die('Error98');
        $examen=[];
        $i = $i+1;
        $rowcount=mysqli_num_rows($q12);
        $row = $q12->fetch_assoc();	
        if($rowcount == 0){
            array_push($examen, $i, $tema,0,true,$tipoexamen,$total ); 
            // $examen->append($i);
            // $examen->append($tema);
            // $examen->append('-');
            // $examen->append(true);
            // $examen->append($tipoexamen);
            
        }
        else{
            array_push($examen, $i, $tema,$row['calificacion'],false,$tipoexamen,$total ); 
            // $examen->append($i);
            // $examen->append($tema);
            // $examen->append($total*$respuestaCorrecta);
            // $examen->append(false);
            // $examen->append($tipoexamen);
        }
    
        $calificaciones->append(((array)$examen));
        
    }
    $calificaciones = (array) $calificaciones;
    $grades = json_encode((array)$calificaciones);
    echo '{"grades":'.$grades.'}';
    
   
}

// getGrades();

?>