<?php
require '../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$factory = (new Factory)
->withServiceAccount(__DIR__.'/onlineclinic-37b72-firebase-adminsdk-elcqb-c3242980ce.json')
->withDatabaseUri('https://onlineclinic-37b72-default-rtdb.firebaseio.com');
$database = $factory->createDatabase();
?>
