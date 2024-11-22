<?php
require_once("conexao.php");

if (isset($_POST["tag"])&& $_POST["tag"]=="concelho" && isset($_POST["distrito"])) {
    $distrito = $_POST["distrito"];
    $sql = "SELECT DISTINCT Designação_CC as nome,Concelho_CC as id FROM populacaoresidentefreguesia WHERE Distrito_DT = $distrito";
    $result = mysqli_query($link, $sql);
    $response = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    echo json_encode($response);
}
if (isset($_POST["tag"])&& $_POST["tag"]=="fregue" && isset($_POST["concelho"])) {
    $tag = $_POST["tag"];
    $concelho = $_POST["concelho"];
    $sql = "SELECT  Designação_FR as nome, populacaoresidentefreguesia_id as id FROM populacaoresidentefreguesia WHERE Concelho_CC = $concelho";
    $result = mysqli_query($link, $sql);
    $response = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    echo json_encode($response);
}
?>