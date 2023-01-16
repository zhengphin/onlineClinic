<?php

namespace App\Validation;
use App\Libraries\FirebaseCon;

class RegisterRules
{
    public function valid_email2($str = null)
    {
        if (! is_string($str)) {
            return false;
        }
    if($str="")
    {
        return true;
    }

    }
    //password validation
    public function passwordCustom(?string $str = null): bool
    {
        return (bool) preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,30}$/', $str ?? '');
    }
    //contact number validation
    public function checkContact(?string $str = null): bool
    {
        return (bool) preg_match('/^(01)[0-46-9]*[0-9]{8,9}$/', $str ?? '');

    }
    //ic number validation
    public function checkIC(?string $str = null): bool
    {
        return (bool) is_numeric($str);
    }
    //postcode validation
    public function checkPostcode(?string $str = null): bool
    {
        return (bool) is_numeric($str);
    }
    //home address validation
    public function checkHomeAddress(?string $str = null): bool
    {
        return (bool) preg_match('/^[a-zA-Z0-9,. ]+$/', $str ?? '');
    }
    public function checkPrice(?string $str = null): bool
    {
        $pattern = '/^\d+(\.\d{2})?$/';
        return (bool) preg_match($pattern, $str);
    }
    public function checkQuantity(?string $str = null)
    {
        if($str<=0)
        {
            return  false;
        }
        if(is_int($str))
        {
            return true;

        }
    }
    public function priceSmallThanZero(?string $str = null)
    {
        if($str<=0)
        {
            return  false;
        }else{
            return true;

        }
    }
     //tablename 
    //field in the table
    //value of the field
    public function checkExist(?string $str = null,?string $tablenfield = null): bool
    {
        $database=FirebaseCon::getCon();
        //split table name and table field
        // array[0] is the field name
        // array[1] is the table name
        $array = explode (",", $tablenfield);
        $fieldname=$array[0];
        $tablename=$array[1];


        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            if($str=="")
            {
                return true;
            }
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row[$fieldname]==$str){
                        $i+=1;
                        return false;
                    }
                   
                }
                if($i==0)
                {
                   return true; 
                }
                
            }
            //no data return
            else{
                return true;
            }
        }else{
            echo "no database connected";
        }
    }
    public function checkExistProfile(?string $str = null,?string $tablenfieldnkey = null): bool
    {
        $database=FirebaseCon::getCon();
        //split table name and table field
        // array[0] is the field name
        // array[1] is the table name
        $array = explode (",", $tablenfieldnkey);
        $fieldname=$array[0];
        $tablename=$array[1];
        $keyInput=$array[2];


        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row[$fieldname]==$str){
                       if($key==$keyInput){
                        return true;
                       }
                       else{
                        return false;
                       }
                    }else{
                        //is unique so true
                        return true;
                    }
                    
                }
            }
            //no data return
            else{
                return true;
            }
        }else{
            echo "no database connected";
        }
    }
    public function checkRegisterServiceEmail(?string $str = null): bool
    {
        $database=FirebaseCon::getCon();
       
        if(isset($database)){
            $fetch_data=$database->getReference('users')->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row['email']==$str){
                        $i+=1;
                        return true;
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
            echo "no database connected";
        }
    }
    public function checkNotExist(?string $str = null,?string $tablenfield = null): bool
    {
        $database=FirebaseCon::getCon();
        //split table name and table field
        // array[0] is the field name
        // array[1] is the table name
        $array = explode (",", $tablenfield);
        $fieldname=$array[0];
        $tablename=$array[1];


        if(isset($database)){
            $fetch_data=$database->getReference($tablename)->getValue();
            if($fetch_data>0)
            {
                $i=0;
                
                foreach($fetch_data as $key => $row)
                {
                    if($row[$fieldname]==$str){
                        $i+=1;
                        return true;
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
            echo "no database connected";
        }
    }
    public static function checkPassword(?string $str = null,?string $db_password = null){
        
        if(password_verify($str,$db_password)){
            return true;
        }else{
            return false;
        }
    }
    public static function checkAppDate(?string $str = null){
        
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $today = date('Y-m-d');
        if ($str < $today) {
            return false;
        }else{
            return true;
        }
    }
    public static function checkAppTime(?string $str = null){
        //9am to 11pm
        $time=str_replace(':', '.', $str);
        if($time<9.00||$time>23.00)
        {
            return false;
        }
        else{
            return true;
        }
      
    }
    public static function checkAppTime2(?string $str = null,?string $date = null){
        //Get total current minutes
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $currentTime = date('H:i');
        $currentTime=str_replace(':', '.', $current);
        $str_arr = explode (".", $currentTime); 
        $min=$str_arr[0]*60;
        $currentTimeTotalMinutes= $min+$str_arr[1];;
        ///////////////////////////////////////////
        //Get total booking minutes
        $book_time=str_replace(':', '.', $str);
        $str_arr2 = explode (".", $book_time); 
        $min2=$str_arr2[0]*60;
        $BookingTimeTotalMinutes= $min2+$str_arr2[1];
        /////////////////////
        $today = date('Y-m-d');
        if($date>$today)
        {
            return false;
        }
        else{
            if($currentTimeTotalMinutes>$BookingTimeTotalMinutes)
            {
                return false;
            }else{
                //early 30 min
                $balance=$BookingTimeTotalMinutes-$currentTimeTotalMinutes;
                if($balance<30)
                {
                    return false;
                }else{
                    return false;
                }
            }
        }

        
    }
    public static function checkAppDateHoliday(?string $str = null){
        
        
        $database=FirebaseCon::getCon();
        
        if(isset($database)){
        $fetch_data=$database->getReference('holiday')->getValue();
        if($fetch_data>0)
            {
                $i=0;
                foreach($fetch_data as $key => $row)
                {
                    if($row['date']==$str){
                        $i+=1;
                        return false;
                    }
                  
                }
                if($i==0)
                {
                   return true; 
                }
                
            }
            //no data return
            else{
                return true;
            }
        }else{
            //no database connected
            return true;
        }
        if ($str < $today) {
            return false;
        }else{
            return true;
        }
    }
}		