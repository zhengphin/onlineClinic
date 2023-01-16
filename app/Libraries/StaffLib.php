<?php
namespace App\Libraries;
use App\Libraries\FirebaseCon;
use App\Libraries\Hash;
use Kreait\Firebase\Query;

class StaffLib{
    //status
    public static function paginationRecord1($tablename,$start,$end,$field,$value){

$database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($row[$field]==$value)
                    {
                        //print_r($fetch_data[$key]);
                        //$record=$record+$fetch_data[$key];
                        //$temp=array('key',$key);
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;
                    }
                }

               if(empty($record))
                {
                    return $record;

                }else{
                    $count=0;
                    for ($x = $start; $x <= $end; $x++) {
                     
                        if(isset($record[$x])) {
                            $record2[$count]=$record[$x];
                            $count++;
                        }
                       
                    }
                    return $record2;
                }
            }else
            {
                return $record;
            }
            //return $record;
        }else{
            return $record;

        }
    }
    public static function paginationRecord($tablename,$start,$end,$field,$value){
        
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($i>=$start && $i<=$end && $row[$field]==$value)
                    {
                        //print_r($fetch_data[$key]);
                        //$record=$record+$fetch_data[$key];
                        //$temp=array('key',$key);
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                    }
                    $i++;
                }
                return $record;
            }else
            {
                return $record;
            }
            //return $record;
        }else{
            return $record;

        }
    }
    public static function paginationRecord2($tablename,$start,$end,$field,$value,$field2,$value2){
        
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($i>=$start && $i<=$end && $row[$field]==$value&&$row[$field2]==$value2)
                    {
                        //print_r($fetch_data[$key]);
                        //$record=$record+$fetch_data[$key];
                        //$temp=array('key',$key);
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                    }
                    $i++;
                }
                return $record;
            }else
            {
                return $record;
            }
            //return $record;
        }else{
            return $record;

        }
    }
    public static function paginationRecord3($tablename,$start,$end,$field,$value,$field2,$value2){
        
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($row[$field]==$value&&$row[$field2]==$value2)
                    {
                       
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;

                    }
                }
                if(empty($record))
                {
                    return $record;

                }else{
                    $count=0;
                    for ($x = $start; $x <= $end; $x++) {
                     
                        if(isset($record[$x])) {
                            $record2[$count]=$record[$x];
                            $count++;
                        }
                       
                    }
                    return $record2;
                }
            }else
            {
                return $record;
            }
            //return $record;
        }else{
            return $record;

        }
    }
    public static function paginationRecordSearchIC($tablename,$start,$end,$field,$value,$field2,$value2){
        
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($i>=$start && $i<=$end && $row[$field]==$value&&$row[$field2]==$value2)
                    {
                        //print_r($fetch_data[$key]);
                        //$record=$record+$fetch_data[$key];
                        //$temp=array('key',$key);
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                    }
                    $i++;
                }
                return $record;
            }else
            {
                return $record;
            }
            //return $record;
        }else{
            return $record;

        }
    }
    public static function paginationRecordSearchIC1($tablename,$start,$end,$field,$value,$field2,$value2){
        
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($row[$field]==$value&&$row[$field2]==$value2)
                    {
                        //print_r($fetch_data[$key]);
                        //$record=$record+$fetch_data[$key];
                        //$temp=array('key',$key);
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;

                    }
                }
                if(empty($record))
                {
                    return $record;

                }else{
                    $count=0;
                    for ($x = $start; $x <= $end; $x++) {
                     
                        if(isset($record[$x])) {
                            $record2[$count]=$record[$x];
                            $count++;
                        }
                       
                    }
                    return $record2;
                }
            }else
            {
                return $record;
            }
            //return $record;
        }else{
            return $record;

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
            $postRef_result=$database->getReference("staff/".$key)->update($updateAt);
            //check insert success or not
            if(!$postRef_result){
                return false;
            }else{
                return true;
            }     
        }
    }
    public static function checkRegisterStaff($email,$password){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('staff')->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['email']==$email){
                        $i+=1;
                        $check_password=Hash::check($password,$row['password']);
                        if($check_password==true)
                        {
                            return true;

                        }else{
                            return false;
                        }
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
            return false;
        }
    }
    public static function updatedProfileImg(?string $key = null,?string $url = null)
    {   
      
        $database=FirebaseCon::getCon();
        if(isset($database)){
            $updateProfile=[
                'img'=>$url
            ];

            $ref_table="staff";
            //get connection to firebase
            $postRef_result=$database->getReference("staff/".$key)->update($updateProfile);
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
            $fetch_data=$database->getReference('staff')->getValue();
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
    public static function getHoliday(){
        
        $database=FirebaseCon::getCon();
        $record=array();

        if(isset($database)){
            $fetch_data=$database->getReference('holiday')->getValue();
            $i=0;
            if($fetch_data>0)
            {
                foreach($fetch_data as $key => $row)
                {
                    

                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                    $i++;
                }
              return $record;  
            }
            //no data return
            else{
                return $record;
            }
        }else{
            return false;
        }
    }
}


?>
