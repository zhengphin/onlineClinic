<?php

namespace App\Libraries;
use App\Libraries\FirebaseCon;

class User
{
    public static function updateAllOnlinePatientIC($oldIc,$newIc){
        $database=FirebaseCon::getCon();
        
        if(isset($database)){
            $fetch_data=$database->getReference('users')->getValue();

            if($fetch_data>0)
            {
                foreach($fetch_data as $key => $row){

                if($row['ic']==$oldIc)
                {
                    $updateAt=[
                        'ic'=>$newIc
                    ];
                    $database->getReference("users/".$key)->update($updateAt);
                }
            }
            }else
            {
                return false;
            }
            //return $record;
        }else{
            return false;

        }
    }
    public static function updateAllPatientIC($oldIc,$newIc){
        $database=FirebaseCon::getCon();
        
        if(isset($database)){
            $fetch_data=$database->getReference('patient')->getValue();

            if($fetch_data>0)
            {
                foreach($fetch_data as $key => $row){

                if($row['ic']==$oldIc)
                {
                    $updateAt=[
                        'ic'=>$newIc
                    ];
                    $database->getReference("patient/".$key)->update($updateAt);
                }
            }
            }else
            {
                return false;
            }
            //return $record;
        }else{
            return false;

        }
    }
    public static function updateAllAppointmentIC($oldIc,$newIc){
        $database=FirebaseCon::getCon();
        
        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();

            if($fetch_data>0)
            {
                foreach($fetch_data as $key => $row){

                if($row['who']=="My Self")
                {
                    if($row['ic']==$oldIc)
                    {
                    $updateAt=[
                        'ic'=>$newIc
                    ];
                    $database->getReference("appointment/".$key)->update($updateAt);
                }
                }
            }
            }else
            {
                return false;
            }
            //return $record;
        }else{
            return false;

        }
    }
    public static function updatePassword(?string $key = null,?string $password = null)
    {   
 
        $database=FirebaseCon::getCon();
        if(isset($database)){
            $updateAt=[
                'password'=>$password
            ];
            //get connection to firebase
            $postRef_result=$database->getReference("users/".$key)->update($updateAt);
            //check insert success or not
            if(!$postRef_result){
                return false;
            }else{
                return true;
            }     
        }
    }
    public static function verifyToken(?string $key = null)
    {   
        $database=FirebaseCon::getCon();
        if(isset($database)){
            $fetch_data=$database->getReference("users/".$key)->getValue();
            if($fetch_data>0)
            {
                return $fetch_data['updateAt'];
            }
            //no data return
            else{
                return false;
            }
        }else{
           // echo "no database connected";
           return false; 
        }
    }
       
    
    public static function updatedAt(?string $key = null)
    {   
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $updateDate = date('Y-m-d h:i:s');
        $database=FirebaseCon::getCon();
        if(isset($database)){
            $updateAt=[
                'updateAt'=>$updateDate
            ];

            $ref_table="users";
            //get connection to firebase
            $postRef_result=$database->getReference("users/".$key)->update($updateAt);
            //check insert success or not
            if(!$postRef_result){
                return false;
            }else{
                return true;
            }     
        }
    }
    /*
     public static function updatedAt(?string $key = null)
    {   
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $updateDate = date('Y-m-d h:i:s');
        $database=FirebaseCon::getCon();
        if(isset($database)){
            $updateAt=[
                'updateAt'=>$updateDate
            ];

            $ref_table="users";
            //get connection to firebase
            $postRef_result=$database->getReference("users/".$key)->update($updateAt);
            //check insert success or not
            if(!$postRef_result){
                return false;
            }else{
                return true;
            }     
        }
    }*/
    public static function updatedProfileImg(?string $key = null,?string $url = null)
    {   
      
        $database=FirebaseCon::getCon();
        if(isset($database)){
            $updateProfile=[
                'img'=>$url
            ];

            $ref_table="users";
            //get connection to firebase
            $postRef_result=$database->getReference("users/".$key)->update($updateProfile);
            //check insert success or not
            if(!$postRef_result){
                return false;
            }else{
                return true;
            }     
        }
    }
    public static function getUserInfoByEmail(?string $email = null)
    {
        $database=FirebaseCon::getCon();
        if(isset($database)){
            $fetch_data=$database->getReference('users')->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['email']==$email){
                        $i+=1;
                        $row["key"]=$key;
                        return $row;
                    }
                    
                }
                if($i==0)
                    {
                       return false; 
                    }
                
            }
            //no data return
            else{
                return false;
            }
        }else{
           // echo "no database connected";
           return false; 

        }
    }
   
}		