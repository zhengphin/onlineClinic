<?php
namespace App\Libraries;
use App\Libraries\FirebaseCon;

class PatientLib{
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
    
    public static function readDataByIc($ic,$start,$end){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('patient')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                        if($row['ic']==$ic)
                        {
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;
                        }
                }
                if(empty($record))
                {
                    return false;

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
                return false;
            }
            //return $record;
        }else{
            return false;

        }
    }
    public static function readDataByKey($key2){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('patient')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                        if($key==$key2)
                        {
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;
                        }
                }
                if(empty($record))
                {
                    return false;

                }
                    return $record;
                
            }else
            {
                return false;
            }
            //return $record;
        }else{
            return false;

        }
    }
    public static function readAppDataByKey($key2){
        $database=FirebaseCon::getCon();
        
        if(isset($database)){
            $fetch_data=$database->getReference('appointment/'.$key2)->getValue();

            if($fetch_data>0)
            {

               return $fetch_data;
            }else
            {
                return false;
            }
            //return $record;
        }else{
            return false;

        }
    }
    public static function readPatientKeyByIC($ic){
        $database=FirebaseCon::getCon();
        
        if(isset($database)){
            $fetch_data=$database->getReference('patient')->getValue();

            if($fetch_data>0)
            {
                foreach($fetch_data as $key => $row){

                if($row['ic']==$ic)
                {
                    return $key;
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
    public static function readData($start,$end){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('patient')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                   
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;
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
            return null;

        }
    }
    public static function CheckPatientRegistered($ic){
        $database=FirebaseCon::getCon();
        
        if(isset($database)){
            $fetch_data=$database->getReference('patient')->getValue();

            if($fetch_data>0)
            {

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                   
                if($row['ic']==$ic)
                {
                    return true;//already register at both side
                    
                }

                }
                return false;
              
            }else
            {
                return false;
            }
            //return $record;
        }else{
            return false;

        }
    }
}
?>