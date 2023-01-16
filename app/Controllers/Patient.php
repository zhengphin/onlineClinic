<?php

namespace App\Controllers;
use App\Libraries\myic;
use App\Libraries\Hash;
use App\Libraries\FirebaseCon;
use App\Libraries\User;
use App\Libraries\PatientLib;
use App\Libraries\QueueLib;
use App\Libraries\LabLib;
use App\Libraries\AdminLib;

class Patient extends BaseController
{

    public function update2()
    {
        $userData=[
            'Allergies'=>"Yes",
        ];

        //get connection to firebase
        $database=FirebaseCon::getCon();
        
        //$postRef_result=$database->getReference("patient/".$key)->update($userData);
        $postRef_result=$database->getReference("patient/-NH-j-ADiX568ugoY294")->update($userData);
    }
    public function update()
{   
    $key=$this->request->getPost('key');

        //validation
         //validation for register form
         $validation=$this->validate([
            'name'=>[
                'rules'=>'required|max_length[50]|min_length[8]|alpha_space',
                'errors'=>[
                    'required'=>'Please enter your full name',
                    'max_length'=>'Maximum 50 characters only',
                    'min_length'=>'Minimum 8 characters at least'
                ]
                ],
                'contact'=>[
                    'rules'=>'required|checkExistProfile[phone,patient,'.$key.']|max_length[11]|checkContact',
                    'errors'=>[
                        'required'=>'Contact number is required',
                        'checkExistProfile'=>'Contact number already taken',
                        'max_length'=>'Invalid contact number',
                        'checkContact'=>'Invalid contact number'
                    ]
                    ],
                    'email'=>[
                        'rules'=>'valid_email2|checkExistProfile[email,patient,'.$key.']',
                        'errors'=>[
                            'valid_email2'=>'Please enter a valid email',
                            'checkExistProfile'=>'Email already taken'

                        ]
                        ],
            'postcode'=>[
                    'rules'=>'required|max_length[5]|min_length[5]|checkPostcode[postcode]',
                    'errors'=>[
                        'required'=>'Postcode  is required',  
                        'matches'=>'Passwords do not match',
                        'max_length'=>'Invalid postcode',
                        'min_length'=>'Invalid postcode',
                        'checkPostcode'=>'Invalid postcode'
                        ]
                        ],
             'address'=>[
                    'rules'=>'required|max_length[100]|min_length[10]|checkHomeAddress[address]',
                    'errors'=>[
                        'required'=>'Address  is required',  
                        'max_length'=>'Maximum 100 characters only',
                        'min_length'=>'Provide more details about address',
                        'checkHomeAddress'=>'Invalid address can only contain comman, whitespace, number, letter only'
                        ]
                        ],
                        'Ethnicity'=>[
                            'rules'=>'required',
                            'errors'=>[
                                'required'=>'Ethnicity  is required'
                                ]
                                ],
            'identityNum'=>[
                    'rules'=>'checkIC[identityNum]|max_length[12]|min_length[12]|required|checkExistProfile[ic,patient,'.$key.']',
                    'errors'=>[
                        'required'=>'Identity Number is required',
                        'checkIC'=>'Invalid IC Number',
                        'max_length'=>'Invalid IC Number',
                        'min_length'=>'Invalid IC Number',
                        'checkExistProfile'=>'IC already used'
                        ]
                        ]
                    ]);
         //if validation got error go to register view and pass the parameter value
         if(!$validation)
         {
             //return view('patientDashboard/profile',['validation'=>$this->validator]);
             session()->setFlashdata('nameError',display_error($this->validator,'name'));
             session()->setFlashdata('contactError',display_error($this->validator,'contact'));
             session()->setFlashdata('icError',display_error($this->validator,'identityNum'));
             session()->setFlashdata('addressError',display_error($this->validator,'address'));
             session()->setFlashdata('postcodeError',display_error($this->validator,'postcode'));
             session()->setFlashdata('emailError',display_error($this->validator,'email'));
             session()->setFlashdata('error','error');

             return redirect()->to('staff/panel?patient='.$key.'')->withInput();

             //return redirect()->back()->withInput();
             //return view('patientDashboard/profile',$data);
         }
         else{
            $name=$this->request->getPost('name');
            $identityNum=$this->request->getPost('identityNum');
            $address=$this->request->getPost('address');
            $contact=$this->request->getPost('contact');
            $postcode=$this->request->getPost('postcode');
            $Ethnicity=$this->request->getPost('Ethnicity');
            $email=$this->request->getPost('email');
            $Allergies=$this->request->getPost('Allergies');
            $key=$this->request->getPost('key');            
          
             // Load the custom library
            // Create object
            $myic = new \App\Libraries\myic();
            // Use the function of custom library
            $detail=$myic->get("$identityNum");
           
           //get DOB date format
           $dob=$detail['dob'];
           $date=date_create($dob);
           $dob=date_format($date,"Y-m-d");

    

            $userData=[
                'Allergies'=>$Allergies,
                'Ethnicity'=>$Ethnicity,
                'address'=>strtoupper($address),
                'dob'=>$dob,
                'email'=>$email,
                'gender'=>$detail['gender']
            ];
           
            $userData2=[
            'ic'=>$identityNum,
            'name'=>strtoupper($name),
            'phone'=>$contact,
            'postCode'=>$postcode,
            'state'=>$detail['state']
            ];
            //get connection to firebase
            $database=FirebaseCon::getCon();
            
            //$postRef_result=$database->getReference("patient/".$key)->update($userData);
            $postRef_result=$database->getReference("patient/".$key)->update($userData);
            $postRef_result2=$database->getReference("patient/".$key)->update($userData2);
            if(!$postRef_result||!$postRef_result2){
                return redirect()->to('staff/panel?patient='.$key.'')->with('fail','Something went wrong');

            }else{
                $oldIc=$this->request->getPost('oldic');
                User::updateAllAppointmentIC($oldIc,$identityNum);
                User::updateAllOnlinePatientIC($oldIc,$identityNum);
                
                return redirect()->to('staff/panel?patient='.$key.'')->with('success','Patient profile updated');
            } 
           
        }
}
    public function addQueue()
    {
        if ($this->request->getMethod() == "post") {
            $appointmentkey=$this->request->getPost('id');
            $appData=PatientLib::readAppDataByKey($appointmentkey);
            $patientKey=PatientLib::readPatientKeyByIC($appData['ic']);
           // print_r($patientKey); appData['service']
           date_default_timezone_set('Asia/Kuala_Lumpur');
           $CreateDate = date('Y-m-d');
           $currentTime = date("H:i");
           $isWaiting=QueueLib::checkQueue($patientKey,$CreateDate);
           if($isWaiting!=false)
           {
              $queueData=[
               'patientkey'=>$patientKey,
               'services'=>$appData['service'],
               'status'=>'waiting',
               'date'=>$CreateDate,
               'Arrivaltime'=>$currentTime,
               'appointmentKey'=>$appointmentkey
               ];
               
               //get connection to firebase
               $database=FirebaseCon::getCon();
               
               //$postRef_result=$database->getReference("patient/".$key)->update($userData);
               $postRef_result=$database->getReference("queue")->push($queueData);
               if(!$postRef_result){
                   return redirect()->to('staff/approvedAppointment')->with('fail','Something went wrong');
   
               }else{
                   return redirect()->to('staff/view')->with('success','Updated Successfully');
               } 
           }else{
               return redirect()->to('staff/view')->with('fail','already added to waiting.');
   
           }
        }
    }
    public function viewReceipt()
    {
        $queueID=$this->request->getPost('queueID');
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
         return view('staff/receipt',$data);

      
    }
    public function visitDetails()
    {
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
        $sympData=QueueLib::readSym($queueID);
        $data=[
            'userInfo'=>$userInfo,
            'queueID'=>$queueID,
            'remark'=>$remark,
            'symData'=>$sympData,
            'qData'=>$qData,
            'servicesOrderData'=>$servicesOrderData,
            'service'=>$qData['services'],
            'patientData'=>$pData,
            'orderDetails'=>$orderDetails,
            'sympData'=>$sympData,
            'pageTitle'=>'Visit Details'];
       return view('staff/visitDetails',$data);
    }
    public function panel(){
        if ($this->request->getMethod() == "post") {

        $key=$this->request->getPost('id');
        $userInfo=session()->get('staffloggedUser');
        $patientData=PatientLib::readDataByKey($key);
        $labData=LabLib::readDataByKey($key);
        //$sympData=QueueLib::readSym($queueID);
      
        ////////////////////////////////////////////////////////////
         // Dynamic limit
         $limit = 10;
         // Get total records
         $allRecords = AdminLib::countRecordsByPatient('queue',$key);
         // Calculate total pages
         $totoalPages = ceil($allRecords / $limit);
 
         // Current pagination page number
         $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
 
         // Offset
         $paginationStart = ($page - 1) * $limit;
 
         if ($paginationStart == 0) {
             $paginationStart = 1;
             $end = $limit;
         } else {
             $paginationStart += 1;
             $end = $paginationStart + 1;
         }
 
         $prev = $page - 1;
         $next = $page + 1;
         /////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////
         // Dynamic limit
         $limit2 = 10;
         // Get total records
         $allRecords2 = AdminLib::countRecordsByPatientBySymData('queue',$key);
         // Calculate total pages
         $totoalPages2 = ceil($allRecords2 / $limit2);
 
         // Current pagination page number
         $page2 = (isset($_GET['page2']) && is_numeric($_GET['page2']) ) ? $_GET['page2'] : 1;
 
         // Offset
         $paginationStart2 = ($page2 - 1) * $limit2;
 
         if ($paginationStart2 == 0) {
             $paginationStart2 = 1;
             $end2 = $limit2;
         } else {
             $paginationStart2 += 1;
             $end2 = $paginationStart2 + 1;
         }
 
         $prev2 = $page2 - 1;
         $next2 = $page2 + 1;
         /////////////////////////////////////////////////////
         $searchName=$this->request->getPost("searchName");
         if(!empty($searchName)){
            $limit2 = 10;
            // Get total records
            $allRecords2 = AdminLib::countRecordsByPatientBySymDataByName('queue',$key,$searchName);
            // Calculate total pages
            $totoalPages2 = ceil($allRecords2 / $limit2);
    
            // Current pagination page number
            $page2 = (isset($_GET['page2']) && is_numeric($_GET['page2']) ) ? $_GET['page2'] : 1;
    
            // Offset
            $paginationStart2 = ($page2 - 1) * $limit2;
    
            if ($paginationStart2 == 0) {
                $paginationStart2 = 1;
                $end2 = $limit2;
            } else {
                $paginationStart2 += 1;
                $end2 = $paginationStart2 + 1;
            }
    
            $prev2 = $page2 - 1;
            $next2 = $page2 + 1;
             $symData=QueueLib::readQueueDataByPatientKeyBySympAndName('queue', $paginationStart, $end,$key,$searchName);

         }else{
            $symData=QueueLib::readQueueDataByPatientKeyBySymp('queue', $paginationStart, $end,$key);

         }
         
         $visitedRecord=QueueLib::readQueueDataByPatientKey('queue', $paginationStart, $end,$key);
        if($patientData!=false)
        {
        $data=[
            'userInfo'=>$userInfo,
            'patientData'=>$patientData[1],
            'labData'=>$labData,
            'visitedRecord'=>$visitedRecord,
            'symData'=>$symData,
            'limit' => $limit,
            'allRecords' => $allRecords,
            'totoalPages' => $totoalPages,
            'page' => $page,
            'paginationStart' => $paginationStart,
            'prev' => $prev,
            'next' => $next,
            'limit2' => $limit2,
            'allRecords2' => $allRecords2,
            'totoalPages2' => $totoalPages2,
            'page2' => $page2,
            'paginationStart2' => $paginationStart2,
            'prev2' => $prev2,
            'next2' => $next2,
            'pageTitle'=>'Patient Profile'];
        
        return view('staff/panel',$data);
        }
    }
    if(isset($_GET['patient']))
    {
        $key=$_GET['patient'];
        $userInfo=session()->get('staffloggedUser');
        $patientData=PatientLib::readDataByKey($key);
        $labData=LabLib::readDataByKey($key);
        //$sympData=QueueLib::readSym($queueID);
      
        ////////////////////////////////////////////////////////////
         // Dynamic limit
         $limit = 10;
         // Get total records
         $allRecords = AdminLib::countRecordsByPatient('queue',$key);
         // Calculate total pages
         $totoalPages = ceil($allRecords / $limit);
 
         // Current pagination page number
         $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
 
         // Offset
         $paginationStart = ($page - 1) * $limit;
 
         if ($paginationStart == 0) {
             $paginationStart = 1;
             $end = $limit;
         } else {
             $paginationStart += 1;
             $end = $paginationStart + 1;
         }
 
         $prev = $page - 1;
         $next = $page + 1;
         /////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////
         // Dynamic limit
         $limit2 = 10;
         // Get total records
         $allRecords2 = AdminLib::countRecordsByPatientBySymData('queue',$key);
         // Calculate total pages
         $totoalPages2 = ceil($allRecords2 / $limit2);
 
         // Current pagination page number
         $page2 = (isset($_GET['page2']) && is_numeric($_GET['page2']) ) ? $_GET['page2'] : 1;
 
         // Offset
         $paginationStart2 = ($page2 - 1) * $limit2;
 
         if ($paginationStart2 == 0) {
             $paginationStart2 = 1;
             $end2 = $limit2;
         } else {
             $paginationStart2 += 1;
             $end2 = $paginationStart2 + 1;
         }
 
         $prev2 = $page2 - 1;
         $next2 = $page2 + 1;
         /////////////////////////////////////////////////////
         $searchName=$this->request->getPost("searchName");
         if(!empty($searchName)){
            $limit2 = 10;
            // Get total records
            $allRecords2 = AdminLib::countRecordsByPatientBySymDataByName('queue',$key,$searchName);
            // Calculate total pages
            $totoalPages2 = ceil($allRecords2 / $limit2);
    
            // Current pagination page number
            $page2 = (isset($_GET['page2']) && is_numeric($_GET['page2']) ) ? $_GET['page2'] : 1;
    
            // Offset
            $paginationStart2 = ($page2 - 1) * $limit2;
    
            if ($paginationStart2 == 0) {
                $paginationStart2 = 1;
                $end2 = $limit2;
            } else {
                $paginationStart2 += 1;
                $end2 = $paginationStart2 + 1;
            }
    
            $prev2 = $page2 - 1;
            $next2 = $page2 + 1;
             $symData=QueueLib::readQueueDataByPatientKeyBySympAndName('queue', $paginationStart, $end,$key,$searchName);

         }else{
            $symData=QueueLib::readQueueDataByPatientKeyBySymp('queue', $paginationStart, $end,$key);

         }
         
         $visitedRecord=QueueLib::readQueueDataByPatientKey('queue', $paginationStart, $end,$key);
        if($patientData!=false)
        {
        $data=[
            'userInfo'=>$userInfo,
            'patientData'=>$patientData[1],
            'labData'=>$labData,
            'visitedRecord'=>$visitedRecord,
            'symData'=>$symData,
            'limit' => $limit,
            'allRecords' => $allRecords,
            'totoalPages' => $totoalPages,
            'page' => $page,
            'paginationStart' => $paginationStart,
            'prev' => $prev,
            'next' => $next,
            'limit2' => $limit2,
            'allRecords2' => $allRecords2,
            'totoalPages2' => $totoalPages2,
            'page2' => $page2,
            'paginationStart2' => $paginationStart2,
            'prev2' => $prev2,
            'next2' => $next2,
            'pageTitle'=>'Patient Profile'];
        
        return view('staff/panel',$data);
        }
    }

    }
    public function view(){
        if ($this->request->getMethod() == "get") {

    $limit = !empty(session()->get("records-limit"))
    ? session()->get("records-limit")
    : 10;

$type = !empty(session()->get("typeFilter"))
    ? session()->get("typeFilter")
    : "Any";

$allRecords = PatientLib::countRecords(
    "patient",
);
// Calculate total pages
$totoalPages = ceil($allRecords / $limit);

// Current pagination page number
$page =
    isset($_GET["page"]) && is_numeric($_GET["page"])
        ? $_GET["page"]
        : 1;

// Offset
$paginationStart = ($page - 1) * $limit;

if ($paginationStart == 0) {
    $paginationStart = 1;
    $end = $limit;
} else {
    $paginationStart += 1;
    
    $end2=$paginationStart+($limit-1);
    if($allRecords>=$end2)
    {
        $end=$end2;
    }else
    {
        $left=$end2-$allRecords;
        $end=$paginationStart+($left-1);
    }
    //$end = $paginationStart;
}
// Prev + Next
$prev = $page - 1;
$next = $page + 1;

//////

   $record = PatientLib::readData(
    $paginationStart,
    $end
);


        $userInfo=session()->get('staffloggedUser');
       
        $data=[
            'userInfo'=>$userInfo,
            'pageTitle'=>'View Patient Record',
            "patientData" => $record,
            "limit" => $limit,
            "allRecords" => $allRecords,
            "totoalPages" => $totoalPages,
            "page" => $page,
            "paginationStart" => $paginationStart,
            "prev" => $prev,
            "next" => $next,
           ];
        return view('staff/viewPatient',$data);
        }
    else{
        $limit = !empty(session()->get("records-limit"))
        ? session()->get("records-limit")
        : 1;
    $type =  $this->request->getPost("typeFilter");
    
    $allRecords = PatientLib::countRecords(
        "patient",
    );
    // Calculate total pages
    $totoalPages = ceil($allRecords / $limit);
    
    // Current pagination page number
    $page =
        isset($_GET["page"]) && is_numeric($_GET["page"])
            ? $_GET["page"]
            : 1;
    
    // Offset
    $paginationStart = ($page - 1) * $limit;
    
    if ($paginationStart == 0) {
        $paginationStart = 1;
        $end = $limit;
    } else {
        $paginationStart += 1;
        
        $end2=$paginationStart+($limit-1);
        if($allRecords>=$end2)
        {
            $end=$end2;
        }else
        {
            $left=$end2-$allRecords;
            $end=$paginationStart+($left-1);
        }
        //$end = $paginationStart;
    }
    // Prev + Next
    $prev = $page - 1;
    $next = $page + 1;
    
    //////
    
       $record = PatientLib::readDataByIc(
        $type,
        $paginationStart,
        $end
    );
    if($record==false){
       $status="fail";
    }
    if($record!=false)
    {
        $status="You have search $type Record Found!";

    
    }
    
            $userInfo=session()->get('staffloggedUser');
           
            $data=[
                'userInfo'=>$userInfo,
                'pageTitle'=>'View Patient Record',
                "patientData" => $record,
                "limit" => $limit,
                "status"=>$status,
                "allRecords" => $allRecords,
                "totoalPages" => $totoalPages,
                "page" => $page,
                "paginationStart" => $paginationStart,
                "prev" => $prev,
                "next" => $next,
               ];
            return view('staff/viewPatient',$data);
    }
    }

