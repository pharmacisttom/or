<?php
try
{
	$bdd = new PDO('mysql:host=192.168.111.254;dbname=orpdh;charset=utf8', 'root', 'boom123');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
