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

?>