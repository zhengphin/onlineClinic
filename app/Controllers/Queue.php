<?php

namespace App\Controllers;
use App\Libraries\FirebaseCon;
use App\Libraries\QueueLib;
use App\Libraries\InventoryLib;

class Queue extends BaseController
{
    public function handleAjaxRequestWaiting()
    {
        $data=$this->request->getVar();
        $key=$this->request->getVar('key');
      
           //get connection to firebase
           $database=FirebaseCon::getCon();
           $queueData=[
            'status'=>'waiting',
            ];
           //$postRef_result=$database->getReference("patient/".$key)->update($userData);
           $postRef_result=$database->getReference("queue/".$key)->update($queueData);
       if(!$postRef_result)
       {
           return redirect()->to('staff/queue')->with('fail','Something went wrong');

       }else{

        echo json_encode(array(
            "status"=>1,
            "message"=>"Successful request",
            "data"=>$data
        ));
       }

    }
    public function handleAjaxRequestRemove()
    {
        $data=$this->request->getVar();
        $key=$this->request->getVar('key');
      
           //get connection to firebase
           $database=FirebaseCon::getCon();
           $queueData=[
            'status'=>'remove',
            ];
           //$postRef_result=$database->getReference("patient/".$key)->update($userData);
           $postRef_result=$database->getReference("queue/".$key)->update($queueData);
       if(!$postRef_result)
       {
           return redirect()->to('staff/queue')->with('fail','Something went wrong');

       }else{

        echo json_encode(array(
            "status"=>1,
            "message"=>"Successful request",
            "data"=>$data
        ));
       }

    }
    public function handleAjaxRequest(){
        // $request=\Config\Services::Request();
 
         $data=$this->request->getVar();
         $key=$this->request->getVar('key');
         $queueData=[
            'status'=>'progress',
            ];
            
            //get connection to firebase
            $database=FirebaseCon::getCon();
            
            //$postRef_result=$database->getReference("patient/".$key)->update($userData);
            $postRef_result=$database->getReference("queue/".$key)->update($queueData);
        if(!$postRef_result)
        {
            return redirect()->to('staff/queue')->with('fail','Something went wrong');

        }else{

        
         echo json_encode(array(
             "status"=>1,
             "message"=>"Successful request",
             "data"=>$data
         ));
        }
 
     }
    public function __construct()
    {
        helper(["url", "form"]);
    }
    public function manage()
    {
        $userInfo=session()->get('staffloggedUser');
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $TodayDate = date('Y-m-d');
        //$waitingData=QueueLib::readDataWaiting($TodayDate);
        //$progressData=QueueLib::readDataProgress($TodayDate);
        //$billData=QueueLib::readDataBill($TodayDate);
        //$completeData=QueueLib::readDataCompleted($TodayDate);
        $todayData=QueueLib::readDataToday($TodayDate);
        
        $data=[
            'userInfo'=>$userInfo,
             'todayQueue'=>$todayData,
            'pageTitle'=>'Queue Management'];
       return view('staff/overview',$data);
    }
    public function removePrescription()
    {
        if ($this->request->getMethod() == "post") {
            
            if (isset($_POST['deleteBtn'])) {
                $orderDetailsID=$this->request->getPost('orderDetailsID');
                $queueID=$this->request->getPost('queueID');

                //InventoryLib::readDataByNameGetQuantity()
            
                $orderDetailsForUpdate=QueueLib::readOrderDetailsByKey($orderDetailsID);
                $orderQ=$orderDetailsForUpdate['quantity'];
                $inventoryD=InventoryLib::readDataByNameGetQuantity($orderDetailsForUpdate['itemName']);
                $updateQuantity=$inventoryD[1]['quantity']+$orderQ; 
                $updateInventoryData=[
                    'quantity'=>$updateQuantity,
                    ];
                $database = FirebaseCon::getCon();
                $database
                 ->getReference('inventory/'.$inventoryD[1]['key'])
                 ->update($updateInventoryData);
                $postRef_result = $database
                 ->getReference('orderDetails/'.$orderDetailsID)
                 ->remove();
                 
                 if(!$postRef_result)
                 {
                    $userInfo=session()->get('staffloggedUser');
                    $orderDetails=QueueLib::readOrderDetails($queueID);
                    $sympData=QueueLib::readSym($queueID);

                    $qData=QueueLib::readQueueData($queueID);

                    $pData=QueueLib::readPatientData($qData['patientkey']);
                    $data=[
                        'userInfo'=>$userInfo,
                        'queueID'=>$queueID,
                        'qData'=>$qData,
                        'orderDetails'=>$orderDetails,
                        'sympData'=>$sympData,
                        'patientData'=>$pData,
                        'pageTitle'=>'Prescription and Diagnosis'];
                        session()->setFlashdata('failpre','Failed to delete sales item');  
                        $_POST['addBtn']="";
                        unset($_POST['deleteBtn']);
                        

                   return view('staff/prescription',$data);
                 }
                 else{
                    $userInfo=session()->get('staffloggedUser');
                    $orderDetails=QueueLib::readOrderDetails($queueID);
                    $sympData=QueueLib::readSym($queueID);
                    $qData=QueueLib::readQueueData($queueID);

                    $pData=QueueLib::readPatientData($qData['patientkey']);
                    $data=[
                        'userInfo'=>$userInfo,
                        'queueID'=>$queueID,
                        'orderDetails'=>$orderDetails,
                        'patientData'=>$pData,
                        'qData'=>$qData,
                        'sympData'=>$sympData,
                        'pageTitle'=>'Prescription and Diagnosis'];
                        session()->setFlashdata('successpre','Successfully delete item');  
                        $_POST['addBtn']="";
                        unset($_POST['deleteBtn']);

                   return view('staff/prescription',$data);
                 }
            }
        }
    }
    public function toBill()
    {
        if ($this->request->getMethod() == "post") {
            
            if(isset($_POST['toBill']))
            {
                $queueID=$this->request->getPost('queueID');
                $remark=$this->request->getPost('remarkCon');
                $database = FirebaseCon::getCon();
                
                $updateData=[
                    'status'=>'to bill',
                    'remark'=>$remark
                    ];
                    $postRef_result = $database
                    ->getReference('queue/'.$queueID)
                    ->update($updateData);
                    if(!$postRef_result)
                    {
                       $userInfo=session()->get('staffloggedUser');
                       $orderDetails=QueueLib::readOrderDetails($queueID);
                       $sympData=QueueLib::readSym($queueID);
                       $qData=QueueLib::readQueueData($queueID);

                       $pData=QueueLib::readPatientData($qData['patientkey']);
                       if(isset($qData['remark']))
                       {
                       $remark=$qData['remark'];
                       }else{
                        $remark="";
                    }
                    
                       
                       $data=[
                           'userInfo'=>$userInfo,
                           'queueID'=>$queueID,
                           'orderDetails'=>$orderDetails,
                           'sympData'=>$sympData,     
                            'patientData'=>$pData,
                            'qData'=>$qData,
                           'remark'=>$remark,
                           'pageTitle'=>'Prescription and Diagnosis'];
                           session()->setFlashdata('failpre','Failed to update');  
                    
   
                      return view('staff/prescription',$data);
                    }
                    else{
                        session()->setFlashdata('successtobill','Update succussfully');
                        return redirect()->to('Queue/manage')->withInput();
                    }
            }

            if(isset($_POST['updateSym']))
            {
                
                $symID=$this->request->getPost('edit_id');
                $queueID=$this->request->getPost('queueID');
                $name=$this->request->getPost('nameSym');
                $remark=$this->request->getPost('remarkSym');

                $database = FirebaseCon::getCon();
                $sym=[
                    'name'=>$name,
                    'remark'=>$remark
                    ];
                $postRef_result = $database
                 ->getReference('symptoms/'.$symID)
                 ->update($sym);
                 if(!$postRef_result)
                 {
                    $userInfo=session()->get('staffloggedUser');
                    $orderDetails=QueueLib::readOrderDetails($queueID);
                    $sympData=QueueLib::readSym($queueID);
                    $qData=QueueLib::readQueueData($queueID);
                    $pData=QueueLib::readPatientData($qData['patientkey']);

                    if(isset($qData['remark']))
                    {
                    $remark=$qData['remark'];
                    }else{
                     $remark="";
                 }
                    $data=[
                        'userInfo'=>$userInfo,
                        'queueID'=>$queueID,
                        'orderDetails'=>$orderDetails,
                        'remark'=>$remark,
                        'sympData'=>$sympData,
                        'patientData'=>$pData,
                        'qData'=>$qData,
                        'pageTitle'=>'Prescription and Diagnosis'];
                        session()->setFlashdata('failpre','Failed to update');  
                        $_POST['updateSym']="";
                        unset($_POST['updateSym']);

                   return view('staff/prescription',$data);
                 }
                 else{
                    $userInfo=session()->get('staffloggedUser');
                    $orderDetails=QueueLib::readOrderDetails($queueID);
                    $sympData=QueueLib::readSym($queueID);
                    $qData=QueueLib::readQueueData($queueID);

                    $pData=QueueLib::readPatientData($qData['patientkey']);
                    if(isset($qData['remark']))
                    {
                    $remark=$qData['remark'];
                    }else{
                     $remark="";
                 }
                    $data=[
                        'userInfo'=>$userInfo,
                        'queueID'=>$queueID,
                        'remark'=>$remark,
                        'orderDetails'=>$orderDetails,
                        'sympData'=>$sympData,
                        'patientData'=>$pData,
                        'qData'=>$qData,
                        'pageTitle'=>'Prescription and Diagnosis'];
                        session()->setFlashdata('successpre','Successfully update');  
                        $_POST['updateSym']="";
                        unset($_POST['updateSym']);

                   return view('staff/prescription',$data);
                 }
            }
            if(isset($_POST['deleteSym']))
            {
                $symID=$this->request->getPost('delete_id');
                $queueID=$this->request->getPost('queueID');
                //get item quantity
                //reverse back quantity
                $database = FirebaseCon::getCon();
                $postRef_result = $database
                 ->getReference('symptoms/'.$symID)
                 ->remove();
                 if(!$postRef_result)
                 {
                    $userInfo=session()->get('staffloggedUser');
                    $orderDetails=QueueLib::readOrderDetails($queueID);
                    $sympData=QueueLib::readSym($queueID);
                    $qData=QueueLib::readQueueData($queueID);
                    $pData=QueueLib::readPatientData($qData['patientkey']);
                       if(isset($qData['remark']))
                       {
                       $remark=$qData['remark'];
                       }else{
                        $remark="";
                    }
                    $data=[
                        'userInfo'=>$userInfo,
                        'queueID'=>$queueID,
                        'remark'=>$remark,
                        'orderDetails'=>$orderDetails,
                        'sympData'=>$sympData,
                        'patientData'=>$pData,
                        'qData'=>$qData,
                        'pageTitle'=>'Prescription and Diagnosis'];
                        session()->setFlashdata('failpre','Failed to delete');  
                        $_POST['updateSym']="";
                        unset($_POST['updateSym']);

                   return view('staff/prescription',$data);
                 }
                 else{
                    $userInfo=session()->get('staffloggedUser');
                    $orderDetails=QueueLib::readOrderDetails($queueID);
                    $sympData=QueueLib::readSym($queueID);
                    $qData=QueueLib::readQueueData($queueID);
                    $pData=QueueLib::readPatientData($qData['patientkey']);
                       if(isset($qData['remark']))
                       {
                       $remark=$qData['remark'];
                       }else{
                        $remark="";
                    }
                    $data=[
                        'userInfo'=>$userInfo,
                        'queueID'=>$queueID,
                        'remark'=>$remark,
                        'orderDetails'=>$orderDetails,
                        'sympData'=>$sympData,
                        'patientData'=>$pData,
                        'qData'=>$qData,

                        'pageTitle'=>'Prescription and Diagnosis'];
                        session()->setFlashdata('successpre','Successfully delete');  
                        $_POST['deleteSym']="";
                        unset($_POST['deleteSym']);

                   return view('staff/prescription',$data);
                 }
            }

            if(isset($_POST['addSym'])&&!empty($_POST['addSym']))
            {
                $queueID=$this->request->getPost('queueID');
                $remark=$this->request->getPost('remarkSym');
                $nameSym=$this->request->getPost('nameSym');
                date_default_timezone_set('Asia/Kuala_Lumpur');
                $TodayDate = date('Y-m-d');
                $symData=[
                    'queueID'=>$queueID,
                    'name'=>$nameSym,
                    'remark'=>$remark,
                    'date'=>$TodayDate
                    ];
                    
                    //get connection to firebase
                    $database=FirebaseCon::getCon();
                    $postRef_result=$database->getReference("symptoms")->push($symData);
                    if(!$postRef_result)
                    {
                        $userInfo=session()->get('staffloggedUser');
                        $orderDetails=QueueLib::readOrderDetails($queueID);
                        $sympData=QueueLib::readSym($queueID);
                        $qData=QueueLib::readQueueData($queueID);
                        $pData=QueueLib::readPatientData($qData['patientkey']);
                        if(isset($qData['remark']))
                        {
                        $remark=$qData['remark'];
                        }else{
                         $remark="";
                     }
                        $data=[
                            'userInfo'=>$userInfo,
                            'queueID'=>$queueID,
                            'remark'=>$remark,
                            'orderDetails'=>$orderDetails,      
                            'patientData'=>$pData,
                            'qData'=>$qData,

                            'sympData'=>$sympData,
                            'pageTitle'=>'Prescription and Diagnosis'];
                            session()->setFlashdata('failpre','Failed to add symptom');  
                            $_POST['addSym']="";

                       return view('staff/prescription',$data);
                    }else{
                        $userInfo=session()->get('staffloggedUser');
                        $orderDetails=QueueLib::readOrderDetails($queueID);
                        $sympData=QueueLib::readSym($queueID);
                        $qData=QueueLib::readQueueData($queueID);
                        $pData=QueueLib::readPatientData($qData['patientkey']);
                        if(isset($qData['remark']))
                        {
                        $remark=$qData['remark'];
                        }else{
                         $remark="";
                     }
                        $data=[
                            'userInfo'=>$userInfo,
                            'queueID'=>$queueID,
                            'remark'=>$remark,
                            'orderDetails'=>$orderDetails,
                            'patientData'=>$pData,
                            'qData'=>$qData,

                            'sympData'=>$sympData,
                            'pageTitle'=>'Prescription and Diagnosis'];
                            session()->setFlashdata('successpre','Successfully added symptom');
                            $_POST['addSym']="";
                          

                       return view('staff/prescription',$data);
                    }

            }
            if (isset($_POST['addBtn'])&&!empty($_POST['addBtn'])) {
                $queueID=$this->request->getPost('queueID');
                $inventoryData=$this->request->getPost('item');
                $quantity=$this->request->getPost('quantity');
                $remark=$this->request->getPost('remark');
                $arr=explode("|",$inventoryData);
                // arr[0] is the id inventory 1 is quantity 2 is price 3 is name
                //echo $arr[0];
                //orderDetails
                $subtotal=$quantity*$arr[2];
                $orderDetailsData=[
                    'queueID'=>$queueID,
                    'itemName'=>$arr[3],
                    'quantity'=>$quantity,
                    'price'=>$arr[2],
                    'subTotal'=>$subtotal,
                    'remark'=>$remark
                    ];
                    
                    //get connection to firebase
                    $database=FirebaseCon::getCon();
                    $postRef_result=$database->getReference("orderDetails")->push($orderDetailsData);
                    if(!$postRef_result)
                    {
                        $userInfo=session()->get('staffloggedUser');
                        $orderDetails=QueueLib::readOrderDetails($queueID);
                        $sympData=QueueLib::readSym($queueID);
                        $qData=QueueLib::readQueueData($queueID);
                        $pData=QueueLib::readPatientData($qData['patientkey']);

                        if(isset($qData['remark']))
                        {
                        $remark=$qData['remark'];
                        }else{
                         $remark="";
                     }
                        $data=[
                            'userInfo'=>$userInfo,
                            'queueID'=>$queueID,
                            'remark'=>$remark,
                            'orderDetails'=>$orderDetails,
                            'sympData'=>$sympData,
                            'patientData'=>$pData,
                            'qData'=>$qData,

                            'pageTitle'=>'Prescription and Diagnosis'];
                            session()->setFlashdata('failpre','Failed to add sales item');  
                            $_POST['addBtn']="";

                       return view('staff/prescription',$data);
                    }else{
                        $userInfo=session()->get('staffloggedUser');
                        $orderDetails=QueueLib::readOrderDetails($queueID);
                        $sympData=QueueLib::readSym($queueID);
                        $qData=QueueLib::readQueueData($queueID);
                        $pData=QueueLib::readPatientData($qData['patientkey']);
                        if(isset($qData['remark']))
                        {
                        $remark=$qData['remark'];
                        }else{
                         $remark="";
                     }
                        ///////////////////////////
                        $inventoryD=InventoryLib::readDataByKey($arr[0]);
                        $updateQuantity=$inventoryD[1]['quantity']-$quantity; 
                        $updateInventoryData=[
                            'quantity'=>$updateQuantity,
                            ];
                        $database = FirebaseCon::getCon();
                        $database
                         ->getReference('inventory/'.$arr[0])
                         ->update($updateInventoryData);
                         /////////////////////////
                        $data=[
                            'userInfo'=>$userInfo,
                            'queueID'=>$queueID,
                            'remark'=>$remark,
                            'orderDetails'=>$orderDetails,
                            'sympData'=>$sympData,
                            'patientData'=>$pData,
                            'qData'=>$qData,

                            'pageTitle'=>'Prescription and Diagnosis'];
                            session()->setFlashdata('successpre','Successfully added sales item');
                            $_POST['addBtn']="";
                          

                       return view('staff/prescription',$data);
                    }

        }else{
        $userInfo=session()->get('staffloggedUser');
        $queueID=$this->request->getPost('queueID');
        $orderDetails=QueueLib::readOrderDetails($queueID);
        $sympData=QueueLib::readSym($queueID);
        $qData=QueueLib::readQueueData($queueID);
        $pData=QueueLib::readPatientData($qData['patientkey']);

                       if(isset($qData['remark']))
                       {
                       $remark=$qData['remark'];
                       }else{
                        $remark="";
                    }
        $data=[
            'userInfo'=>$userInfo,
            'queueID'=>$queueID,
            'remark'=>$remark,
            'orderDetails'=>$orderDetails,
            'sympData'=>$sympData,
            'patientData'=>$pData,
            'qData'=>$qData,

            'pageTitle'=>'Prescription and Diagnosis'];
       return view('staff/prescription',$data);
        }
    }
    }
 
    public function moveQueue()
    {
        if ($this->request->getMethod() == "post") {
           $key=$this->request->getPost('patientKey');
           $services=$this->request->getPost('services');
           date_default_timezone_set('Asia/Kuala_Lumpur');
            $CreateDate = date('Y-m-d');
            $currentTime = date("H:i");
           $isWaiting=QueueLib::checkQueue($key,$CreateDate);
        if($isWaiting!=false)
        {
           $queueData=[
            'patientkey'=>$key,
            'services'=>$services,
            'status'=>'waiting',
            'date'=>$CreateDate,
            'Arrivaltime'=>$currentTime
            ];
            
            //get connection to firebase
            $database=FirebaseCon::getCon();
            
            //$postRef_result=$database->getReference("patient/".$key)->update($userData);
            $postRef_result=$database->getReference("queue")->push($queueData);
            if(!$postRef_result){
                return redirect()->to('staff/view')->with('fail','Something went wrong');

            }else{
                return redirect()->to('staff/view')->with('success','Updated Successfully');
            } 
        }else{
            return redirect()->to('staff/view')->with('fail','already added to waiting.');

        }
    }   
    }
  
}
