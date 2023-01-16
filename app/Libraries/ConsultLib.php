<?php
namespace App\Libraries;
use App\Libraries\FirebaseCon;

class ConsultLib{
    public static function getRoomInfo($roomID){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();
            if($fetch_data>0)
            {
                $i=false;
                
                foreach($fetch_data as $key => $row)
                {
                   
                     if(isset($row['room'])){
                        if($row['room']==$roomID)
                        {
                            $record[0]= $row;
                            $record[0]['key']=$key;
                            return  $record[0];
                        }
                     }
                    
                }
              return false;
                
            }
            //no data return
            else{
                return false;
            }
        }else{
            return false;
        }
    }
    public static function checkRoomSessionStaff($roomID){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();
            if($fetch_data>0)
            {
                $i=false;
                
                foreach($fetch_data as $key => $row)
                {
                   
                        if(isset($row['payment'])){
                            if($row['payment']=="paid")
                            {
                                if($row['room']==$roomID)
                                {
                                   if($row['session']=="Not for the moment")
                                   {
                                    $i=true;
                                   }
                                }

                            }

                        }
                    
                }
              return $i;
                
            }
            //no data return
            else{
                return false;
            }
        }else{
            return false;
        }
    }
   
    public static function checkRoomStaff($roomID){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();
            if($fetch_data>0)
            {
                $i=false;
                
                foreach($fetch_data as $key => $row)
                {
                   
                        if(isset($row['payment'])){
                            if($row['payment']=="paid")
                            {
                                if($row['room']==$roomID)
                                {
                                    $i=true;
                                }

                            }

                        }
                    
                }
              return $i;
                
            }
            //no data return
            else{
                return false;
            }
        }else{
            return false;
        }
    }
    public static function readAllDataToday($start,$end){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);
                date_default_timezone_set('Asia/Kuala_Lumpur');
                $today = date('Y-m-d');
                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($row['mode']=="E-Consult"&&$row['status']=="approved"&&$row['date']==$today)
                    {
                        if(isset($row['payment']))
                        if($row['payment']=="paid")
                        {
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;
                        }
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
    public static function readAllData($start,$end){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($row['mode']=="E-Consult"&&$row['status']=="approved")
                    {
                        if(isset($row['payment']))
                        if($row['payment']=="paid")
                        {
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;
                        }
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
    public static function readData($user, $start,$end){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($row['user']==$user&&$row['mode']=="E-Consult"&&$row['status']=="approved")
                    {
                        if(isset($row['payment']))
                        if($row['payment']=="paid")
                        {
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;
                        }
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
    
    public static function countAllERecords($tablename){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    
                    
                        if(isset($row['payment'])){
                            if($row['payment']=="paid")
                            {
                                $i+=1;

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
                        if(isset($row['payment'])){
                            if($row['payment']=="paid")
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
    public static function checkRoom($roomID,$user){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();
            if($fetch_data>0)
            {
                $i=false;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['user']==$user)
                    {
                        if(isset($row['payment'])){
                            if($row['payment']=="paid")
                            {
                                if($row['room']==$roomID)
                                {
                                    $i=true;
                                }

                            }

                        }
                    }
                }
              return $i;
                
            }
            //no data return
            else{
                return false;
            }
        }else{
            return false;
        }
    }
    public static function checkRoomSession($roomID,$user){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();
            if($fetch_data>0)
            {
                $i=false;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['user']==$user)
                    {
                        if(isset($row['payment'])){
                            if($row['payment']=="paid")
                            {
                                if($row['room']==$roomID)
                                {
                                   if($row['session']=="Not for the moment")
                                   {
                                    $i=true;
                                   }
                                }

                            }

                        }
                    }
                }
              return $i;
                
            }
            //no data return
            else{
                return false;
            }
        }else{
            return false;
        }
    }
   
}
?>