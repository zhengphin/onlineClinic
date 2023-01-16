<?php 
use App\Libraries\FirebaseCon;
function readAllMeetToday(){
    $database=FirebaseCon::getCon();
    $record=array();
    
    if(isset($database)){
        $fetch_data=$database->getReference('appointment')->getValue();

        if($fetch_data>0)
        {
            $fetch_data= array_reverse($fetch_data);
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $today = date('Y-m-d');
            $i=0;
            foreach($fetch_data as $key => $row)
            {
                if($row['mode']=="E-Consult"&&$row['status']=="approved"&&$row['date']==$today)
                {
                    if(isset($row['payment']))
                    if($row['payment']=="paid")
                    {
                    if($row['session']=="Not for the moment")
                    {
                      
                        $i++;
                    }
               
                    }
                }
        
           
                return $i;
            }
        }else
        {
            return $i;
        }
        //return $record;
    }else{
        return $i;

    }
}
function CountreadQueueDataByPatientKey($patientkey){
        
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
function getInventoryQuantity($ID)
{
    $database=FirebaseCon::getCon();
    
    if(isset($database)){
        $fetch_data=$database->getReference('inventory/'.$ID)->getValue();
        $record=array();

        date_default_timezone_set('Asia/Kuala_Lumpur');
        $TodayDate = date('Y-m-d');

        if($fetch_data>0)
        {
           

            return $fetch_data['quantity'];

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
function getInventory()
{
    $database=FirebaseCon::getCon();
    
    if(isset($database)){
        $fetch_data=$database->getReference('inventory')->getValue();
        $record=array();

        date_default_timezone_set('Asia/Kuala_Lumpur');
        $TodayDate = date('Y-m-d');
        $i=1;

        if($fetch_data>0)
        {
            foreach($fetch_data as $key => $row){

            if($row['expiryDate']>$TodayDate)
            {
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
function diffDay($expiryDate)
{
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $today = date('Y-m-d');
    $today=date_create($today);
    $expiry=date_create($expiryDate);
    $diff=date_diff($today,$expiry);
    return $diff->format("%R%a days");
}
function checkAppDate($date){
        
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $today = date('Y-m-d');
    if ($date<=$today) {
        return false;
    }
    else{
        return true;
    }
}
function checkIntheQueue($patientkey){
    $database=FirebaseCon::getCon();
    
    if(isset($database)){
        $fetch_data=$database->getReference('queue')->getValue();
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $TodayDate = date('Y-m-d');
        if($fetch_data>0)
        {
            foreach($fetch_data as $key => $row){

            if($row['patientkey']==$patientkey&&$row['status']=="waiting"&&$row['date']=$TodayDate)
            {
                return true;
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
 function readPatientKeyByIC($ic){
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
function getTodayDate()
{
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $TodayDate = date('Y-m-d');
    return $TodayDate;
}
function countQueue($status,$date)
{
        $database=FirebaseCon::getCon();      
        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                
                        if($row['status']==$status&&$row['date']==$date)
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
function waitingRoom()
{
        $database=FirebaseCon::getCon();      
        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if(isset($row['payment']))
                    {
                        if($row['payment']=="paid")
                        {
                            if($row['room']=="no")
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
function countRecord2($tablename,$field,$value)
{
        $database=FirebaseCon::getCon();      
        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row[$field]==$value&&$row['status']=="approved"&&$row['mode']=="E-Consult")
                    {
                        if($row['payment']=="unpaid")
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
    function countRecord($tablename,$field,$value)
    {
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
    function countRecord3($tablename,$field,$value)
    {
            $database=FirebaseCon::getCon();      
            if(isset($database)){
                $fetch_data=$database->getReference($tablename)->getValue();
                if($fetch_data>0)
                {
                    $i=0;
                    
                    foreach($fetch_data as $key => $row)
                    {
                        if($row[$field]==$value&&$row['status']=="pending")
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
    //return the error message to the form
   function display_error($validation,$field)
   {
   if($validation->hasError($field)){
       return $validation->getError($field);
   }else{
       return false;
   }
   }
   function timeDisplay($time)
   {

    $date=date("h:i", strtotime($time));
    $time=str_replace(':', '.', $time);
    if($time>12.00&&$time<=24.00)
    {
        return $date." PM";
    }else{
        return $date." AM";
    }

   }
   function getUserInfoByEmail($email,$field)
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
                        $data=$row[$field];
                        return $data;
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
    function getPatientInfoByEmail($key2,$field)
    {
            $database=FirebaseCon::getCon();
            if(isset($database)){
                $fetch_data=$database->getReference('patient')->getValue();
                if($fetch_data>0)
                {
                    $i=0;
                    
                    foreach($fetch_data as $key => $row)
                    {
                        if($key==$key2){
                            $i+=1;
                            $data=$row[$field];
                            return $data;
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
        function getPatientKeyByIc($ic)
        {
                $database=FirebaseCon::getCon();
                if(isset($database)){
                    $fetch_data=$database->getReference('patient')->getValue();
                    if($fetch_data>0)
                    {
                        
                        foreach($fetch_data as $key => $row)
                        {
                            if($row['ic']==$ic){
                                
                                return $key;
                            }
                            
                        }
                        return false;
                        
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
            
   ?>