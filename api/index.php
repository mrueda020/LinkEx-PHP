<?php 

$type = $_GET['tp']; 
if($type=='signup') signup(); 
else if($type=='login') login(); 

function login() 
{ 
    require 'config.php'; 
    $json = json_decode(file_get_contents('php://input'), true); 
    $email = $json['email']; $password = $json['password']; 
    $userData =''; $query = "select * from users where email='$email' and password='$password'"; 
    $result= $db->query($query);
    $rowCount=$result->num_rows;
            
    if($rowCount>0)
    {
        $userData = $result->fetch_object();
        $user_id=$userData->user_id;
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
        
        $result = $db->query("select * from users where  email='$email'");
        $rowCount=$result->num_rows;
        //echo '{"text": "'.$rowCount.'"}';
        
        if($rowCount==0)
        {
                            
            $db->query("INSERT INTO users(lastname,password,email,firstname)
                        VALUES('$lastname','$password','$email','$firstname')");

            $userData ='';
            $query = "select * from users where lastname='$lastname' and password='$password'";
            $result= $db->query($query);
            $userData = $result->fetch_object();
            $user_id=$userData->user_id;
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


?>