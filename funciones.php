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
  } /* elseif (el mail ya esta registrado){
    $errores["email"]="El mail ya se encuentra registrado."
  }
 */

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

function lastID(){
  $json=file_get_contents("db.json");
  $array=json_decode($json,true);

  if(isset($array)==false){
    return $lastId=0;
  }
  //poruqe $array es asociativo a "usuarios"??
  $ultimoElemento=array_pop($array["usuarios"]);
  $lastId=$ultimoElemento["id"]++;
  return $lastId;
}

function armarUsuario(){

  return [
    "id"=>$lastId,
    "name"=>trim($_POST["name"]),
    "lastName"=>trim($_POST["lastName"]),
    "email"=>trim($_POST["email"]),
    "pass"=>password_hash($_POST["pass"],PASSWORD_DEFAULT)
  ];
}

function guardarUsuario($user){

  $json=file_get_contents("db.json");
  $array=json_decode($json,true);
  $array["usuario"][]=$user;
  //que hace json pretty print?
  $array=json_encode("db.json", JSON_PRETTY_PRINT);
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
  }else{
    $array=json_decode($usuarios,true);
  }//no termine de entender porque $array es un array asociativo, porque tengo que poner mis usuarios dentro de la posicion "usuarios" en mi json
  foreach ($array["usuarios"]as $usuario) {
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