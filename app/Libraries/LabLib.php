<?php
namespace App\Libraries;
use App\Libraries\FirebaseCon;

class LabLib{
    public static function readData($patientkey, $start,$end){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('lab')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($row['patientkey']==$patientkey)
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
    public static function updatedReportUrl(?string $key = null,?string $url = null)
    {   
      
        $database=FirebaseCon::getCon();
        if(isset($database)){
            $updateProfile=[
                'report'=>$url
            ];

            $ref_table="lab";
            //get connection to firebase
            $postRef_result=$database->getReference("lab/".$key)->update($updateProfile);
            //check insert success or not
            if(!$postRef_result){
                return false;
            }else{
                return true;
            }     
        }
    }

    public static function readDataByKey($key2){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('lab')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                        if($row['patientkey']==$key2)
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
    public static function readDataByKeySpecify($key2){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('lab')->getValue();

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
}
?>