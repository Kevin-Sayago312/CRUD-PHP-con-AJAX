<?php
include("conexion.php");
include("funciones.php");

if (isset($_POST["id_usuario"])){
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE id = :id_usuario LIMIT 1");
    $stmt->bindParam(':id_usuario', $_POST["id_usuario"]);
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    if ($resultado) { // Verificar si la consulta devuelve resultados
        foreach($resultado as $fila){
            $salida["nombre"] = $fila["nombre"];
            $salida["apellidos"] = $fila["apellidos"];
            $salida["telefono"] = $fila["telefono"];
            $salida["email"] = $fila["email"];
            if ($fila["imagen"] != ""){
                $salida["imagen_usuario"] = '<img src="img/' . $fila["imagen"] . '" class="img-thumbnail" width="100" height="50"/><input type="hidden" name="imagen_usuario_oculta" value="' . $fila["imagen"] . '">';
            } else {
                $salida["imagen_usuario"] = '<input type="hidden" name="imagen_usuario_oculta" value="">';
            }
        }
        echo json_encode($salida);
    } else {
        echo json_encode(array("error" => "No se encontraron detalles para este usuario."));
    }
}
?>
