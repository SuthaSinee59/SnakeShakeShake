<?php
$mysqli = new mysqli('localhost', 'root', '', 'snake_users');
if ($mysqli->connect_error) { die('Connection Failed: ' . $mysqli->connect_error); }
?>