    public function __construct(){
        helper(['url','form']);

    }
    public function index()
    {
     
        $userInfo=session()->get('staffloggedUser');
         $data=[
        'userInfo'=>$userInfo,
        'pageTitle'=>'NEW PATIENT REGISTRATION'
     ];
        return view('staff/patientRegister',$data);
    }

    public function register()
    {
        if ($this->request->getMethod() == "post") {
            //validation for register form
        $validation=$this->validate([
            'name'=>[
                'rules'=>'required|max_length[50]|min_length[8]|alpha_space',
                'errors'=>[
                    'required'=>'Please enter your full name',
                    'max_length'=>'Maximum 50 characters only',
                    'min_length'=>'Minimum 8 characters at least'
                ]
                ],
            'email'=>[
                'rules'=>'valid_email2|checkExist[email,patient]',
                'errors'=>[
                    'valid_email2'=>'Please enter a valid email',
                    'checkExist'=>'Email already taken'
                ]
                ],
            'contact'=>[
                    'rules'=>'required|checkExist[phone,patient]|max_length[11]|checkContact',
                    'errors'=>[
                        'required'=>'Contact number is required',
                        'checkExist'=>'Contact number already taken',
                        'max_length'=>'Invalid contact number',
                        'checkContact'=>'Invalid contact number'
                    ]
                    ],
            'postcode'=>[
                    'rules'=>'required|max_length[5]|min_length[5]|checkPostcode[postcode]',
                    'errors'=>[
                        'required'=>'Postcode  is required',  
                        'matches'=>'Passwords do not match',
                        'max_length'=>'Invalid postcode',
                        'min_length'=>'Invalid postcode',
                        'checkPostcode'=>'Invalid postcode'
                        ]
                        ],
             'address'=>[
                    'rules'=>'required|max_length[100]|min_length[10]|checkHomeAddress[address]',
                    'errors'=>[
                        'required'=>'Address  is required',  
                        'max_length'=>'Maximum 100 characters only',
                        'min_length'=>'Provide more details about address',
                        'checkHomeAddress'=>'Invalid address can only contain comman, whitespace, number, letter only'
                        ]
                        ],
            'identityNum'=>[
                    'rules'=>'checkIC[identityNum]|max_length[12]|min_length[12]|required|checkExist[ic,patient]',
                    'errors'=>[
                        'required'=>'Identity Number is required',
                        'checkIC'=>'Invalid IC Number',
                        'max_length'=>'Invalid IC Number',
                        'min_length'=>'Invalid IC Number',
                        'checkExist'=>'IC already used'
                        ]
                        ]
                    ]);
        
                    if(!$validation)
                    {
                        $userInfo=session()->get('staffloggedUser');
                         $data=[
                        'userInfo'=>$userInfo,
                        'pageTitle'=>'NEW PATIENT REGISTRATION',
                        'validation'=>$this->validator
                        ]; 


                        return view('staff/patientRegister',$data);

                    }else{
                        echo 'Form validated successfully';
                        $name=$this->request->getPost('name');
                        $email=$this->request->getPost('email');
                        $identityNum=$this->request->getPost('identityNum');
                        $address=$this->request->getPost('address');
                        $contact=$this->request->getPost('contact');
                        $postcode=$this->request->getPost('postcode');
                        $Ethnicity=$this->request->getPost('Ethnicity');
                        $Allergies=$this->request->getPost('Allergies');

                        // Load the custom library
                        // Create object
                        $myic = new \App\Libraries\myic();
                        // Use the function of custom library
                        $detail=$myic->get("$identityNum");
                       
                        //get DOB date format
                        $dob=$detail['dob'];
                        $date=date_create($dob);
                        $dob=date_format($date,"Y-m-d");
            
                        //get malaysia create date
                        date_default_timezone_set('Asia/Kuala_Lumpur');
                        $CreateDate = date('Y-m-d');
                        
            
                        //values of user to array
                        $userData=[
                            'name'=>strtoupper($name),
                            'email'=>$email,
                            'gender'=>$detail['gender'],
                            'phone'=>$contact,
                            'ic'=>$identityNum,
                            'dob'=>$dob,
                            'createdDate'=>$CreateDate,
                            'state'=>$detail['state'],
                            'address'=>strtoupper($address),
                            'postCode'=>$postcode,
                            'Ethnicity'=>$Ethnicity,
                            'Allergies'=>$Allergies

                        ];
            
                        $ref_table="patient";
                        //get connection to firebase
                        $database=FirebaseCon::getCon();
                        $postRef_result=$database->getReference($ref_table)->push($userData);
                        
                        //check insert success or not
                        if(!$postRef_result){
                            return redirect()->back()->with('fail','Something went wrong');
                        }else{
                            return redirect()->to('patient/index')->with('success','You are now registered successfully');
                        }    
                    }
        }
    }
}
