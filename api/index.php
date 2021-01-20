<?php

$type = $_GET["tp"];    
if ($type == "signup") {
    signup();
} elseif ($type == "login") {
    login();
} elseif ($type == "getGrades") {
    getGrades();
} elseif ($type == "getExam") {
    getExam();
} elseif ($type == "evaluateExam") {
    evaluateExam();
}

function login()
{
    require "config.php";
    $json = json_decode(file_get_contents("php://input"), true);
    $email = $json["email"];
    $password = $json["password"];
    $userData = "";
    $query = "select * from evaluado where email='$email' and password='$password'";
    $result = $db->query($query);
    $rowCount = $result->num_rows;

    if ($rowCount > 0) {
        $userData = $result->fetch_object();
        $user_id = $userData->email;
        $userData = json_encode($userData);
        echo '{"userData":' . $userData . "}";
    } else {
        echo '{"error":"Wrong email and password"}';
    }
}

function signup()
{
    require "config.php";

    $json = json_decode(file_get_contents("php://input"), true);
    $lastname = $json["lastname"];
    $password = $json["password"];
    $email = $json["email"];
    $firstname = $json["firstname"];

    // $lastname_check = preg_match("/^[A-Za-z0-9_]{4,10}$/i", $lastname);
    $email_check = preg_match(
        '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$/i',
        $email
    );
    $password_check = preg_match(
        '/^[A-Za-z0-9!@#$%^&*()_]{4,20}$/i',
        $password
    );

    // if($lastname_check==0)
    // echo '{"error":"Invalid lastname"}';
    if ($email_check == 0) {
        echo '{"error":"Invalid email"}';
    } elseif ($password_check == 0) {
        echo '{"error":"Invalid password"}';
    } elseif (
        strlen(trim($password)) > 0 &&
        strlen(trim($email)) > 0 &&
        $email_check > 0 &&
        $password_check > 0
    ) {
        $userData = "";
        $result = $db->query("select * from evaluado where  email='$email'");
        $rowCount = $result->num_rows;
        if ($rowCount == 0) {
            $db->query("INSERT INTO evaluado(nombre,apellido,email,password)
                            VALUES('$firstname','$lastname','$email','$password')");
            $userData = "";
            $query = "select * from evaluado where apellido='$lastname' and password='$password'";
            $result = $db->query($query);
            $userData = $result->fetch_object();
            $user_id = $userData->email;
            $userData = json_encode($userData);
            echo '{"userData":' . $userData . "}";
        } else {
            echo '{"error":" email exists"}';
        }
    } else {
        echo '{"text":"Enter valid data"}';
    }
}

function getGrades()
{
    require "config.php";
    $json = json_decode(file_get_contents("php://input"), true);
    $email = $json["email"];

    ($result = mysqli_query($db, "select * FROM examen ORDER BY fecha DESC")) or
        die("Error");
    $i = 0;
    $calificaciones = new ArrayObject();
    while ($row = mysqli_fetch_array($result)) {
        $tema = $row["tema"];
        $total = $row["total"];
        $respuestaCorrecta = $row["respuestaCorrecta"];
        $tipoexamen = $row["tipoExamen"];
        $idExamen = $row["idExamen"];
        ($q12 = mysqli_query(
            $db,
            "select calificacion FROM calificacion WHERE idExamen='$idExamen' AND email='$email'"
        )) or die("Error98");
        $examen = [];
        $i = $i + 1;
        $rowcount = mysqli_num_rows($q12);
        $row = $q12->fetch_assoc();
        if ($rowcount == 0) {
            array_push(
                $examen,
                $i,
                $tema,
                0,
                true,
                $tipoexamen,
                $total,
                $idExamen
            );
        } else {
            array_push(
                $examen,
                $i,
                $tema,
                $row["calificacion"],
                false,
                $tipoexamen,
                $total,
                $idExamen
            );
        }
        $calificaciones->append(((array) $examen));
    }
    $calificaciones = (array) $calificaciones;
    $grades = json_encode((array) $calificaciones);
    echo '{"grades":' . $grades . "}";
}

function getExam()
{
    require "config.php";
    $json = json_decode(file_get_contents("php://input"), true);
    $idExamen = $json["id"];

    $total = 0;

    $query = mysqli_query(
        $db,
        "select total FROM examen where idExamen='$idExamen'"
    );
    while ($row = mysqli_fetch_array($query)) {
        $total = $row["total"];
    }

    $exam = new ArrayObject();
    $preguntas = [];
    $incisos = [];
    for ($i = 1; $i <= $total; $i++) {
        $resultados = [];
        $query = mysqli_query(
            $db,
            "SELECT * FROM pregunta WHERE idExamen='$idExamen' AND numeroPregunta='$i' "
        );
        while ($row = mysqli_fetch_array($query)) {
            $pregunta = $row["pregunta"];
            $idPregunta = $row["idPregunta"];
            array_push($preguntas, [strval($pregunta)]);
        }

        $query = mysqli_query(
            $db,
            "SELECT * FROM incisos WHERE idPregunta='$idPregunta' "
        );

        while ($row = mysqli_fetch_array($query)) {
            $opciones = $row["opciones"];
            $idOpciones = $row["idOpciones"];
            array_push($resultados, $opciones);
        }
        array_push($incisos, $resultados);
    }

    for ($i = 0; $i < $total; $i++) {
        $result = array_merge($preguntas[$i], $incisos[$i]);
        $exam->append(((array) $result));
    }

    $exam = json_encode((array) $exam, JSON_UNESCAPED_UNICODE);
    echo '{"exam":' . $exam . "}";
}

function evaluateExam()
{
    require "config.php";
    $json = json_decode(file_get_contents("php://input"), true);

    // $json = array("ans0"=>"AMD","ans1"=>"Oracle","ans2"=>"Solaris",
    // "ans3"=>"C","ans4"=>"Perl y Java","email"=>"miguelescom@gmail.com" );
    $email = $json["email"];
    $respuestas = [];

    $idPreguntas = [];
    foreach ($json as $x => $x_value) {
        if ($x != "email") {
            $query = mysqli_query(
                $db,
                "SELECT * FROM incisos WHERE opciones='$x_value' "
            );
            $row = $query->fetch_assoc();
            array_push($respuestas, $row["idOpciones"]);
            array_push($idPreguntas, $row["idPregunta"]);
        }
    }

    $count = count($respuestas);
    $calificacion = 0;
    for ($i = 0; $i < $count; $i++) {
        $query = mysqli_query(
            $db,
            "SELECT * FROM respuesta WHERE idPregunta='$idPreguntas[$i]' "
        );
        $row = $query->fetch_assoc();
        $respuesta = $row["idRespuesta"];
        if ($respuesta == $respuestas[$i]) {
            $calificacion++;
        }
    }

    $query = mysqli_query(
        $db,
        "SELECT idExamen FROM pregunta WHERE idPregunta='$idPreguntas[0]' "
    );
    $row = $query->fetch_assoc();
    $idExamen = $row["idExamen"];
    $query = mysqli_query(
        $db,
        "SELECT * FROM examen WHERE idExamen='$idExamen' "
    );
    $row = $query->fetch_assoc();
    $tipoExamen = $row["tipoExamen"];
    $query = mysqli_query(
        $db,
        "SELECT * FROM calificacion WHERE email='$email' and idExamen='$idExamen' "
    );
    $rowcount = mysqli_num_rows($query);
    if ($rowcount == 0) {
        $query = mysqli_query(
            $db,
            "INSERT INTO calificacion VALUES('$email','$idExamen' ,'$calificacion','$count','$calificacion','$tipoExamen',NOW() )"
        );
    } else {
        $query = mysqli_query(
            $db,
            "update calificacion set calificacion='$calificacion', respuestaCorrecta = '$calificacion', fecha= NOW() where idExamen='$idExamen' and email = '$email'"
        );
    }
    echo '{"exam":' . $calificacion . "}";
}

// evaluateExam();

?>