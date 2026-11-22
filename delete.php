<?php
include 'db.php';

$id = $_GET['id'];

$conn->query("DELETE FROM youser_tb WHERE id=$id");

header("Location: view.php");
?>