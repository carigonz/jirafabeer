<?php

//echo "soy funciones.php";

function validarRegistro($datos){
  $errores =[];
  $datosFinales=[];

  //nombre
  if(strlen($datos["name"]) == 0){
    $errores["name"] = "Campo obligatorio.";
  } elseif (ctype_alpha($datos["name"]) == false){
    $errores["name"] = "El nombre no puede contener números.";
  }

  //apellido
  if(strlen($datos["lastName"]) == 0){
    $errores["lastName"] = "Campo obligatorio.";
  } elseif(ctype_alpha($datos["lastName"])==false){
    $errores["lastName"] = "El nombre no puede contener números.";
  }

  //gender
  if(!isset($datos["gender"])){
    $errores["gender"]="Por favor, elija una opción.";
  }

  //email
  if(strlen($datos["email"])==0){
    $errores["email"]="Campo obligatorio.";
  } elseif (!filter_var($datos["email"],FILTER_VALIDATE_EMAIL)) {
    $errores["email"]="Ingrese un email válido.";
  } 

  //pass
  if(strlen($datos["pass"])==0){
    $errores["pass"]="Campo obligatorio.";
  } elseif(strlen($datos["pass2"])==0){
    $errores["pass"]="Verifique la contraseña.";
  } elseif ($datos["pass"] != $datos["pass2"]){
    $errores["pass"]="Las contraseñas no coinciden.";
  }

  //adult
  if(!isset($datos["adult"])){
    $errores["adult"]="Debe aceptar los términos y condiciones.";
  }
  return $errores;
}

function validarLogin($datos){
  $errores =[];
  $datosFinales=[];

  //email
  if(strlen($datos["email"])==0){
    $errores["email"]="Campo obligatorio.";
  } elseif (!filter_var($datos["email"],FILTER_VALIDATE_EMAIL)) {
    $errores["email"]="Ingrese un email válido.";
  } 

  //pass
  if(strlen($datos["pass"])==0){
    $errores["pass"]="Campo obligatorio.";
  } /* elseif(strlen($datos["pass2"])==0){
    $errores["pass"]="Verifique la contraseña.";
  } elseif ($datos["pass"] != $datos["pass2"]){
    $errores["pass"]="Las contraseñas no coinciden.";
  } */
  return $errores;
}


function buscarUsuario($email,$pass){

  $json=file_get_contents("db.json");
  $array=json_decode($json,true);
  $pass=password_hash($pass,PASSWORD_DEFAULT);
  foreach ($array["usuarios"] as $value){
    if($usuarios["email"] ==$email);
      if($usuarios["pass"]==$pass){
        return $usuarios;
      } else{
        return $noExisteUsuario= "El mail no se encuentra registrado.";
      }
  }
}



function lastID(){
  $json=file_get_contents("db.json");
  $array=json_decode($json,true);

  if(isset($array)==false){
    return $lastId=0;
  }
  //poruqe $array es asociativo a "usuarios"??
  $ultimoElemento=array_pop($array["usuarios"]);
  $lastId=$ultimoElemento["id"]+1;
  return $lastId;
}

function armarUsuario($array){

  return [
    "id"=>lastId(),
    "name"=>trim($array["name"]),
    "lastName"=>trim($array["lastName"]),
    "email"=>trim($array["email"]),
    "pass"=>password_hash($array["pass"],PASSWORD_DEFAULT)
  ];

}

function guardarUsuario($user){

  $json=file_get_contents("db.json");
  $array=json_decode($json,true);
  $array["usuarios"][]=$user;
  //que hace json pretty print?
  $array=json_encode($array, JSON_PRETTY_PRINT);
  file_put_contents("db.json",$array);

}

function buscarPorEmail($email){
  if(!file_exists("db.json")){
    $usuarios="";
  } else{
    $usuarios=file_get_contents("db.json");
  }

  if ($usuarios==""){
    return null;
  }
    $array=json_decode($usuarios,true);
  //$array corresponde a un array asociativo puesto que en caso de querer guardar alguna otra informacion en el archivo json tengo todos los usuarios en la posicion $usuarios de mi json
    foreach ($array["usuarios"] as $usuario) {
      if ($email==$usuario["email"]){
        return $usuario;
      }
    }
    return null;
}

function existeElUsuario($email){
  return buscarPorEmail($email)!==null;
}
?>