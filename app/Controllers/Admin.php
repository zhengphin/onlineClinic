<?php

namespace App\Controllers;
use App\Libraries\Hash;
use App\Libraries\FirebaseCon;
use App\Libraries\AdminLib;
use App\Libraries\myic;

class Admin extends BaseController
{
    /*
    public function pagination(){

        //$record=AdminLib::paginationRecord('staff',1,3);
        //print_r($record);
        $record=AdminLib::paginationRecord('staff',1,3);
        print_r($record);
    }*/
    /*
    private function getArray( $a ) {       
        usort( $a, array( $this, 'compareDates' ) ); // pass $this for scope
        return $a;
    }  
    private function  compareDates($date1, $date2){
        if (strtotime($date1['createdDatenTime']) < strtotime($date2['createdDatenTime']))
        return 1;
     else if (strtotime($date1['createdDatenTime']) > strtotime($date2['createdDatenTime']))
        return -1;
     else
        return 0;
  
     }
    public function haha(){
        $database=FirebaseCon::getCon();
        $fetch_data=$database->getReference('staff')->getValue();
        $record=array();
        //$this->getArray($fetch_data); 
        //print_r($fetch_data);
        $i=0;
        foreach($fetch_data as $key => $row)
                {
                        $record[$i]= $row;
                        $record[$i]['key']=$key;
                        $i++;
                    
                }
        $y = array_reverse($fetch_data);
        print_R($y);
        //print_R($record[0]['createdDatenTime']);

    }*/
    public function editEmployee(){
        if ($this->request->getMethod() == "post") {
            $id=$this->request->getPost("edit_id");
            $ic=$this->request->getPost("ic");
            $name=$this->request->getPost("editname");
            $contact=$this->request->getPost("contact");
            $position=$this->request->getPost("position");
            $specialist=$this->request->getPost("specialist");
           
            if ($position == "Doctor") {
                $validation = $this->validate([
                    "editname" => [
                        "rules" =>
                            "required|max_length[50]|min_length[8]|alpha_space",
                        "errors" => [
                            "required" => "Please enter your full name",
                            "max_length" => "Maximum 50 characters only",
                            "min_length" => "Minimum 8 characters at least",
                        ],
                    ],
                    "ic" => [
                        "rules" =>
                            "checkIC[ic]|max_length[12]|min_length[12]|required|checkExistProfile[ic,staff,$id]",
                        "errors" => [
                            "required" => "Identity Number is required",
                            "checkIC" => "Invalid IC Number",
                            "max_length" => "Invalid IC Number",
                            "min_length" => "Invalid IC Number",
                            "checkExistProfile" => "IC already used",
                        ],
                    ],
                    "contact" => [
                        "rules" =>
                            "required|checkExistProfile[phone,staff,$id]|max_length[11]|checkContact",
                        "errors" => [
                            "required" => "Contact number is required",
                            "checkExist" => "Contact number already taken",
                            "max_length" => "Invalid contact number",
                            "checkExistProfile" => "Contact already taken by other.",
                        ],
                    ],      
                    "specialist" => [
                        "rules" =>
                            "required|checkHomeAddress[specialist]|max_length[30]|min_length[10]",
                        "errors" => [
                            "required" => "Specialist is required",
                            "checkHomeAddress" =>
                                "Invalid specialist can only contain comman, whitespace, number, letter only",
                        ],
                    ],
                ]);
                if (!$validation) {
                    session()->setFlashdata(
                        "nameError2",
                        display_error($this->validator, "editname")
                    );
                    session()->setFlashdata(
                        "icError2",
                        display_error($this->validator, "ic")
                    );
                  
                    session()->setFlashdata(
                        "contactError2",
                        display_error($this->validator, "contact")
                    );
                    session()->setFlashdata(
                        "positionError2",
                        display_error($this->validator, "position")
                    );
                    session()->setFlashdata(
                        "specialistError2",
                        display_error($this->validator, "specialist")
                    );
                    session()->setFlashdata("addFormErrorEdit", "addFormError");
                    $datavalue = [
                        "name" => $name,
                        "ic" => $ic,
                        "id" => $id,
                        "contact" => $contact,
                        "position" => $position,
                        "specialist" => $specialist
                    ];
                    session()->setFlashdata("fieldValue2", $datavalue);
                    return redirect()
                        ->to("Admin/manage")
                        ->withInput();

                    //return view('admin/register',['validation'=>$this->validator]);
                } else {
                    $myic = new \App\Libraries\myic();
                    // Use the function of custom library
                    $detail = $myic->get("$ic");

                    //get DOB date format
                    $dob = $detail["dob"];
                    $date = date_create($dob);
                    $dob = date_format($date, "Y-m-d");

                    

                    $staffData = [
                        "name" => $name,
                        "ic" => $ic,
                        "phone" => $contact,
                        "position" => "Doctor",
                        "specialist" => $specialist,
                        "gender" => $detail["gender"],
                        "dob" => $dob,
                        "state" => $detail["state"]
                    ];

                    $ref_table = "staff";
                    //get connection to firebase
                    $database = FirebaseCon::getCon();
                    $postRef_result = $database
                        ->getReference("staff/".$id)
                        ->update($staffData);
                    
                    //check insert success or not
                    if ($postRef_result) {
                        session()->setFlashdata(
                            "success",
                            "Successfully update employee detail."
                        );
                        return redirect()
                            ->to("Admin/manage")
                            ->withInput();
                    } else {
                       
                            session()->setFlashdata(
                                "fail",
                                "Failed to update employee detail."
                            );
                            return redirect()
                                ->to("Admin/manage")
                                ->withInput();
                    }
                }
            }
            if ($position == "Pharmacist"||$position == "Receiptionist") {
                $validation = $this->validate([
                    "editname" => [
                        "rules" =>
                            "required|max_length[50]|min_length[8]|alpha_space",
                        "errors" => [
                            "required" => "Please enter your full name",
                            "max_length" => "Maximum 50 characters only",
                            "min_length" => "Minimum 8 characters at least",
                        ],
                    ],
                    "ic" => [
                        "rules" =>
                            "checkIC[ic]|max_length[12]|min_length[12]|required|checkExistProfile[ic,staff,$id]",
                        "errors" => [
                            "required" => "Identity Number is required",
                            "checkIC" => "Invalid IC Number",
                            "max_length" => "Invalid IC Number",
                            "min_length" => "Invalid IC Number",
                            "checkExistProfile" => "IC already used",
                        ],
                    ],
                    "contact" => [
                        "rules" =>
                            "required|checkExistProfile[phone,staff,$id]|max_length[11]|checkContact",
                        "errors" => [
                            "required" => "Contact number is required",
                            "checkExist" => "Contact number already taken",
                            "max_length" => "Invalid contact number",
                            "checkExistProfile" => "Contact already taken by other.",
                        ],
                    ]      
                
                ]);
                if (!$validation) {
                    session()->setFlashdata(
                        "nameError2",
                        display_error($this->validator, "editname")
                    );
                    session()->setFlashdata(
                        "icError2",
                        display_error($this->validator, "ic")
                    );
                  
                    session()->setFlashdata(
                        "contactError2",
                        display_error($this->validator, "contact")
                    );
                    session()->setFlashdata(
                        "positionError2",
                        display_error($this->validator, "position")
                    );
                    \
                    session()->setFlashdata("addFormErrorEdit", "addFormError");
                    $datavalue = [
                        "name" => $name,
                        "ic" => $ic,
                        "id" => $id,
                        "contact" => $contact,
                        "position" => $position,
                    ];
                    if($position=="Receiptionist")
                    {
                        session()->setFlashdata("receiptionPosi", $datavalue);
                    }else{
                        session()->setFlashdata("PharmacistPosi", $datavalue);

                    }
                    session()->setFlashdata("fieldValue2", $datavalue);
                    return redirect()
                        ->to("Admin/manage")
                        ->withInput();

                    //return view('admin/register',['validation'=>$this->validator]);
                } else {
                    $myic = new \App\Libraries\myic();
                    // Use the function of custom library
                    $detail = $myic->get("$ic");

                    //get DOB date format
                    $dob = $detail["dob"];
                    $date = date_create($dob);
                    $dob = date_format($date, "Y-m-d");

                    

                    $staffData = [
                        "name" => $name,
                        "ic" => $ic,
                        "phone" => $contact,
                        "position" =>$position,
                        "gender" => $detail["gender"],
                        "dob" => $dob,
                        "state" => $detail["state"]
                    ];

                    //get connection to firebase
                    $database = FirebaseCon::getCon();
                    $postRef_result = $database
                        ->getReference("staff/".$id)
                        ->update($staffData);
                        
                    $postRef_result2 = $database
                        ->getReference("staff/".$id."/specialist")
                        ->set(null);
                    //check insert success or not
                    if ($postRef_result||$postRef_result2) {
                        session()->setFlashdata(
                            "success",
                            "Successfully update employee detail."
                        );
                        return redirect()
                            ->to("Admin/manage")
                            ->withInput();
                    } else {
                       
                            session()->setFlashdata(
                                "fail",
                                "Failed to update employee detail."
                            );
                            return redirect()
                                ->to("Admin/manage")
                                ->withInput();
                    }
                }
            }
           
        }
    }
    public function delete()
    {
        //delete_id
        if ($this->request->getMethod() == "post") {
            $id=$this->request->getPost("delete_id");
           // echo $id;
           $database = FirebaseCon::getCon();
           $postRef_result = $database
            ->getReference('staff/'.$id)
            ->remove();
            if($postRef_result)
            {
                return redirect()
                ->back()
                ->with("success", "Employee delete successfully.");
            }
            else{
                return redirect()
                ->back()
                ->with("fail", "Employee delete failed.");
            }
        }
        else{
            echo "something wrong.";
        }
    }

