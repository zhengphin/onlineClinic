<?php

namespace App\Controllers;
use App\Libraries\FirebaseCon;
use App\Libraries\EventLib;
use App\Libraries\QueueLib;

class Checkout extends BaseController
{   
     public function __construct()
    {
        helper(["url", "form"]);
    }
    public function receipt()
    {   
       if ($this->request->getMethod() == "post") {

        $queueID=$this->request->getPost('queueID');
        //$queueID="-NI_JJS3EjIo8L8-3UCW";
        $qData=QueueLib::readQueueData($queueID);
        $orderDetails=QueueLib::readOrderDetails($queueID);
        $servicesOrderData=QueueLib::readServicesByQueueID($queueID);
        $pData=QueueLib::readPatientData($qData['patientkey']);

        $data=[
            'orderDetails'=>$orderDetails,
            'qData'=>$qData,
            'servicesOrderData'=>$servicesOrderData,
            'pData'=>$pData
         ];
         $dompdf=new \Dompdf\Dompdf();
         $dompdf->set_option('isRemoteEnabled',TRUE);
         $dompdf->loadHtml(view('staff/receipt',$data));
         $dompdf->setPaper('A4','portrait');
        $dompdf->render();
        $dompdf->stream("Receipt");
        
        }
    }
    public function pay()
    {
        if ($this->request->getMethod() == "post") {

                $queueID=$this->request->getPost('queueID');
                $received=$this->request->getPost('value1');
                $change=$this->request->getPost('sum');
                $grant=$this->request->getPost('grant');

                $database = FirebaseCon::getCon();
                $updateQueueData=[
                   'received'=>$received,
                   'grant'=>$grant,
                   'change'=>$change,
                   'status'=>'completed'
                ];
                $postRef_result = $database
                 ->getReference('queue/'.$queueID)
                 ->update($updateQueueData);
                 if(!$postRef_result)
                 {
                    $userInfo=session()->get('staffloggedUser');

                    $queueID=$this->request->getPost('queueID');
                    $orderDetails=QueueLib::readOrderDetails($queueID);
                    $sympData=QueueLib::readSym($queueID);
                    $qData=QueueLib::readQueueData($queueID);
                    $servicesOrderData=QueueLib::readServicesByQueueID($queueID);
        
                                   if(isset($qData['remark']))
                                   {
                                   $remark=$qData['remark'];
                                   }else{
                                    $remark="";
                                }
                    $pData=QueueLib::readPatientData($qData['patientkey']);
                    session()->setFlashdata('failtocheckout','Failed to make payment');  
        
                    $data=[
                        'userInfo'=>$userInfo,
                        'queueID'=>$queueID,
                        'remark'=>$remark,
                        'qData'=>$qData,
                        'servicesOrderData'=>$servicesOrderData,
                        'service'=>$qData['services'],
                        'patientData'=>$pData,
                        'orderDetails'=>$orderDetails,
                        'sympData'=>$sympData,
                        'pageTitle'=>'Checkout'];
                   return view('staff/toPayment',$data);
                 }
                 else{
                    $data=[
                        'queueID'=>$queueID,
                        'grant'=>$grant,
                        'change'=>$change,
                        'received'=>$received,
                    ];
                    return view('staff/paymentSuccess',$data);
                }

            

        }
    }
    public function toPayment()
    {
        if ($this->request->getMethod() == "post") {
            
            if (isset($_POST['updateServices'])&&!empty($_POST['updateServices'])) {
                $servicesOrderID=$this->request->getPost('edit_id');
                $queueID=$this->request->getPost('queueID');
                $services=$this->request->getPost('services');
                $servicesQuantity=$this->request->getPost('editservicesQuantity');
                $servicesPrice=$this->request->getPost('editservicesPrice');
                $subtotal=$servicesPrice*$servicesQuantity;

                $database = FirebaseCon::getCon();
                $servicesData=[
                    'queueID'=>$queueID,
                    'servicesName'=>$services,
                    'quantity'=>$servicesQuantity,
                    'price'=>$servicesPrice,
                    'subtotal'=>$subtotal
                    ];
                $postRef_result = $database
                 ->getReference('serviceDetails/'.$servicesOrderID)
                 ->update($servicesData);
                 if(!$postRef_result)
                 {
                    $userInfo=session()->get('staffloggedUser');

                    $queueID=$this->request->getPost('queueID');
                    $orderDetails=QueueLib::readOrderDetails($queueID);
                    $sympData=QueueLib::readSym($queueID);
                    $qData=QueueLib::readQueueData($queueID);
                    $servicesOrderData=QueueLib::readServicesByQueueID($queueID);
        
                                   if(isset($qData['remark']))
                                   {
                                   $remark=$qData['remark'];
                                   }else{
                                    $remark="";
                                }
                    $pData=QueueLib::readPatientData($qData['patientkey']);
                    session()->setFlashdata('failtocheckout','Failed Update services');  
        
                    $data=[
                        'userInfo'=>$userInfo,
                        'queueID'=>$queueID,
                        'remark'=>$remark,
                        'qData'=>$qData,
                        'servicesOrderData'=>$servicesOrderData,
                        'service'=>$qData['services'],
                        'patientData'=>$pData,
                        'orderDetails'=>$orderDetails,
                        'sympData'=>$sympData,
                        'pageTitle'=>'Checkout'];
                   return view('staff/toPayment',$data);
                 }
                 else{
                    $userInfo=session()->get('staffloggedUser');

                    $queueID=$this->request->getPost('queueID');
                    $orderDetails=QueueLib::readOrderDetails($queueID);
                    $sympData=QueueLib::readSym($queueID);
                    $qData=QueueLib::readQueueData($queueID);
                    $servicesOrderData=QueueLib::readServicesByQueueID($queueID);
        
                                   if(isset($qData['remark']))
                                   {
                                   $remark=$qData['remark'];
                                   }else{
                                    $remark="";
                                }
                    $pData=QueueLib::readPatientData($qData['patientkey']);
                    session()->setFlashdata('successtocheckout','Successfully Update services');  
        
                    $data=[
                        'userInfo'=>$userInfo,
                        'queueID'=>$queueID,
                        'remark'=>$remark,
                        'qData'=>$qData,
                        'servicesOrderData'=>$servicesOrderData,
                        'service'=>$qData['services'],
                        'patientData'=>$pData,
                        'orderDetails'=>$orderDetails,
                        'sympData'=>$sympData,
                        'pageTitle'=>'Checkout'];
                   return view('staff/toPayment',$data);
                 }
            }
            if (isset($_POST['deleteServices'])&&!empty($_POST['deleteServices'])) {
                $servicesOrderID=$this->request->getPost('delete_id');
                $queueID=$this->request->getPost('queueID');
           
                $database = FirebaseCon::getCon();
                $postRef_result = $database
                 ->getReference('serviceDetails/'.$servicesOrderID)
                 ->remove();
                 if(!$postRef_result)
                 {
                    $userInfo=session()->get('staffloggedUser');

                    $queueID=$this->request->getPost('queueID');
                    $orderDetails=QueueLib::readOrderDetails($queueID);
                    $sympData=QueueLib::readSym($queueID);
                    $qData=QueueLib::readQueueData($queueID);
                    $servicesOrderData=QueueLib::readServicesByQueueID($queueID);
        
                                   if(isset($qData['remark']))
                                   {
                                   $remark=$qData['remark'];
                                   }else{
                                    $remark="";
                                }
                    $pData=QueueLib::readPatientData($qData['patientkey']);
                    session()->setFlashdata('failtocheckout','Failed Delete services');  
        
                    $data=[
                        'userInfo'=>$userInfo,
                        'queueID'=>$queueID,
                        'remark'=>$remark,
                        'qData'=>$qData,
                        'servicesOrderData'=>$servicesOrderData,
                        'service'=>$qData['services'],
                        'patientData'=>$pData,
                        'orderDetails'=>$orderDetails,
                        'sympData'=>$sympData,
                        'pageTitle'=>'Checkout'];
                   return view('staff/toPayment',$data);
                 }
                 else{
                    $userInfo=session()->get('staffloggedUser');

                    $queueID=$this->request->getPost('queueID');
                    $orderDetails=QueueLib::readOrderDetails($queueID);
                    $sympData=QueueLib::readSym($queueID);
                    $qData=QueueLib::readQueueData($queueID);
                    $servicesOrderData=QueueLib::readServicesByQueueID($queueID);
        
                                   if(isset($qData['remark']))
                                   {
                                   $remark=$qData['remark'];
                                   }else{
                                    $remark="";
                                }
                    $pData=QueueLib::readPatientData($qData['patientkey']);
                    session()->setFlashdata('successtocheckout','Suceesfully Delete services');  
        
                    $data=[
                        'userInfo'=>$userInfo,
                        'queueID'=>$queueID,
                        'remark'=>$remark,
                        'qData'=>$qData,
                        'servicesOrderData'=>$servicesOrderData,
                        'service'=>$qData['services'],
                        'patientData'=>$pData,
                        'orderDetails'=>$orderDetails,
                        'sympData'=>$sympData,
                        'pageTitle'=>'Checkout'];
                   return view('staff/toPayment',$data);
                 }
            }
            if (isset($_POST['addServices'])&&!empty($_POST['addServices'])) {
                $queueID=$this->request->getPost('queueID');
                $services=$this->request->getPost('services');
                $servicesQuantity=$this->request->getPost('servicesQuantity');
                $servicesPrice=$this->request->getPost('servicesPrice');
                $subtotal=$servicesPrice*$servicesQuantity;
                
                $servicesData=[
                    'queueID'=>$queueID,
                    'servicesName'=>$services,
                    'quantity'=>$servicesQuantity,
                    'price'=>$servicesPrice,
                    'subtotal'=>$subtotal
                    ];
                    
                    //get connection to firebase
                    $database=FirebaseCon::getCon();
                    $postRef_result=$database->getReference("serviceDetails")->push($servicesData);
                    if(!$postRef_result)
                    {
                        $userInfo=session()->get('staffloggedUser');

            $queueID=$this->request->getPost('queueID');
            $orderDetails=QueueLib::readOrderDetails($queueID);
            $sympData=QueueLib::readSym($queueID);
            $qData=QueueLib::readQueueData($queueID);
            $servicesOrderData=QueueLib::readServicesByQueueID($queueID);

                           if(isset($qData['remark']))
                           {
                           $remark=$qData['remark'];
                           }else{
                            $remark="";
                        }
            $pData=QueueLib::readPatientData($qData['patientkey']);
            session()->setFlashdata('failtocheckout','Failed to add services');  

            $data=[
                'userInfo'=>$userInfo,
                'queueID'=>$queueID,
                'remark'=>$remark,
                'qData'=>$qData,
                'servicesOrderData'=>$servicesOrderData,
                'service'=>$qData['services'],
                'patientData'=>$pData,
                'orderDetails'=>$orderDetails,
                'sympData'=>$sympData,
                'pageTitle'=>'Checkout'];
           return view('staff/toPayment',$data);
                        }else{

                            $userInfo=session()->get('staffloggedUser');

                            $queueID=$this->request->getPost('queueID');
                            $orderDetails=QueueLib::readOrderDetails($queueID);
                            $sympData=QueueLib::readSym($queueID);
                            $qData=QueueLib::readQueueData($queueID);
                            $servicesOrderData=QueueLib::readServicesByQueueID($queueID);

                    
                                           if(isset($qData['remark']))
                                           {
                                           $remark=$qData['remark'];
                                           }else{
                                            $remark="";
                                        }
                            $pData=QueueLib::readPatientData($qData['patientkey']);
                            session()->setFlashdata('successtocheckout','Services added successfully.');  
                
                            $data=[
                                'userInfo'=>$userInfo,
                                'queueID'=>$queueID,
                                'remark'=>$remark,
                                'qData'=>$qData,
                                'servicesOrderData'=>$servicesOrderData,
                                'service'=>$qData['services'],
                                'patientData'=>$pData,
                                'orderDetails'=>$orderDetails,
                                'sympData'=>$sympData,
                                'pageTitle'=>'Checkout'];
                           return view('staff/toPayment',$data);
                        }


            }else{
            
            $userInfo=session()->get('staffloggedUser');

            $queueID=$this->request->getPost('queueID');
            $orderDetails=QueueLib::readOrderDetails($queueID);
            $sympData=QueueLib::readSym($queueID);
            $qData=QueueLib::readQueueData($queueID);
    
                           if(isset($qData['remark']))
                           {
                           $remark=$qData['remark'];
                           }else{
                            $remark="";
                        }
            $pData=QueueLib::readPatientData($qData['patientkey']);
            $servicesOrderData=QueueLib::readServicesByQueueID($queueID);

            $data=[
                'userInfo'=>$userInfo,
                'queueID'=>$queueID,
                'remark'=>$remark,
                'qData'=>$qData,
                'servicesOrderData'=>$servicesOrderData,
                'service'=>$qData['services'],
                'patientData'=>$pData,
                'orderDetails'=>$orderDetails,
                'sympData'=>$sympData,
                'pageTitle'=>'Checkout'];
           return view('staff/toPayment',$data);
        }
    }
    }
    public function toCheckout()
    {
        if ($this->request->getMethod() == "post") {
            $userInfo=session()->get('staffloggedUser');

            $queueID=$this->request->getPost('queueID');
            $orderDetails=QueueLib::readOrderDetails($queueID);
            $sympData=QueueLib::readSym($queueID);
            $qData=QueueLib::readQueueData($queueID);
    
                           if(isset($qData['remark']))
                           {
                           $remark=$qData['remark'];
                           }else{
                            $remark="";
                        }

            $pData=QueueLib::readPatientData($qData['patientkey']);
        
            $data=[
                'userInfo'=>$userInfo,
                'queueID'=>$queueID,
                'remark'=>$remark,
                'service'=>$qData['services'],
                'patientData'=>$pData,
                'orderDetails'=>$orderDetails,
                'sympData'=>$sympData,
                'pageTitle'=>'Medicine Collection'];
           return view('staff/prescriptionCollection',$data);

        }
    }
    public function index()
    {
        $userInfo=session()->get('staffloggedUser');
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $TodayDate = date('Y-m-d');
      
        $billData=QueueLib::readDataBill($TodayDate);
        $completeData=QueueLib::readDataCompleted($TodayDate);

        $data=[
            'userInfo'=>$userInfo,
            'billData'=>$billData,
            'completeData'=>$completeData,
            'pageTitle'=>'Medicine Collection'];
       return view('staff/checkout',$data);
    }

}
