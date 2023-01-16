<?php

namespace App\Controllers;
use App\Libraries\myic;
use App\Libraries\Hash;
use App\Libraries\FirebaseCon;
use App\Libraries\User;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Exception\FirebaseException;
use App\Libraries\QueueLib;
use App\Libraries\AppointmentLib;
use App\Libraries\PaymentLib;
use App\Libraries\PatientLib;



class PatientDash extends BaseController
{
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
    public function history()
    {
        $userInfo=session()->get('loggedUser');
        $user_info=User::getUserInfoByEmail($userInfo['email']);
        $patientKey=PatientLib::readPatientKeyByIC($user_info['ic']);

    ////////////////////////////////////////////
    $limit = !empty(session()->get("records-limit"))
            ? session()->get("records-limit")
            : 10;

    $type = !empty(session()->get("typeFilter"))
            ? session()->get("typeFilter")
            : "Any";

    $allRecords = AppointmentLib::countRecordsMulti(
            $patientKey
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

           $record = PaymentLib::readData(
            $userInfo["email"],
            $paginationStart,
            $end
        );

        $visitedRecord=QueueLib::readQueueDataByPatientKey('queue', $paginationStart, $end,$patientKey);

        $data=[
            'userInfo'=>$user_info,
            'pageTitle'=>'Visit History',
            "appointmentData" => $record,
            "visitedRecord"=>$visitedRecord,
            "limit" => $limit,
            "allRecords" => $allRecords,
            "totoalPages" => $totoalPages,
            "page" => $page,
            "paginationStart" => $paginationStart,
            "prev" => $prev,
            "next" => $next,
           ];

       return view('patientDashboard/history',$data);
    }
    public function number()
    {
        date_default_timezone_set("Asia/Kuala_Lumpur");

        $TodayDate = date('Y-m-d');
        
        $waitingData=QueueLib::readDataWaiting($TodayDate);

        //print_r($waitingData);
        
        $userInfo=session()->get('loggedUser');
        $data=[
         'userInfo'=>$userInfo,
         'pageTitle'=>'Queue position',
         'waitingData'=>$waitingData
                ];
        return view('patientDashboard/number',$data);
    }
    public function __construct(){
        helper(['url','form']);

    }
    public function updatePassword(){
        $userInfo=session()->get('loggedUser');
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
                $successOrFail=User::updatePassword($userInfo['key'],$pwd);
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
    public function handleAjaxRequest(){
       // $request=\Config\Services::Request();

       $data=$this->request->getVar();
        $imgurl=$this->request->getVar('name');
        $key=$this->request->getVar('key');
        $checkUpdate=User::updatedProfileImg($key,$imgurl);
        /*
        $user_info=User::getUserInfoByEmail($email);
        session()->remove('loggedUser');
        session()->set('loggedUser',$user_info);
        $userInfo=session()->get('loggedUser');
        $data=[
         'userInfo'=>$userInfo,
         'pageTitle'=>'Profile'
        ];*/
        echo json_encode(array(
            "status"=>1,
            "message"=>"Successful request",
            "data"=>$data
        ));
        //session()->setFlashdata('success','Upload Image Successfully');
        //return redirect()->to('patient/profile')->withInput($data);

      
    
       // $checkUpdate=User::updatedProfileImg($userInfo['key'],$imgurl);
    //echo '<script>alert("Welcome to Geeks for Geeks")</script>';
        
    }

    public function uploadImage()
    {
        $userInfo=session()->get('loggedUser');
        $data=[
         'userInfo'=>$userInfo,
         'pageTitle'=>'Home'
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
            return redirect()->to('patient/profile')->withInput($data);
            
           }
        }else{
            session()->setFlashdata('fail',display_error($this->validator,'image'));
            return redirect()->to('patient/profile')->withInput($data);

        }
        //return view('patientDashboard/profile',$data);

        /*if (! $this->validate($validationRule)) {
            session()->setFlashdata('fail',display_error($this->validator,'avatar'));
            return redirect()->to('PatientDash/Profile')->withInput($data);
        }*/
    }

    public function updateProfile()
    {
        $userInfo=session()->get('loggedUser');
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
                    'rules'=>'required|checkExistProfile[phone,users,'.$userInfo['key'].']|max_length[11]|checkContact',
                    'errors'=>[
                        'required'=>'Contact number is required',
                        'checkExistProfile'=>'Contact number already taken',
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
                    'rules'=>'checkIC[identityNum]|max_length[12]|min_length[12]|required|checkExistProfile[ic,users,'.$userInfo['key'].']',
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
             return redirect()->back()->withInput($data);
             //return view('patientDashboard/profile',$data);
         }
         else{
            $name=$this->request->getPost('name');
            $identityNum=$this->request->getPost('identityNum');
            $address=$this->request->getPost('address');
            $contact=$this->request->getPost('contact');
            $postcode=$this->request->getPost('postcode');
            
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
                'address'=>strtoupper($address),
                'postCode'=>$postcode
            ];

            $ref_table="users";
            //get connection to firebase
            $database=FirebaseCon::getCon();
            $postRef_result=$database->getReference("users/".$userInfo['key'])->update($userData);

            //check insert success or not
            if(!$postRef_result){
                return redirect()->to('patient/profile')->with('fail','Something went wrong!');
            }else{
                $user_info=User::getUserInfoByEmail($userInfo['email']);
                $oldIc=$userInfo['ic'];
                User::updateAllAppointmentIC($oldIc,$identityNum);
                User::updateAllPatientIC($oldIc,$identityNum);

                session()->remove('loggedUser');
                session()->set('loggedUser',$user_info);
                return redirect()->to('patient/profile')->with('success','Profile update successfully.');
            }     
           
         }
        //unset session reset the session data
        //insert
    }
    public function home()
    {
        $userInfo=session()->get('loggedUser');
        
        $patientKey=PatientLib::readPatientKeyByIC($userInfo['ic']);
        $data=[
         'userInfo'=>$userInfo,
         'patientKey'=>$patientKey,
         'pageTitle'=>'Home'
        ];
        return view('patientDashboard/index',$data);
    }
    public function profile()
    {

        $userInfo=session()->get('loggedUser');
        $user_info=User::getUserInfoByEmail($userInfo['email']);
        session()->remove('loggedUser');
        session()->set('loggedUser',$user_info);

        $data=[
            'userInfo'=>$user_info,
            'pageTitle'=>'Profile'
           ];
    
        return view('patientDashboard/profile',$data);
    }
    public function logout()
    {
        if(session()->has('loggedUser')){
            session()->remove('loggedUser');
            return redirect()->to('/Auth')->with('fail','You are logged out!');

        }
    }

}
