<?php

session_start();
if(isset($_SESSION["dniadmin"])){
	header("location:inicio_admin.php");
}else{
 if(isset($_SESSION["dniencargado"])){
	header("location:inicio_encargado.php");
 }else {header("location:index.php");}}

require_once "conexion.php";
 $id=$_POST['idcategorias'];
 $sql="DELETE FROM categoria WHERE idcategoriaboss=$id";    
 $result=mysqli_query($conex,$sql);


header("location:categoriaMuebles.php?mensaje=borrado");
 ?>   