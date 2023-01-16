<?php
namespace App\Libraries;
use App\Libraries\FirebaseCon;
use App\Libraries\Hash;

use Kreait\Firebase\Query;

class AdminLib{
    public static function checkRegisterServiceID($id,$password){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('admin')->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['id']==$id){
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
    public static function countRecords($tablename){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                   $i+=1;
                }
              return $i;
                
            }
            //no data return
            else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    public static function countRecordsByPatient($tablename,$patientkey){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['patientkey']==$patientkey&&$row['status']=="completed")
                    {
                        $i+=1;

                    }
                }
              return $i;
                
            }
            //no data return
            else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    
    public static function countRecordsByPatientBySymDataByName($tablename,$patientkey,$searchname){
        //queue //patient key
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            $fetch_data2=$database->getReference('symptoms')->getValue();

            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['patientkey']==$patientkey&&$row['status']=="completed")
                    {
                        foreach($fetch_data2 as $key2 => $row2)
                        {
                        if($key==$row2['queueID']&&strtoupper($row2['name'])==strtoupper($searchname))
                            {
                                $i+=1;

                            }
                        }
                    }
                }
              return $i;
                
            }
            //no data return
            else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    public static function countRecordsByPatientBySymData($tablename,$patientkey){
        //queue //patient key
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            $fetch_data2=$database->getReference('symptoms')->getValue();

            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['patientkey']==$patientkey&&$row['status']=="completed")
                    {
                        foreach($fetch_data2 as $key2 => $row2)
                        {
                        if($key==$row2['queueID'])
                            {
                                $i+=1;

                            }
                        }
                    }
                }
              return $i;
                
            }
            //no data return
            else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    public static function countRecordsStatus($tablename,$status){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                  if($row['status']==$status)
                  {
                    $i+=1;

                  }
                }
              return $i;
                
            }
            //no data return
            else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    public static function paginationRecord($tablename,$start,$end){
        
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
                    if($i>=$start && $i<=$end)
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

 
}
?>
