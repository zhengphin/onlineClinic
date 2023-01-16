<?php

namespace App\Controllers;
use App\Libraries\StaffLib;
use App\Libraries\FirebaseCon;
use App\Libraries\Hash;
use App\Libraries\AdminLib;
use App\Libraries\ConsultLib;
use App\Libraries\ReportLib;

class Staff extends BaseController
{
    public function deleteHoliday()
    {
        if ($this->request->getMethod() == "post") {
            $id=$this->request->getPost("delete_id");
           // echo $id;
           $database = FirebaseCon::getCon();
           $postRef_result = $database
            ->getReference('holiday/'.$id)
            ->remove();
            if($postRef_result)
            {
                session()->setFlashdata('successh','Delete holiday succussfully');
                    return redirect()->to('Staff/holiday')->withInput();
    
            }
            else{
                session()->setFlashdata('fail','Something went wrong');
                return redirect()->to('Staff/holiday')->withInput();
            }
        }
        else{
            echo "something wrong.";
        
        }

    }
    public function holiday()
    { 
        if ($this->request->getMethod() == "post") {
            $date=$this->request->getPost("appdate");
            $desc=$this->request->getPost("description");
            $validation = $this->validate([
                'description' => [
                    'rules' => 'max_length[100]|min_length[2]',
                    'errors' => [
                        'max_length' => 'Maximum 100 characters only',
                        'min_length' => 'Provide more details about holiday'
                    ]
                    ]
        ]);
        if(!$validation)
        {
           

            $userInfo=session()->get('staffloggedUser');
            $data=[
                'userInfo'=>$userInfo,
                'validation'=>$this->validator,
                'pageTitle'=>'Holiday Settings'];
                return view('staff/holiday',$data);
        }else{
            $holidayData=[
                'date'=>$date,
                'desc'=>strtoupper($desc),
            ];
           
            //get connection to firebase
            $database=FirebaseCon::getCon();
            
            //$postRef_result=$database->getReference("patient/".$key)->update($userData);
            $postRef_result=$database->getReference("holiday")->push($holidayData);
            if(!$postRef_result){
                return redirect()->back()->with('failh','Something error......');

              
                }else{
                    return redirect()->back()->with('successh','Holiday Added');

                   
                }
            

        }


        }else{
        $userInfo=session()->get('staffloggedUser');
        $record=StaffLib::getHoliday();
            $data = [
                //
                'userInfo'=>$userInfo,
                'holidayData'=>$record,
                'pageTitle'=>'Holiday Settings'
            ];
           return view("staff/holiday", $data);
        }
        
    }
    public function approvedAppointment(){
        // Set session
        
       
        if ($this->request->getMethod() == "post") {
            if(!empty($this->request->getPost("records-limit")))
            {
                session()->set('records-limit',$this->request->getPost("records-limit"));

            }
            if(!empty($this->request->getPost("typeFilter")))
            {
                session()->set('typeFilter',$this->request->getPost("typeFilter"));

            }
            $searchIc=$this->request->getPost("searchIc");
            $searchDate=$this->request->getPost("searchDate");
         
        }
        $limit = !empty(session()->get('records-limit')) ?session()->get('records-limit'): 5;

        $type = !empty(session()->get('typeFilter')) ?session()->get('typeFilter'): "Any";
        //print_r($searchIc);
         // Dynamic limit   
         //$limit=5;
         // Get total records
         $allRecords=AdminLib::countRecordsStatus('appointment','approved');
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
        //print_r($type);
        if($type=='Any'&&empty($searchIc)&&empty($searchDate))
        {
        $record=StaffLib::paginationRecord1('appointment',$paginationStart,$end,'status','approved');
        }else if($type=='Walk In'&&empty($searchIc)&&empty($searchDate))
        {
        $record=StaffLib::paginationRecord3('appointment',$paginationStart,$end,'status','approved','mode','Walk In');
        }else if($type=='E-Consult'&&empty($searchIc)&&empty($searchDate))
        {
        $record=StaffLib::paginationRecord3('appointment',$paginationStart,$end,'status','approved','mode','E-Consult');
        }else if(!empty($searchIc)&&empty($searchDate))
        {
        $record=StaffLib::paginationRecordSearchIC1('appointment',$paginationStart,$end,'ic',$searchIc,'status','approved');
        }
        else if(empty($searchIc)&&!empty($searchDate))
        {
        $record=StaffLib::paginationRecordSearchIC1('appointment',$paginationStart,$end,'date',$searchDate,'status','approved');
        }

        $userInfo=session()->get('staffloggedUser');
        if(!empty($record)){
            $data = [
                //
                'userInfo'=>$userInfo,
                'pageTitle'=>'Approved Appointment',
                //
                "appointmentData"=>$record,
                'limit'=>$limit,
                'allRecords'=>$allRecords,
                'totoalPages'=>$totoalPages,
                'page'=>$page,
                'paginationStart'=>$paginationStart,
                'prev'=>$prev,
                'next'=>$next
            ];
            return view("staff/approvedAppointment", $data);
        }else{
            $data = [
                 //
                 'userInfo'=>$userInfo,
                 'pageTitle'=>'Pending',
                 //
                'limit'=>$limit,
                'allRecords'=>$allRecords,
                'totoalPages'=>$totoalPages,
                'page'=>$page,
                'paginationStart'=>$paginationStart,
                'prev'=>$prev,
                'next'=>$next
            ];
        return view("staff/approvedAppointment", $data);
        }         
    }
    public function close()
    {
        if ($this->request->getMethod() == "post") {
            $key=$this->request->getPost("key");
            $remarkSym=$this->request->getPost("remarkSym");
            $updateAt=[
                'remark'=>$remarkSym,
                'session'=>'completed'
            ];
            print_r($key);
            $database=FirebaseCon::getCon();
            if(isset($database)){
              


                //get connection to firebase
                $postRef_result=$database->getReference("appointment/".$key)->update($updateAt);

                //check insert success or not
                if(!$postRef_result){
                    return redirect()->to('Staff/consult')->with('fail','Something went wrong');

                }else{
                    return redirect()->to('Staff/consult')->with('success','Consultation has been closed.');

                }
            }
        }
    }
    public function lobby()
    {
        return view('patientDashboard/lobby');

    }
    public function meet()
    {
        $userInfo=session()->get('loggedUser');

        if(isset($_GET['room']))
        {
            $room=$_GET['room'];
            //echo $room;
           $isRoom= ConsultLib::checkRoomStaff($room);
           $checkRoomSession= ConsultLib::checkRoomSessionStaff($room);
           if($isRoom==false)
           {
            return redirect()->to('Staff/consult')->with('fail','Invalid Room.');

           }elseif($checkRoomSession==false)
           {
            return redirect()->to('Staff/consult')->with('fail','The consultation room is already completed.');

           }
           else{
            $info=ConsultLib::getRoomInfo($room);
            if($info)
            {           $staff=session()->get('staffloggedUser');

                $data=[
                    "roomInfo"=>$info,
                    "roomID"=>$room,
                    "doctorName"=>$staff['name']
                ];
                return view('staff/meet',$data);

            }else{
                echo "something went wrong";
            }
           }
        }else{
            return redirect()->to('Staff/consult')->with('fail','Something went wrong no room.');

        }
        
        //return view('patientDashboard/meet');

    }
    public function consult()
    {
        $userInfo=session()->get('staffloggedUser');
        //$data=[
       //     'userInfo'=>$userInfo,
        //    'pageTitle'=>'Remote Consultation Appointment'
        //   ];
    
       // return view('staff/consult',$data);
        /////////////////////////////////

        ////////////////////////////////////////////
        $filter="";
        if ($this->request->getMethod() == "post") {
            if(!empty($this->request->getPost("filterall")))
            {
               $filter=$this->request->getPost("filterall");
            }
        }
   $limit = !empty(session()->get("records-limit"))
   ? session()->get("records-limit")
   : 5;

$type = !empty(session()->get("typeFilter"))
   ? session()->get("typeFilter")
   : "Any";

$allRecords = ConsultLib::countAllERecords(
   "appointment"
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
if($filter=="")
{
    $record = ConsultLib::readAllDataToday(
        $paginationStart,
        $end);
}
if(!empty($filter)){
    $record = ConsultLib::readAllData(
        $paginationStart,
        $end
     );
}

/*
  $record = ConsultLib::readAllData(
   $paginationStart,
   $end
);*/
       //$userInfo=session()->get('loggedUser');
      
       $data=[
           'userInfo'=>$userInfo,
           'pageTitle'=>'Remote Consultation Appointment',
           "appointmentData" => $record,
           "limit" => $limit,
           "allRecords" => $allRecords,
           "totoalPages" => $totoalPages,
           "page" => $page,
           "paginationStart" => $paginationStart,
           "prev" => $prev,
           "next" => $next,
          ];
      return view('staff/consult',$data);
   
    }
   public function updateStatus(){
    if ($this->request->getMethod() == "post") {
        $key=$this->request->getPost("update_id");
        $status=$this->request->getPost("statuschange");
        $reason=$this->request->getPost("rejectedreason");
        $type=$this->request->getPost("mode_type");
        $email=$this->request->getPost("appemail");
        $name=$this->request->getPost("appname");
        if($status=="Cancel")
        {
            $database=FirebaseCon::getCon();
            if(isset($database)){
                $updateAt=[
                    'status'=>'cancel'
                ];
                //get connection to firebase
                $postRef_result=$database->getReference("appointment/".$key)->update($updateAt);
                //check insert success or not
                if(!$postRef_result){
                    session()->setFlashdata('fail','Appointment status update Failed');
                    return redirect()->back()->withInput();
                }else{
                    session()->setFlashdata('success','Appointment status update Successfully');
                    return redirect()->back()->withInput();
                }
            } 
        }
        if($status=="Reject"&&$type=="Walk In")
        {
            $database=FirebaseCon::getCon();
            if(isset($database)){
                $updateAt=[
                    'status'=>'rejected',
                    'rejectReason'=>$reason
                ];
                //get connection to firebase
                $postRef_result=$database->getReference("appointment/".$key)->update($updateAt);
                //check insert success or not
                if(!$postRef_result){
                    session()->setFlashdata('fail','Appointment status update Failed');
                    return redirect()->back()->withInput();
                }else{
                    //send email
                    $to=$email;
                    $subject='Your Appointment has been rejected.';
                    //$token=$user_info['key'];
                    $message='Hi, '.$name.'<br><br>'
                    .'Your appointment has been rejected please check at our website.'
                    .'The reason is because '.$reason.'<br><br>'
                    .'Please make appointment again based on our advice.<br><br>'
                    .'Thanks for you supporting<br>';
                    $email2 = \Config\Services::email();
                    $email2->setFrom('hengzp-am19@student.tarc.edu.my', 'Online Clinic');
                    $email2->setTo($email);
                    $email2->setSubject($subject);
                    $email2->setMessage($message);
                    $email2->send();
                    session()->setFlashdata('success','Appointment status update Successfully');
                    return redirect()->back()->withInput();

                }     
            }
        }
        if($status=="Reject"&&$type=="E-Consult")
        {
            $database=FirebaseCon::getCon();
            if(isset($database)){
                $updateAt=[
                    'status'=>'rejected',
                    'payment'=>'unpaid',
                    'rejectReason'=>$reason
                ];
                //get connection to firebase
                $postRef_result=$database->getReference("appointment/".$key)->update($updateAt);
                //check insert success or not
                if(!$postRef_result){
                    session()->setFlashdata('fail','Appointment status update Failed');
                    return redirect()->back()->withInput();
                }else{
                    //send email
                    $to=$email;
                    $subject='Your Appointment has been rejected.';
                    //$token=$user_info['key'];
                    $message='Hi, '.$name.'<br><br>'
                    .'Your appointment has been rejected please check at our website.'
                    .'The reason is because '.$reason.'<br><br>'
                    .'Please make appointment again based on our advice.<br><br>'
                    .'Thanks for you supporting<br>';
                    $email2 = \Config\Services::email();
                    $email2->setFrom('hengzp-am19@student.tarc.edu.my', 'Online Clinic');
                    $email2->setTo($email);
                    $email2->setSubject($subject);
                    $email2->setMessage($message);
                    $email2->send();
                    session()->setFlashdata('success','Appointment status update Successfully');
                    return redirect()->back()->withInput();

                }     
            }
        }
        if($status=="Approved"&&$type=="E-Consult")
        {
            $database=FirebaseCon::getCon();
            if(isset($database)){
                $updateAt=[
                    'status'=>'approved',
                    'payment'=>'unpaid'
                ];
                //get connection to firebase
                $postRef_result=$database->getReference("appointment/".$key)->update($updateAt);
                //check insert success or not
                if(!$postRef_result){
                    session()->setFlashdata('fail','Appointment status update Failed');
                    return redirect()->back()->withInput();
                }else{
                    //send email
                    $to=$email;
                    $subject='Your Online Consultation Appointment has been approved, please make payment';
                    //$token=$user_info['key'];
                    $message='Hi, '.$name.'<br><br>'
                    .'Your appointment has been approved please proceed payment at our website.'
                    .'Please proceed to payment in order to for us to create meeting room.<br><br>'
                    .'We will notify you through email one day before the online consultation again.<br><br>'
                    .'Thanks<br>';
                    $email2 = \Config\Services::email();
                    $email2->setFrom('hengzp-am19@student.tarc.edu.my', 'Online Clinic');
                    $email2->setTo($email);
                    $email2->setSubject($subject);
                    $email2->setMessage($message);
                    $email2->send();
                    session()->setFlashdata('success','Appointment status update Successfully');
                    return redirect()->back()->withInput();

                }     
            }
        }
        
        if($status=="Approved"&&$type=="Walk In")
        {
            $database=FirebaseCon::getCon();
            if(isset($database)){
                $updateAt=[
                    'status'=>'approved'
                ];
                //get connection to firebase
                $postRef_result=$database->getReference("appointment/".$key)->update($updateAt);
                //check insert success or not
                if(!$postRef_result){
                    session()->setFlashdata('fail','Appointment status update Failed');
                    return redirect()->back()->withInput();
                }else{
                    //send email
                    $to=$email;
                    $subject='Your Appointment has been approved.';
                    //$token=$user_info['key'];
                    $message='Hi, '.$name.'<br><br>'
                    .'Your appointment has been approved please check at our website.'
                    .'Please arrived according to the appointment date and time.<br><br>'
                    .'We will notify you through email one day before the appintment again.<br><br>'
                    .'Thanks<br>';
                    $email2 = \Config\Services::email();
                    $email2->setFrom('hengzp-am19@student.tarc.edu.my', 'Online Clinic');
                    $email2->setTo($email);
                    $email2->setSubject($subject);
                    $email2->setMessage($message);
                    $email2->send();
                    session()->setFlashdata('success','Appointment status update Successfully');
                    return redirect()->back()->withInput();

                }     
            }
        }
        echo $status;
    }
   }
    public function __construct(){
        helper(['url','form']);
    }
    public function pending(){
        // Set session
        
       
        if ($this->request->getMethod() == "post") {
            if(!empty($this->request->getPost("records-limit")))
            {
                session()->set('records-limit',$this->request->getPost("records-limit"));

            }
            if(!empty($this->request->getPost("typeFilter")))
            {
                session()->set('typeFilter',$this->request->getPost("typeFilter"));

            }
            $searchIc=$this->request->getPost("searchIc");
            $searchDate=$this->request->getPost("searchDate");
         
        }
        $limit = !empty(session()->get('records-limit')) ?session()->get('records-limit'): 5;

        $type = !empty(session()->get('typeFilter')) ?session()->get('typeFilter'): "Any";
        //print_r($searchIc);
         // Dynamic limit
         //$limit=5;
         // Get total records
         $allRecords=AdminLib::countRecords('appointment');
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
        //print_r($type);
        if($type=='Any'&&empty($searchIc)&&empty($searchDate))
        {
        $record=StaffLib::paginationRecord1('appointment',$paginationStart,$end,'status','pending');
        }else if($type=='Walk In'&&empty($searchIc)&&empty($searchDate))
        {
        $record=StaffLib::paginationRecord3('appointment',$paginationStart,$end,'status','pending','mode','Walk In');
        }else if($type=='E-Consult'&&empty($searchIc)&&empty($searchDate))
        {
        $record=StaffLib::paginationRecord3('appointment',$paginationStart,$end,'status','pending','mode','E-Consult');
        }else if(!empty($searchIc)&&empty($searchDate))
        {
        $record=StaffLib::paginationRecordSearchIC1('appointment',$paginationStart,$end,'ic',$searchIc,'status','pending');
        }
        else if(empty($searchIc)&&!empty($searchDate))
        {
        $record=StaffLib::paginationRecordSearchIC1('appointment',$paginationStart,$end,'date',$searchDate,'status','pending');
        }

        $userInfo=session()->get('staffloggedUser');
        if(!empty($record)){
            $data = [
                //
                'userInfo'=>$userInfo,
                'pageTitle'=>'Pending',
                //
                "appointmentData"=>$record,
                'limit'=>$limit,
                'allRecords'=>$allRecords,
                'totoalPages'=>$totoalPages,
                'page'=>$page,
                'paginationStart'=>$paginationStart,
                'prev'=>$prev,
                'next'=>$next
            ];
            return view("staff/pending", $data);
        }else{
            $data = [
                 //
                 'userInfo'=>$userInfo,
                 'pageTitle'=>'Pending',
                 //
                'limit'=>$limit,
                'allRecords'=>$allRecords,
                'totoalPages'=>$totoalPages,
                'page'=>$page,
                'paginationStart'=>$paginationStart,
                'prev'=>$prev,
                'next'=>$next
            ];
        return view("staff/pending", $data);
        }         
    }
    public function updatePassword(){
    $userInfo=session()->get('staffloggedUser');
    $data=[
     'userInfo'=>$userInfo,
     'pageTitle'=>'Home'
    ];
    //validation
     //validation for register form
     $validation=$this->validate([
        'currentp'=>[
            'label'=>'Current Password',
            'rules'=>'required',
            'errors'=>[
                'required'=>'Current password  is required',
                ]
            ],
        'newpassword'=>[
                'label'=>'New Password',
                'rules'=>'required|passwordCustom[newpassword]|max_length[30]|min_length[8]',
                'errors'=>[
                    'required'=>'New password  is required',
                    'passwordCustom'=>'Password must contain one digit from 1 to 9, one lowercase letter, one uppercase letter, one special character, no space, and it must be 8-30 characters long.',
                    'max_length'=>'Maximum 30 characters only',
                    'min_length'=>'Minimum 8 characters at least',
                    ]
                ],
        'cpassword'=>[
                    'rules'=>'required|matches[newpassword]',
                    'errors'=>[
                        'required'=>'Confirm Password  is required',  
                        'matches'=>'Passwords do not match'
                        ]
                        ]

    ]);
    $password=$this->request->getPost('currentp');
    $newpassword=$this->request->getPost('newpassword');

    $check_password=Hash::check($password,$userInfo['password']);

         //if validation got error go to register view and pass the parameter value
      
         if(!$validation||$check_password==false||$password==$newpassword)
         {            
            if(!$validation){
                
                session()->setFlashdata('currentPError',display_error($this->validator,'currentp'));
                session()->setFlashdata('newPError',display_error($this->validator,'newpassword'));
                session()->setFlashdata('cPError',display_error($this->validator,'cpassword'));  
                session()->setFlashdata('passError','passError');  

            }
            if($check_password==false){
                session()->setFlashdata('currentPError','Incorrect Current Password.');
          }
          if($password==$newpassword){
            session()->setFlashdata('existingPasswordError','Current password cannot same with new password.');
      }
             return redirect()->back()->withInput($data);
         }
         else{
            $pwd=Hash::make($newpassword);
            $successOrFail=StaffLib::updatePassword($userInfo['key'],$pwd);
            if($successOrFail==true)
            {
                session()->setFlashdata('success','Password update Successfully');
                return redirect()->back()->withInput($data);
            }
            else{
                session()->setFlashdata('fail','Password update Failed, Something went wrong.');
                return redirect()->back()->withInput($data);
            }
         }
}
    public function updateProfile()
    {
        $userInfo=session()->get('staffloggedUser');
        $data=[
         'userInfo'=>$userInfo,
         'pageTitle'=>'Home'
        ];
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
                    'rules'=>'required|checkExistProfile[phone,staff,'.$userInfo['key'].']|max_length[11]|checkContact',
                    'errors'=>[
                        'required'=>'Contact number is required',
                        'checkExistContact'=>'Contact number already taken',
                        'max_length'=>'Invalid contact number',
                        'checkContact'=>'Invalid contact number'
                    ]
                    ],
           
            'identityNum'=>[
                    'rules'=>'checkIC[identityNum]|max_length[12]|min_length[12]|required|checkExistProfile[ic,staff,'.$userInfo['key'].']',
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
             return redirect()->back()->withInput($data);
             //return view('patientDashboard/profile',$data);
         }
         else{
            $name=$this->request->getPost('name');
            $identityNum=$this->request->getPost('identityNum');
            $contact=$this->request->getPost('contact');
            
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
                'name'=>strtoupper($name),
                'gender'=>$detail['gender'],
                'phone'=>$contact,
                'ic'=>$identityNum,
                'dob'=>$dob,
                'state'=>$detail['state'],
            ];

            //get connection to firebase
            $database=FirebaseCon::getCon();
            $postRef_result=$database->getReference("staff/".$userInfo['key'])->update($userData);

            //check insert success or not
            if(!$postRef_result){
                return redirect()->to('staff/profile')->with('fail','Something went wrong!');
            }else{
                $user_info=StaffLib::getUserInfoByEmail($userInfo['email']);
                session()->remove('staffloggedUser');
                session()->set('staffloggedUser',$user_info);
                return redirect()->to('staff/profile')->with('success','Profile update successfully.');
            }     
           
         }
        //unset session reset the session data
        //insert
    }
    public function handleAjaxRequest(){
        // $request=\Config\Services::Request();
 
        $data=$this->request->getVar();
         $imgurl=$this->request->getVar('name');
         $key=$this->request->getVar('key');
         $checkUpdate=StaffLib::updatedProfileImg($key,$imgurl);
       
         echo json_encode(array(
             "status"=>1,
             "message"=>"Successful request",
             "data"=>$data
         ));
 
     }
    public function uploadImage()
    {
        $userInfo=session()->get('staffloggedUser');
        $data=[
         'userInfo'=>$userInfo,
         'pageTitle'=>'Profile'
        ];
    
        if($this->request->getMethod()=='post')
        {
            $rules=[
            'image'=>[
                'rules'=>'uploaded[image]|max_size[image,4000]|is_image[image]|max_dims[image,500,500]',
                'label'=>'image',
                'errors'=>[
                    'uploaded'=>'Image uploaded file is required',  
                    'max_size'=>'Image file cannot over 4mb',
                    'is_image'=>'Uploaded file is not a valid, please upload image file',
                    'max_dims'=>'Image dimession must within 500 x 500'
                    //'ext_in'=>'The file does not have a valid file extension, only accept png,jpeg,jpg'
                    ]
            ]
            ];
        }
        if($this->validate($rules))
        {
            //$file=$this->request->getFile('userfile');
           // echo $file->getName();
           // exit();
           $file=$this->request->getFile('image');
         
           if($file->isValid()){   
            //echo '<script>alert("Welcome to Geeks for Geeks")</script>';
            session()->setFlashdata('processing','update image');
            $newName = $file->getRandomName(); //This is if you want to change the file name to encrypted name
            $file->move(ROOTPATH . 'public/images/users', $newName);
            $directory = ROOTPATH."'public/images/users/$newName'";
            session()->setFlashdata('dir',$newName);
            return redirect()->to('staff/profile')->withInput($data);
            
           }
        }else{
            session()->setFlashdata('fail',display_error($this->validator,'image'));
            return redirect()->to('staff/profile')->withInput($data);
        }
    }
    public function logout(){
        if(session()->has('staffloggedUser')){
            session()->remove('staffloggedUser');
            return redirect()->to('/Staff')->with('fail','You are logged out!');
        }else{
            echo "gg";
        }
    }
    public function profile(){
        $userInfo=session()->get('staffloggedUser');
        $user_info=StaffLib::getUserInfoByEmail($userInfo['email']);
        session()->remove('staffloggedUser');
        session()->set('staffloggedUser',$user_info);

        $data=[
            'userInfo'=>$user_info,
            'pageTitle'=>'Profile'
           ];
    
        return view('staff/profile',$data);
    }
    public function home()
    {
        $staff_info=session()->get('staffloggedUser');
        $topServicesData=ReportLib::countTopThreeWalkingServices();

        
        $sorting = array_column($topServicesData, 'count');
        $price=array_multisort($sorting, SORT_DESC, $topServicesData);
        
        $data=[
         'userInfo'=>$staff_info,
         'totalvisitor'=>ReportLib::totalvistor(),
         'totalvisitorweek'=>ReportLib::totalvistorweek(),
         'totalonlineuser'=>ReportLib::totalOnlineUser(),
         'totalOnlineConsultationRevenue'=>ReportLib::totalOnlineConsultationRevenue(),
         'totalClinicUser'=>ReportLib::totalClinicUser(),
         'totalWalkInRevenue'=>ReportLib::totalWalkInRevenue(),
         'topsalesproduct'=>ReportLib::topsalesproduct(),
         'almostExpiredInventory'=>ReportLib::almostExpiredInventory(),
         'topServicesData'=>$topServicesData,
         'lowInventory'=>ReportLib::lowInventory(),
         'pageTitle'=>'Home'
        ];
       // $haha=ReportLib::topsalesproduct();
       //print_r($haha[0]['medicineName']);
        //print_r($topServicesData);
        //print_r(ReportLib::totalvistor());
     return view('staff/index',$data);
    }
    public function index()
    {
        if ($this->request->getMethod() == "post") {
            $data = [
                "pageTitle" => "Home",
            ];
            $email= $this->request->getPost("email");
            $password = $this->request->getPost("password");
            //$database = FirebaseCon::getCon();
            $isExists = StaffLib::checkRegisterStaff($email, $password);
            if ($isExists == true) {
                $staff_info=StaffLib::getUserInfoByEmail($email);
                if($staff_info!=false)
                {
                    session()->set('staffloggedUser',$staff_info);
                    return redirect()->to('staff/home');
                }else{
                    return redirect()
                    ->back()
                    ->with("fail", "Sorry something went wrong.");
                }
            } else {
                return redirect()
                    ->back()
                    ->with("fail", "Incorrect email or password.");
            }
        }else {
            return view('staff/login');
        }
    }
}
