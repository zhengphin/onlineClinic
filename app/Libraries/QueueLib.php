<?php
namespace App\Libraries;
use App\Libraries\FirebaseCon;

class QueueLib{
    public static function readInventoryData($inventoryID)
{
    $database=FirebaseCon::getCon();
    
    if(isset($database)){
        $fetch_data=$database->getReference('inventory/'.$ID)->getValue();
        $record=array();


        if($fetch_data>0)
        {
           

            return $fetch_data;

        }

        else
        {
            return 0;
        }
        //return $record;
    }else{
        return 0;

    }
}
public static function readQueueData($queueID){
    $database=FirebaseCon::getCon();
    $record=array();
    
    if(isset($database)){
        $fetch_data=$database->getReference('queue/'.$queueID)->getValue();

        if($fetch_data>0)
        {
           // $fetch_data= array_reverse($fetch_data);
            
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
public static function readPatientData($patientkey){
    $database=FirebaseCon::getCon();
    $record=array();
    
    if(isset($database)){
        $fetch_data=$database->getReference('patient/'.$patientkey)->getValue();

        if($fetch_data>0)
        {
           // $fetch_data= array_reverse($fetch_data);
            
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
public static function readSym($queueID){
    $database=FirebaseCon::getCon();
    $record=array();
    
    if(isset($database)){
        $fetch_data=$database->getReference('symptoms')->getValue();

        if($fetch_data>0)
        {
           // $fetch_data= array_reverse($fetch_data);
            
            $i=1;
            foreach($fetch_data as $key => $row)
            {
                    if($row['queueID']==$queueID)
                    {
                    $record[$i]= $row;
                    $record[$i]['key']=$key;
                    $i++;
                    }
            }
            if(empty($record))
            {
                return $record;

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
public static function readServicesByQueueID($queueID){
    $database=FirebaseCon::getCon();
    $record=array();
    
    if(isset($database)){
        $fetch_data=$database->getReference('serviceDetails')->getValue();

        if($fetch_data>0)
        {
           // $fetch_data= array_reverse($fetch_data);
            
            $i=1;
            foreach($fetch_data as $key => $row)
            {
                    if($row['queueID']==$queueID)
                    {
                    $record[$i]= $row;
                    $record[$i]['key']=$key;
                    $i++;
                    }
            }
            if(empty($record))
            {
                return $record;

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
    public static function readOrderDetails($queueID){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('orderDetails')->getValue();

            if($fetch_data>0)
            {
               // $fetch_data= array_reverse($fetch_data);
                
                $i=1;
                foreach($fetch_data as $key => $row)
                {
                        if($row['queueID']==$queueID)
                        {
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;
                        }
                }
                if(empty($record))
                {
                    return $record;

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
    public static function readOrderDetailsByKey($key2){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('orderDetails/'.$key2)->getValue();

            if($fetch_data>0)
            {
               // $fetch_data= array_reverse($fetch_data);
                
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
    
    public static function readDataCompleted($date){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();

            if($fetch_data>0)
            {
               // $fetch_data= array_reverse($fetch_data);
                
                $i=1;
                foreach($fetch_data as $key => $row)
                {
                        if($row['date']==$date&&$row['status']=="completed")
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
    public static function readDataProgress($date){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();

            if($fetch_data>0)
            {
               // $fetch_data= array_reverse($fetch_data);
                
                $i=1;
                foreach($fetch_data as $key => $row)
                {
                        if($row['date']==$date&&$row['status']=="progress")
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
    
    public static function readDataBill($date){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();
                  
            if($fetch_data>0)
            {
                //$fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                        if($row['date']==$date&&$row['status']=="to bill")
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
    public static function readQueueDataByPatientKey($table, $start,$end,$patientkey){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($row['patientkey']==$patientkey&&$row['status']=="completed")
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
            return null;

        }
    }
    public static function readQueueDataByPatientKey3($tablename,$start,$end,$patientkey){
        
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
                    if($row['patientkey']==$patientkey&&$row['status']=="completed")
                    {
                     
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                    }
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
            return $record;

        }
    }
    public static function readQueueDataByPatientKey2($tablename,$start,$end,$patientkey){
        
        $database=FirebaseCon::getCon();
        $record=array();
        $record2=array();
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();

            if($fetch_data>0)
            {

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($row['patientkey']==$patientkey&&$row['status']=="completed")
                    {
                     
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                    }
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
                }
            }
                    return $record2;
            //return $record;
        }else{
            return $record;

        }
    }
    public static function readQueueDataByPatientKeyBySympAndName($tablename,$start,$end,$patientkey,$searchname){
        
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            $fetch_data2=$database->getReference('symptoms')->getValue();

            if($fetch_data>0)
            {
                $fetch_data2= array_reverse($fetch_data2);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($i>=$start && $i<=$end && $row['patientkey']==$patientkey&&$row['status']=="completed")
                    {
                        foreach($fetch_data2 as $key2 => $row2)
                        {
                        if($key==$row2['queueID']&& strtoupper($row2['name'])==strtoupper($searchname))
                            {
                                $record[$i]= $row2;
                                $record[$i]['key']=$key;
                                $i++;
                            }
                        }
                       
                    }
                   
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
    public static function readQueueDataByPatientKeyBySymp($tablename,$start,$end,$patientkey){
        
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            $fetch_data2=$database->getReference('symptoms')->getValue();

            if($fetch_data>0)
            {
                $fetch_data2= array_reverse($fetch_data2);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($i>=$start && $i<=$end && $row['patientkey']==$patientkey&&$row['status']=="completed")
                    {
                        foreach($fetch_data2 as $key2 => $row2)
                        {
                        if($key==$row2['queueID'])
                            {
                                $record[$i]= $row2;
                                $record[$i]['key']=$key;
                                $i++;
                            }
                        }
                       
                    }
                   
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
    /*
    public static function readQueueDataByPatientKey($patientkey){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();
                  
            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                        if($row['patientkey']==$patientkey&&$row['status']=="completed")
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
    }*/
    public static function readDataWaiting($date){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();
                  
            if($fetch_data>0)
            {
                //$fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                        if($row['date']==$date&&$row['status']=="waiting")
                        {
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;
                        }
                }
                if(empty($record))
                {
                    return "false";

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
    public static function readDataToday($date){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();
                  
            if($fetch_data>0)
            {
                //$fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                        if($row['date']==$date)
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
    public static function checkQueue($key2,$date){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['patientkey']==$key2&&$row['date']==$date&&$row['status']=="waiting"){
                      return false;
                       
                    }
                  
                }
              return true;
                
            }
            //no data return
            else{
                return true;
            }
        }else{
            return false;
        }
    }
}
?>