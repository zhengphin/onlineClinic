<?php
namespace App\Libraries;
require '../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Contract\Storage;

class FirebaseCon{
    
    public static function getCon(){
        $factory = (new Factory)
        ->withServiceAccount(__DIR__.'/online-clinic-demo-firebase-adminsdk-3v03m-87ab8672e5.json')
        ->withDatabaseUri('https://online-clinic-demo-default-rtdb.asia-southeast1.firebasedatabase.app/');
        //main
       // ->withServiceAccount(__DIR__.'/onlineclinic-37b72-firebase-adminsdk-elcqb-b6856ee82f.json')
      //  ->withDatabaseUri('https://onlineclinic-37b72-default-rtdb.firebaseio.com');
        //
       //->withServiceAccount(__DIR__.'/onlineclinic-cb0c8-firebase-adminsdk-lhpcs-9ce56212e9.json')
        //->withDatabaseUri('https://onlineclinic-cb0c8-default-rtdb.firebaseio.com');
        return $database = $factory->createDatabase();
    }

    public static function getConStorage(){
        $factory = (new Factory)
        ->withServiceAccount(__DIR__.'/onlineclinic-37b72-firebase-adminsdk-elcqb-b6856ee82f.json')
        ->withDefaultStorageBucket('gs://onlineclinic-37b72.appspot.com');
        return $database = $factory->createStorage();
    }
   
    
}
?>