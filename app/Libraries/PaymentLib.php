<?php
namespace App\Libraries;
use App\Libraries\FirebaseCon;

class PaymentLib{
    public static function zoomApiKey(){
        return "ymexxnDEQDeqCjA6GwYYEQ";
    }
    public static function zoomSecretKey(){
        return "fV544AHbZ0YJ2ORzrPuDnHgMadAVCHXXhCni";
    }
    public static function zoomSignInMail(){
        $r=createMeeting($arr);

        return "hengzp-am19@student.tarc.edu.my";

    }
    public static function checkBalance($holdername,$cardnumber,$cvv,$exp){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('visa')->getValue();
            if($fetch_data>0)
            {
                $i=false;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['cardnumber']==$cardnumber&&$row['cvv']==$cvv&&$row['holdername']==$holdername&&$row['expired']==$exp)
                    {
                   
                        if($row['balance']>=40)
                        {
                            return true;
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
    public static function getBalance($holdername,$cardnumber,$cvv,$exp){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('visa')->getValue();
            if($fetch_data>0)
            {
                $i=false;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['cardnumber']==$cardnumber&&$row['cvv']==$cvv&&$row['holdername']==$holdername&&$row['expired']==$exp)
                    {
                   
                        if($row['balance']>=40)
                        {
                            return $row['balance'];
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
    public static function getKey($holdername,$cardnumber,$cvv,$exp){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('visa')->getValue();
            if($fetch_data>0)
            {
                $i=false;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['cardnumber']==$cardnumber&&$row['cvv']==$cvv&&$row['holdername']==$holdername&&$row['expired']==$exp)
                    {
                   
                        return $key;
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
    public static function checkAccountExists($holdername,$cardnumber,$cvv,$exp){
        
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('visa')->getValue();
            if($fetch_data>0)
            {
                $i=false;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['cardnumber']==$cardnumber&&$row['cvv']==$cvv&&$row['holdername']==$holdername&&$row['expired']==$exp)
                    {
                   $i=true;
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
            return null;

        }
    }
}
?>