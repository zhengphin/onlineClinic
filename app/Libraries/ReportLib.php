<?php
namespace App\Libraries;
use App\Libraries\FirebaseCon;

class ReportLib{
    public static function almostExpiredInventory(){
        
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('inventory')->getValue();

            if($fetch_data>0)
            {
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $today = date("Y-m-d");
                //$past=date('Y-m-d', strtotime('-30 day', strtotime($today)));
                
                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    //expired
                    
                    $date2=date_create($row['expiryDate']);
                    $date1=date_create($today);
                    $diff=date_diff($date1,$date2);
                    $left=$diff->format("%R%a");
                    

                    //if($row['expiryDate']<=$today||$left<30)
                    if($left>=0&&$left<=30)
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
    public static function lowInventory(){
        
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('inventory')->getValue();

            if($fetch_data>0)
            {

                $i=1;
                foreach($fetch_data as $key => $row)
                {
                    if($row['quantity']<=10)
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
     function getProductItem()
    {
       //first get product
             
        $database=FirebaseCon::getCon();
        $productRecord=array();
        $record=array();
        if(isset($database)){
            $fetch_data=$database->getReference('inventory')->getValue();

            if($fetch_data>0)
            {

                $i=0;
                foreach($fetch_data as $key => $row)
                {
                    $productRecord[$i]['medicineName']=$row['medicineName'];    
                    $productRecord[$i]['count']=0;    

                    $i++;
                }
                return $productRecord;
            }else
            {
                return $productRecord;
            }
            //return $record;
        }else{
            return $productRecord;
        }
    }
    public static function topsalesproduct()
    {
        $report = new ReportLib();
        $productItem=$report->getProductItem();
        $database=FirebaseCon::getCon();
        $record=array();
        if(isset($database)){
            $fetch_data=$database->getReference('orderDetails')->getValue();

            if($fetch_data>0)
            {

                $i=0;
                foreach($fetch_data as $key => $row)
                {
                    foreach($productItem as $key2 => $row2)
                    {
                        //itemname is orderdetails
                        if($row['itemName']==$row2['medicineName'])
                        {
                        $productItem[$key2]['count']+=$row['quantity'];
                        }
                      
                    }
                }
                $sorting = array_column($productItem, 'count');
                $price=array_multisort($sorting, SORT_DESC, $productItem);
                return $productItem;
            }else
            {
                return $productItem;
            }
            //return $record;
        }else{
            return $productItem;
        }
    }

    public static function totalWalkInRevenue()
    {
       
             
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
                   
                    if($row['status']=="completed")
                    {
                        
                        $i+=$row['grant'];
                        
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
    public static function totalOnlineConsultationRevenue()
    {
       
             
        $database=FirebaseCon::getCon();
        $record=array();
       

        if(isset($database)){
            $fetch_data=$database->getReference('appointment')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=0;
                foreach($fetch_data as $key => $row)
                {
                   
                    if($row['mode']=="E-Consult")
                    {
                        if(isset($row['payment']))
                        {
                            if($row['payment']=="paid")
                            {
                                $i++;

                            }
                        }
                    }
                      
                    
                  
                }
                return $i*40;
            }else
            {
                return $i;
            }
            //return $record;
        }else{
            return $i;
        }
    }
    public static function totalOnlineUser()
    {
       
             
        $database=FirebaseCon::getCon();
        $record=array();
       

        if(isset($database)){
            $fetch_data=$database->getReference('users')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=0;
                foreach($fetch_data as $key => $row)
                {
                   
                     
                        $i++;
                    
                  
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
    public static function totalClinicUser()
    {
       
             
        $database=FirebaseCon::getCon();
        $record=array();
       

        if(isset($database)){
            $fetch_data=$database->getReference('patient')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=0;
                foreach($fetch_data as $key => $row)
                {
                   
                     
                        $i++;
                    
                  
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
    public static function totalvistor()
    {
       
             
        $database=FirebaseCon::getCon();
        $record=array();
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $TodayDate = date('Y-m-d');
        $past=date('Y-m-d', strtotime('-30 day', strtotime($TodayDate)));

        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=0;
                foreach($fetch_data as $key => $row)
                {
                    if($row['date']<=$TodayDate&&$row['date']>=$past)
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
    public static function totalvistorweek()
    {
       
             
        $database=FirebaseCon::getCon();
        $record=array();
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $TodayDate = date('Y-m-d');
        $past=date('Y-m-d', strtotime('-7 day', strtotime($TodayDate)));

        if(isset($database)){
            $fetch_data=$database->getReference('queue')->getValue();

            if($fetch_data>0)
            {
                $fetch_data= array_reverse($fetch_data);

                $i=0;
                foreach($fetch_data as $key => $row)
                {
                    if($row['date']<=$TodayDate&&$row['date']>=$past)
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
   public static function countTopThreeWalkingServices(){
        $database=FirebaseCon::getCon();
        $record=array();
        
        if(isset($database)){
            $fetch_data=$database->getReference('serviceDetails')->getValue();

            if($fetch_data>0)
            {

                //$i=1;
                $countVaccination=$countGynae=$countBloodTest=$countMinorSurgery=$countXray=0;
                $countGeneral=$countMedicalCheck=$countUltraSound=$countSpirometry=$countCircumcision=
                $countAntenatal=
                $countAudiometry=0;

                foreach($fetch_data as $key => $row)
                {
                    if($row['servicesName']=="General Consultation and Treament")
                    {
                       // $record[$i]= $row;
                       //$record[$i]['key']=$key;
                       $countGeneral+=$countGeneral++;
                       $record[1]['services']=$row['servicesName'];
                       $record[1]['count']=$countGeneral;

                    }elseif($row['servicesName']=="Immunization and Vaccination"){
                        $countVaccination+=$countVaccination++;
                        $record[2]['services']=$row['servicesName'];
                        $record[2]['count']=$countVaccination;
                    }
                    elseif($row['servicesName']=="Blood and Urine Test"){
                        $countBloodTest+=$countBloodTest++;
                        $record[3]['services']=$row['servicesName'];
                        $record[3]['count']=$countBloodTest;
                    }
                    elseif($row['servicesName']=="Minor Surgery"){
                        $countMinorSurgery+=$countMinorSurgery++;
                        $record[4]['services']=$row['servicesName'];
                        $record[4]['count']=$countMinorSurgery;
                    }
                    elseif($row['servicesName']=="X-ray"){
                        $countXray+=$countXray++;
                        $record[5]['services']=$row['servicesName'];
                        $record[5]['count']=$countXray;
                    }
                    elseif($row['servicesName']=="Medical Check Up"){
                        $countMedicalCheck+=$countMedicalCheck++;
                        $record[6]['services']=$row['servicesName'];
                        $record[6]['count']=$countXray;
                    }
                    
                    elseif($row['servicesName']=="Ultra Sound"){
                        $countUltraSound+=$countUltraSound++;
                        $record[7]['services']=$row['servicesName'];
                        $record[7]['count']=$countUltraSound;
                    }
                    elseif($row['servicesName']=="Spirometry"){
                        $countSpirometry+=$countSpirometry++;
                        $record[8]['services']=$row['servicesName'];
                        $record[8]['count']=$countSpirometry;
                    }
                    elseif($row['servicesName']=="Circumcision"){
                        $countCircumcision+=$countCircumcision++;
                        $record[9]['services']=$row['servicesName'];
                        $record[9]['count']=$countCircumcision;
                    }
                    elseif($row['servicesName']=="Antenatal and Postnatal Carea"){
                        $countAntenatal+=$countAntenatal++;
                        $record[10]['services']=$row['servicesName'];
                        $record[10]['count']=$countAntenatal;
                    }
                    elseif($row['servicesName']=="Audiometry"){
                        $countAudiometry+=$countAudiometry++;
                        $record[11]['services']=$row['servicesName'];
                        $record[11]['count']=$countAudiometry;
                    }
                    elseif($row['servicesName']=="Gynae Service"){
                        $countGynae+=$countGynae++;
                        $record[12]['services']=$row['servicesName'];
                        $record[12]['count']=$countGynae;
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
}
?>