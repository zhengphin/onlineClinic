<?php
namespace App\Libraries;
use App\Libraries\FirebaseCon;

class InventoryLib{
  
    public static function paginationRecordExpired($tablename,$start,$end){
        
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
                    date_default_timezone_set('Asia/Kuala_Lumpur');
                    $today = date('Y-m-d');
                 
                    if($row['expiryDate']<$today)
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
    public static function paginationRecordSearchName($tablename,$start,$end,$field,$value){
        
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
    public static function readDataByKey($key2){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('inventory')->getValue();

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
    public static function readDataByNameGetQuantity($name){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('inventory')->getValue();
            $i=1;
            if($fetch_data>0)
            {
            
                foreach($fetch_data as $key => $row)
                {
                       if($row['medicineName']==$name)
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
     
}
?>