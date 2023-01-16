<?php
namespace App\Libraries;
use App\Libraries\FirebaseCon;
use App\Libraries\Hash;
use Kreait\Firebase\Query;

class EventLib{
    public static function readDataByKeySpecify($key2){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('event')->getValue();

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
    public static function getEvent(){
        
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('event')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);
                date_default_timezone_set('Asia/Kuala_Lumpur');
                $TodayDate = date('Y-m-d');
                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($row['expiryDate']>=$TodayDate)
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

 
}
?>
