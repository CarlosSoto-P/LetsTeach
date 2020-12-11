<?php
session_start();
include("connections/conn_localhost.php");
$post = $_POST['id'];

$usuario = $_SESSION['id'];
$query_megusta = sprintf("SELECT * FROM SHT_megustas WHERE idUsuario =%d AND idPublicacion = %d",
mysqli_real_escape_string($connLocalhost, trim($usuario)),
mysqli_real_escape_string($connLocalhost, trim($post)));

$resquery_query_megusta = mysqli_query($connLocalhost,$query_megusta) or trigger_error(" la query de megustas fallo");

$count = mysqli_num_rows($resquery_query_megusta);


if($count ==0){

$insert_megusta=("INSERT INTO  SHT_megustas (idUsuario,idPublicacion) VALUES ($usuario,$post)");


$res_inserMegusta = mysqli_query($connLocalhost,$insert_megusta) or trigger_error("fallo megusta");

$update_publicacion = ("UPDATE SHT_publicacion SET megustas = megustas+1 WHERE idPublicacion = $post");
$res_update = mysqli_query($connLocalhost,$update_publicacion);



}else{
$delete_megusta = ("DELETE FROM SHT_megustas WHERE idPublicacion =$post AND idUsuario =$usuario");
$res_delete = mysqli_query($connLocalhost, $delete_megusta);
$update_publicacion = ("UPDATE SHT_publicacion SET megustas = megustas-1 WHERE idPublicacion = $post");
$res_update = mysqli_query($connLocalhost,$update_publicacion);

}


$contar = ("SELECT * FROM SHT_publicacion WHERE idPublicacion = $post");
$res_contar = mysqli_query($connLocalhost, $contar);
$cont = mysqli_fetch_assoc($res_contar);

$likes = $cont['megustas'];


if($count >=1){
    $megusta = "Me gusta";
    $likes = $likes++;


}else{
    $megusta = "No me gusta";
    $likes = $likes--;
}

$datos = array('likes'=>$likes,'text' =>$megusta);

echo json_encode($datos);

?>