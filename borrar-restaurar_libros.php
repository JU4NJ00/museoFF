<!-- ssssssssssssssssssssssssssssssssssss -->
<?php
session_start();

if (isset($_SESSION["dniadmin"])) {
    header("location:inicio_admin.php");
} elseif (isset($_SESSION["dniencargado"])) {
    header("location:inicio_encargado.php");
} else {
    header("location:index.php");
}

require_once "conexion.php";

$id = $_POST['idlibro'];
$_SESSION['ids'] = $id;

// Obtener el nombre del archivo de imagen antes de realizar la operación de borrado
$sql_select = "SELECT nomImg FROM inventariolibros WHERE idlibro=$id";
$result_select = mysqli_query($conex, $sql_select);

if ($row = mysqli_fetch_assoc($result_select)) {
    $nomImg = $row['nomImg'];

    // Verifica si se ha enviado el formulario para borrar o restaurar
    if (isset($_POST['restaurar'])) {
        // Actualiza el estado del mueble
        $sql = "UPDATE inventariolibros SET activo=1 WHERE idlibro=$id";
        $mensaje = "restaurado"; // Cambiado de "borrado" a "restaurado"
    } elseif (isset($_POST['borrar'])) {
        // Elimina la fila correspondiente de la base de datos
        $sql = "DELETE FROM inventariolibros WHERE idlibro=$id";
        $mensaje = "eliminado";

        // Elimina el archivo de imagen de la carpeta
        if (!empty($nomImg) && file_exists("./imagenes/$nomImg")) {
            unlink("./imagenes2/$nomImg");
        }
    } else {
        // En caso de que no se haya enviado ninguna acción válida
        header("location:lista_libros_borrados.php");
        exit();
    }

    $result = mysqli_query($conex, $sql);

    //die($sql);

    header("location:lista_libros_borrados.php?mensaje=$mensaje");
} else {
    // En caso de que no se encuentre el registro con el ID proporcionado
    header("location:lista_libros_borrados.php");
    exit();
}
?>
