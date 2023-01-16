<?php

namespace App\Controllers;
use App\Libraries\myic;
use App\Libraries\Hash;
use App\Libraries\FirebaseCon;
use App\Libraries\User;
use App\Libraries\PatientLib;

class Auth extends BaseController
{
    
    private function checkExpiryDate($time){
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $now_timestamp= strtotime(date('Y-m-d h:i:s'));
        //15min
        $diffInSeconds =$now_timestamp- strtotime($time);
        if($diffInSeconds<900&&$diffInSeconds>0){
            //print_r($diffInSeconds);
            return true;
        }else{
           //print_r($diffInSeconds);
            return false;
        }
    }
    public function reset($token=null){
        $data=[];
        if(!empty($token))
        {
            $updateTime=User::verifyToken($token);
            //print_r($updateTime);
            if(!empty($updateTime)){
                if($this->checkExpiryDate($updateTime)){
                 if($this->request->getMethod()=='post'){
                    $validation=$this->validate([
                        'password'=>[
                            'label'=>'Password',
                            'rules'=>'passwordCustom[password]|max_length[30]|min_length[8]|required',
                            'errors'=>[
                                'passwordCustom'=>'Password must contain one digit from 1 to 9, one lowercase letter, one uppercase letter, one special character, no space, and it must be 8-30 characters long.',
                                'max_length'=>'Maximum 30 characters only',
                                'min_length'=>'Minimum 8 characters at least',
                                'required'=>'Password  is required',
                                
                                ]
                                ],
                                'cpassword'=>[
                                        'rules'=>'required|matches[password]',
                                        'errors'=>[
                                            'required'=>'Confirm Password  is required',  
                                            'matches'=>'Passwords do not match'
                                            ]
                                            ]
                            ]);
                    if(!$validation)
                    {
                    session()->setFlashdata('validation',display_error($this->validator,'password'));
                    session()->setFlashdata('validation2',display_error($this->validator,'cpassword'));
                    return redirect()->to(current_url())->withInput();

                    }else{
                        $pwd=Hash::make($this->request->getPost('password'));
                        $successOrFail=User::updatePassword($token,$pwd);
                        if($successOrFail==true)
                        {
                            return redirect()->to('Auth')->with('success','Password Reset Successfully, Please Login Now.');

                        }
                        else{
                            session()->setFlashdata('fail','Password Reset Failed, Something went wrong.');
                            return redirect()->to(current_url())->withInput();

                        }
                    }
                 }
                }else{
                    $data['error']='Reset password link was expired.';
                }
            }
            else{
                //wrong token
                $data['error']='Unable to find user account';
            }
        }
        else{
            // no token
            $data['error']='Sorry Unauthorized Access.';
        }
        return view('auth/resetPassword',$data);
        

    }
    public function forgot(){
        return view('auth/forgot');

    }
    public function emailVertify(){
            $validation=$this->validate([
            'email'=>[
                'rules'=>'required|valid_email|checkRegisterServiceEmail[email][email,users]',
                'errors'=>[
                    'required'=>'Email is required',
                    'valid_email'=>'Please enter a valid email',
                    'checkNotExist'=>'Email Not Registered At Our Service'
                    ]
                    ]
                ]);
                //check got error
                if(!$validation)
                {
                    return view('Auth/forgot',['validation'=>$this->validator]);
                }
                else{
                    $email=$this->request->getPost('email');
                    $user_info=User::getUserInfoByEmail($email);
                    $checkUpdate=User::updatedAt($user_info['key']);
                    if($checkUpdate==true){                    
                
                    $to=$email;
                    $subject='Reset Password Link';
                    $token=$user_info['key'];
                    $message='Hi, '.$user_info['name'].'<br><br>'
                    .'Your reset password request has been received.Please Click'
                    .' the below link to reset your password.<br><br>'
                    .'<a href="'.BASE_URL.'Auth/reset/'.$token.'">Click this link</a>'
                    .' ,Thanks<br>';
                    $email = \Config\Services::email();
                    $email->setFrom('hengzp-am19@student.tarc.edu.my', 'Online Clinic');
                    $email->setTo($user_info['email']);
                    $email->setSubject($subject);
                    $email->setMessage($message);
                    if($email->send())
                    {
                                return redirect()->to('Auth/forgot')->with('success','Reset Password link sent to your registered email. Please verify within 15mins');

                    }
                    else{
                                return redirect()->to('Auth/forgot')->with('fail','Something went wrong, please try again.');

                    }
                   //return redirect()->to('Auth/forgot')->with('success','Reset Password link sent to your registered email. Please verify within 15mins');
                    }
                    else{
                   //return redirect()->to('Auth/forgot')->with('fail','Something went wrong, please try again.');
                    }
                }
    }
    public function __construct(){
        helper(['url','form']);

    }
    public function Index()
    {
        
        return view('auth/login');
    }
    public function register()
    {
        return view('auth/register');
    }
    public function save()
    {
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
                'rules'=>'required|valid_email|checkExist[email,users]',
                'errors'=>[
                    'required'=>'Email is required',
                    'valid_email'=>'Please enter a valid email',
                    'checkExist'=>'Email already taken'
                ]
                ],
            'contact'=>[
                    'rules'=>'required|checkExist[phone,users]|max_length[11]|checkContact',
                    'errors'=>[
                        'required'=>'Contact number is required',
                        'checkExist'=>'Contact number already taken',
                        'max_length'=>'Invalid contact number',
                        'checkContact'=>'Invalid contact number'
                    ]
                    ],
            'password'=>[
                    'rules'=>'passwordCustom[password]|max_length[30]|min_length[8]|required',
                    'errors'=>[
                        'passwordCustom'=>'Password must contain one digit from 1 to 9, one lowercase letter, one uppercase letter, one special character, no space, and it must be 8-30 characters long.',
                        'max_length'=>'Maximum 30 characters only',
                        'min_length'=>'Minimum 8 characters at least',
                        'required'=>'Password  is required',
                        ]
                    ],
            'cpassword'=>[
                    'rules'=>'required|matches[password]',
                    'errors'=>[
                        'required'=>'Confirm Password  is required',  
                        'matches'=>'Passwords do not match'
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
                    'rules'=>'checkIC[identityNum]|max_length[12]|min_length[12]|required|checkExist[ic,users]',
                    'errors'=>[
                        'required'=>'Identity Number is required',
                        'checkIC'=>'Invalid IC Number',
                        'max_length'=>'Invalid IC Number',
                        'min_length'=>'Invalid IC Number',
                        'checkExist'=>'IC already used'
                        ]
                        ]
                    ]);
        //if validation got error go to register view and pass the parameter value
        if(!$validation)
        {
            return view('auth/register',['validation'=>$this->validator]);
        }
        else{
            echo 'Form validated successfully';
            $name=$this->request->getPost('name');
            $email=$this->request->getPost('email');
            $password=$this->request->getPost('password');
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

            //get malaysia create date
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $CreateDate = date('Y-m-d');
            

            //values of user to array
            $userData=[
                'name'=>strtoupper($name),
                'email'=>$email,
                'password'=>Hash::make($password),
                'gender'=>$detail['gender'],
                'phone'=>$contact,
                'ic'=>$identityNum,
                'dob'=>$dob,
                'createdDate'=>$CreateDate,
                'state'=>$detail['state'],
                'address'=>strtoupper($address),
                'postCode'=>$postcode
            ];

            $ref_table="users";
            //get connection to firebase
            $database=FirebaseCon::getCon();
            $postRef_result=$database->getReference($ref_table)->push($userData);

            //check registed already at patient? no go for the clinci for first time
            $isRegistered=PatientLib::CheckPatientRegistered($identityNum);
            if($isRegistered==false){
            //insert patient
            $patientData=[
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
                'Ethnicity'=>"",
                'Allergies'=>""

            ];

            $ref_table2="patient";
            //get connection to firebase
            $postRef_result2=$database->getReference($ref_table2)->push($patientData);
             }
            //check insert success or not
            if(!$postRef_result){
                return redirect()->back()->with('fail','Something went wrong');
            }else{
                return redirect()->to('Auth/register')->with('success','You are now registered successfully');
            }     
        }
    }

    public function check()
    {
        $validation=$this->validate([
            'email'=>[
                'rules'=>'required|valid_email|checkRegisterServiceEmail[email]',
                'errors'=>[
                    'required'=>'Email is required',
                    'valid_email'=>'Enter a valid email address',
                    'checkRegisterServiceEmail'=>'This email is not registered on our service'
                ]
                ],
            'password'=>[
                'rules'=>'required',
                'error'=>[
                    'required'=>'Password is required'
                ]
            ]
            ]);
        //if validation got error
        if(!$validation)
        {
           return view('auth/login',['validation'=>$this->validator]);
        }
        //if validation no error
        else
        {
            $email=$this->request->getPost('email');
            $password=$this->request->getPost('password');
            $user_info=User::getUserInfoByEmail($email);
            $check_password=Hash::check($password,$user_info['password']);
        
            /* Test the result 
            foreach ($user_info as $key => $value) {
           echo "$key: $value\n";
            }
            print_r($user_info);
            */
            // if wrong
            if(!$check_password){
                session()->setFlashdata('fail','Incorrect password');
                return redirect()->to('/Auth')->withInput();
            }else
            {
            //$user_id=$user_info['key'];
            session()->set('loggedUser',$user_info);
            return redirect()->to('patient/home');
            }

        }

    }
}