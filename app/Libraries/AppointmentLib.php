<?php
namespace App\Libraries;
use App\Libraries\FirebaseCon;

class AppointmentLib{
    
    public static function countRecordsPayment($tablename,$field,$value){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row[$field]==$value&&$row['mode']=="E-Consult"&&$row['status']=="approved")

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
    public static function countRecords($tablename,$field,$value){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row[$field]==$value)
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
    public static function countRecordsMulti($patientkey){
        
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();
    
            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);
    
                $i=0;
                foreach($fetch_data as $key => $row)
                {
                    if($row['patientkey']==$patientkey&&$row['status']=="completed")
                    {
                     
                        $i++;
                    }
                   
                }
                return $i;
            }else
            {
                return $i;
            }
            //return $record;
        }else{
            return $i;
    
        }
    }
    
    public static function paginationRecord($tablename,$start,$end,$field,$value){
        
        $database=FirebaseCon::getCon();
        $record=array();
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            $fetch_data= array_reverse($fetch_data);

            if($fetch_data>0)
            {
                $i2=1;

                foreach($fetch_data as $key => $row)
                {
                    /*
                    if($i>=$start && $i<=$end && $row[$field]==$value)
                    {
                        //print_r($fetch_data[$key]);
                        //$record=$record+$fetch_data[$key];
                        //$temp=array('key',$key);
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                    }*/
                    if($row[$field]==$value)
                    {           
                        $record[$i2]= $row;
                        $record[$i2]['key']=$key;
                        $i2++;
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
               
            }
            else
            {
                return $record;
            }
            //return $record;
        }else{
            return null;

        }
    }
    public static function checkAppointmentTimes($email){

        $database=FirebaseCon::getCon();
        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['user']==$email&&$row['status']=="pending"){
                        $i+=1;
                    }
                    
                }
                if($i>1){
                    return false;
                }
                if($i==0||$i==1)
                    {
                       return true; 
                    }
                
            }
            //no data return
            else{
                return true;
            }
        }else{
           // echo "no database connected";
           return false; 
        }
    }
    public static function checkPatientExistsByIc($ic){

        $database=FirebaseCon::getCon();
        if(isset($database)){
            $fetch_data=$database->getReference('patient')->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['ic']==$ic){
                        $i+=1;
                        return false;
                        //already register so no need
                    }
                }
                if($i==0)
                    {
                       return true; 
                       //no yet register so need register
                    }
                
            }
            //no data return
            else{
                return true;
            }
        }else{
           // echo "no database connected";
           return false; 
        }
    }
}
?>