    private function random_password()
    {
        $alphabet =
            "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $password = [];
        $alpha_length = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alpha_length);
            $password[] = $alphabet[$n];
        }
        return implode($password);
    }
    public function __construct()
    {
        helper(["url", "form"]);
    }
    /*
    public function adddd()
    {
        $appointmentData = [
            "name" => "HENG ZHENG PHIN",
            "ic" => "000601081003",
            "email" => "hengzp2000@gmail.com",
            "phone" => "0103651003",
            "position" => "Doctor",
            "specialist" => "Allopathic ",
            "gender" => "Male",
            "dob" => "2000-06-01",
            "state" => "Perak",
            "createdDatenTime" => "2022-10-27",
        ];

        $ref_table = "staff";
        //get connection to firebase
        $database = FirebaseCon::getCon();
        $postRef_result = $database
            ->getReference($ref_table)
            ->push($appointmentData);
    }*/
    public function logout(){
        if(session()->has('adminSession')){
            session()->remove('adminSession');
            return redirect()->to('/Admin')->with('fail','You are logged out!');
        }else{
            echo "gg";
        }
    }
    public function index()
    {
        if ($this->request->getMethod() == "post") {
            $data = [
                "pageTitle" => "Manage",
            ];
            $id = $this->request->getPost("ID");
            $password = $this->request->getPost("password");
            $database = FirebaseCon::getCon();
            $isExists = AdminLib::checkRegisterServiceID($id, $password);
            if ($isExists == true) {
                //success
               // return view("admin/manage", $data);
               session()->set('adminSession','adminSession');
               return redirect()
                            ->to("Admin/manage")
                            ->withInput();
            } else {
                return redirect()
                    ->back()
                    ->with("fail", "Incorrect id or password.");
            }
        } else {
            return view("admin/login");
        }
    }
    public function manage()
    {
        // Dynamic limit
        $limit=4;
        // Get total records
        $allRecords=AdminLib::countRecords('staff');
        // Calculate total pages
        $totoalPages = ceil($allRecords / $limit);
       
        // Current pagination page number
        $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;

        // Offset
        $paginationStart = ($page - 1) * $limit;

        if($paginationStart==0)
        {
            $paginationStart=1;
            $end=$limit;
        }else{
            $paginationStart+=1;
            $end=$paginationStart+1;
        }

        // Prev + Next
        $prev = $page - 1;
        $next = $page + 1;
        //print_r($prev);
        /*
        
        $database = FirebaseCon::getCon();
        if(isset($database)){
            
            $fetch_data=$database->getReference('staff')->getValue();
            if($fetch_data>0)
            {                
                $data = [
                    "pageTitle" => "Manage",
                    "employData"=>$fetch_data
                ];
            return view("admin/dashboard", $data);
            }else{
                $data = [
                    "pageTitle" => "Manage",
                ];
            return view("admin/dashboard", $data);
            }
        }else{
            echo "gg";
        }*/
       // echo $paginationStart;
       // echo $end;
        $record=AdminLib::paginationRecord('staff',$paginationStart,$end);

        if(!empty($record)){
            $data = [
                "pageTitle" => "Manage",
                "employData"=>$record,
                'limit'=>$limit,
                'allRecords'=>$allRecords,
                'totoalPages'=>$totoalPages,
                'page'=>$page,
                'paginationStart'=>$paginationStart,
                'prev'=>$prev,
                'next'=>$next
            ];
            return view("admin/dashboard", $data);
        }else{
            $data = [
                "pageTitle" => "Manage",
                'limit'=>$limit,
                'allRecords'=>$allRecords,
                'totoalPages'=>$totoalPages,
                'page'=>$page,
                'paginationStart'=>$paginationStart,
                'prev'=>$prev,
                'next'=>$next
            ];
        return view("admin/dashboard", $data);
        }         
    }
    public function add()
    {
        $data = [
            "pageTitle" => "Add",
        ];
        if ($this->request->getMethod() == "post") {
            $name = $this->request->getPost("name");
            $ic = $this->request->getPost("ic");
            $email = $this->request->getPost("email");
            $contact = $this->request->getPost("contact");
            $position = $this->request->getPost("position");
            $specialist = $this->request->getPost("specialist");
            if ($position == "Doctor") {
                $validation = $this->validate([
                    "name" => [
                        "rules" =>
                            "required|max_length[50]|min_length[8]|alpha_space",
                        "errors" => [
                            "required" => "Please enter your full name",
                            "max_length" => "Maximum 50 characters only",
                            "min_length" => "Minimum 8 characters at least",
                        ],
                    ],
                    "ic" => [
                        "rules" =>
                            "checkIC[ic]|max_length[12]|min_length[12]|required|checkExist[ic,staff]",
                        "errors" => [
                            "required" => "Identity Number is required",
                            "checkIC" => "Invalid IC Number",
                            "max_length" => "Invalid IC Number",
                            "min_length" => "Invalid IC Number",
                            "checkExist" => "IC already used",
                        ],
                    ],
                    "contact" => [
                        "rules" =>
                            "required|checkExist[phone,staff]|max_length[11]|checkContact",
                        "errors" => [
                            "required" => "Contact number is required",
                            "checkExist" => "Contact number already taken",
                            "max_length" => "Invalid contact number",
                            "checkContact" => "Invalid contact number",
                        ],
                    ],
                    "email" => [
                        "rules" =>
                            "required|valid_email|checkExist[email,staff]",
                        "errors" => [
                            "required" => "Email is required",
                            "valid_email" => "Please enter a valid email",
                            "checkExist" => "Email already taken",
                        ],
                    ],
                    "specialist" => [
                        "rules" =>
                            "required|checkHomeAddress[specialist]|max_length[30]|min_length[10]",
                        "errors" => [
                            "required" => "Specialist is required",
                            "checkHomeAddress" =>
                                "Invalid specialist can only contain comman, whitespace, number, letter only",
                        ],
                    ],
                ]);
                if (!$validation) {
                    session()->setFlashdata(
                        "nameError",
                        display_error($this->validator, "name")
                    );
                    session()->setFlashdata(
                        "icError",
                        display_error($this->validator, "ic")
                    );
                    session()->setFlashdata(
                        "emailError",
                        display_error($this->validator, "email")
                    );
                    session()->setFlashdata(
                        "contactError",
                        display_error($this->validator, "contact")
                    );
                    session()->setFlashdata(
                        "positionError",
                        display_error($this->validator, "position")
                    );
                    session()->setFlashdata(
                        "specialistError",
                        display_error($this->validator, "specialist")
                    );
                    session()->setFlashdata("addFormError", "addFormError");
                    $datavalue = [
                        "name" => $name,
                        "ic" => $ic,
                        "email" => $email,
                        "contact" => $contact,
                        "position" => $position,
                        "specialist" => $specialist,
                    ];
                    session()->setFlashdata("fieldValue", $datavalue);
                    return redirect()
                        ->to("Admin/manage")
                        ->withInput();

                    //return view('admin/register',['validation'=>$this->validator]);
                } else {
                    $myic = new \App\Libraries\myic();
                    // Use the function of custom library
                    $detail = $myic->get("$ic");

                    //get DOB date format
                    $dob = $detail["dob"];
                    $date = date_create($dob);
                    $dob = date_format($date, "Y-m-d");

                    //get malaysia create date
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $CreateDate = date("Y-m-d");
                    $password=$this->random_password();
                    $pwd=Hash::make($password);

                    $staffData = [
                        "name" => $name,
                        "ic" => $ic,
                        "email" => $email,
                        "phone" => $contact,
                        "position" => "Doctor",
                        "specialist" => $specialist,
                        "gender" => $detail["gender"],
                        "dob" => $dob,
                        "state" => $detail["state"],
                        "password"=>$pwd,
                        "createdDatenTime" => $CreateDate,
                    ];

                    $ref_table = "staff";
                    //get connection to firebase
                    $database = FirebaseCon::getCon();
                    $postRef_result = $database
                        ->getReference($ref_table)
                        ->push($staffData);
                    //send email
                        $to=$email;
                        $subject='Please login with this password with your email';
                        //$token=$user_info['key'];
                        $message='Hi, '.$name.'<br><br>'
                        .'You account has been registered.Please Click'
                        .' the below link to login with your email and password.<br><br>'
                        .'=>'.$password.'<br><br>'
                        .'<a href="'.BASE_URL.'Staff">Click this link</a>'
                        .' ,Thanks<br>';
                        $email2 = \Config\Services::email();
                        $email2->setFrom('hengzp-am19@student.tarc.edu.my', 'Online Clinic');
                        $email2->setTo($email);
                        $email2->setSubject($subject);
                        $email2->setMessage($message);
                    //check insert success or not
                    if ($postRef_result&&$email2->send()) {
                        session()->setFlashdata(
                            "success",
                            "Successfully add a new employee."
                        );
                        return redirect()
                            ->to("Admin/manage")
                            ->withInput();
                    } else {
                       
                            session()->setFlashdata(
                                "fail",
                                "Failed to add a new employee."
                            );
                            return redirect()
                                ->to("Admin/manage")
                                ->withInput();
                    }
                }
            }
            if ($position == "Receiptionist" || $position == "Pharmacist") {
                $validation = $this->validate([
                    "name" => [
                        "rules" =>
                            "required|max_length[50]|min_length[8]|alpha_space",
                        "errors" => [
                            "required" => "Please enter your full name",
                            "max_length" => "Maximum 50 characters only",
                            "min_length" => "Minimum 8 characters at least",
                        ],
                    ],
                    "ic" => [
                        "rules" =>
                            "checkIC[ic]|max_length[12]|min_length[12]|required|checkExist[ic,staff]",
                        "errors" => [
                            "required" => "Identity Number is required",
                            "checkIC" => "Invalid IC Number",
                            "max_length" => "Invalid IC Number",
                            "min_length" => "Invalid IC Number",
                            "checkExist" => "IC already used",
                        ],
                    ],
                    "contact" => [
                        "rules" =>
                            "required|checkExist[phone,staff]|max_length[11]|checkContact",
                        "errors" => [
                            "required" => "Contact number is required",
                            "checkExist" => "Contact number already taken",
                            "max_length" => "Invalid contact number",
                            "checkContact" => "Invalid contact number",
                        ],
                    ],
                    "email" => [
                        "rules" =>
                            "required|valid_email|checkExist[email,staff]",
                        "errors" => [
                            "required" => "Email is required",
                            "valid_email" => "Please enter a valid email",
                            "checkExist" => "Email already taken",
                        ],
                    ],
                ]);
                if (!$validation) {
                    session()->setFlashdata(
                        "nameError",
                        display_error($this->validator, "name")
                    );
                    session()->setFlashdata(
                        "icError",
                        display_error($this->validator, "ic")
                    );
                    session()->setFlashdata(
                        "emailError",
                        display_error($this->validator, "email")
                    );
                    session()->setFlashdata(
                        "contactError",
                        display_error($this->validator, "contact")
                    );
                    session()->setFlashdata(
                        "positionError",
                        display_error($this->validator, "position")
                    );

                    session()->setFlashdata("addFormError", "addFormError");
                    $datavalue = [
                        "name" => $name,
                        "ic" => $ic,
                        "email" => $email,
                        "contact" => $contact,
                        "position" => $position,
                    ];
                    session()->setFlashdata("fieldValue", $datavalue);
                    return redirect()
                        ->to("Admin/manage")
                        ->withInput();

                    //return view('admin/register',['validation'=>$this->validator]);
                } else {
                    $myic = new \App\Libraries\myic();
                    // Use the function of custom library
                    $detail = $myic->get("$ic");

                    //get DOB date format
                    $dob = $detail["dob"];
                    $date = date_create($dob);
                    $dob = date_format($date, "Y-m-d");

                    //get malaysia create date
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $CreateDate = date("Y-m-d");
                    $password=$this->random_password();
                    $pwd=Hash::make($password);

                    $staffData = [
                        "name" => $name,
                        "ic" => $ic,
                        "email" => $email,
                        "phone" => $contact,
                        "position" => $position,
                        "gender" => $detail["gender"],
                        "dob" => $dob,
                        "state" => $detail["state"],
                        "createdDatenTime" => $CreateDate,
                        "password"=>$pwd
                    ];

                    $ref_table = "staff";
                    //get connection to firebase
                    $database = FirebaseCon::getCon();
                    $postRef_result = $database
                        ->getReference($ref_table)
                        ->push($staffData);
                    //send email
                    $to=$email;
                    $subject='Please login with this password with your email';
                    //$token=$user_info['key'];
                    $message='Hi, '.$name.'<br><br>'
                    .'You account has been registered.Please Click'
                    .' the below link to login with your email and password.<br><br>'
                    .'=>'.$password.'<br><br>'
                    .'<a href="'.BASE_URL.'Staff">Click this link</a>'
                    .' ,Thanks<br>';
                    $email2 = \Config\Services::email();
                    $email2->setFrom('hengzp-am19@student.tarc.edu.my', 'Online Clinic');
                    $email2->setTo($email);
                    $email2->setSubject($subject);
                    $email2->setMessage($message);
                    if($email2->send()&&$postRef_result)
                    {
                        session()->setFlashdata(
                            "success",
                            "Successfully add a new employee."
                        );
                        return redirect()
                            ->to("Admin/manage")
                            ->withInput();
                    }else{
                        session()->setFlashdata(
                            "fail",
                            "Failed to add a new employee."
                        );
                        return redirect()
                            ->to("Admin/manage")
                            ->withInput();
                    }
                    //check insert success or not
                    /*
                    if (!$postRef_result) {
                        session()->setFlashdata(
                            "fail",
                            "Failed to add a new employee."
                        );
                        return redirect()
                            ->to("Admin/manage")
                            ->withInput();
                    } else {
                        session()->setFlashdata(
                            "success",
                            "Successfully add a new employee."
                        );
                        return redirect()
                            ->to("Admin/manage")
                            ->withInput();
                    }*/
                }
            }
        }
    }
}
