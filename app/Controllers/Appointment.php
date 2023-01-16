<?php

namespace App\Controllers;
use App\Libraries\FirebaseCon;
use App\Libraries\AppointmentLib;
use App\Libraries\PatientLib;

class Appointment extends BaseController
{
    public function createAppointment()
    {
        if($this->request->getMethod() == "get")
        {
            $patientKey=$_GET["patient"];
            $userInfo=session()->get('staffloggedUser');
            $data=[
                'userInfo'=>$userInfo,
                'patientkey'=>$patientKey,
                'pageTitle'=>'Create Appointment'];
                return view('staff/appointment',$data);
            
        }
        if ($this->request->getMethod() == "post") {
            if(isset($_POST['submitAppointment'])){
                $userInfo=session()->get('staffloggedUser');
                $patientkey = $this->request->getPost("addAppPatientID");
                $patientData=PatientLib::readDataByKey($patientkey);
                //$patientData[1][]
                $isForSelf ="My Self";
                $mode ="Walk In";
                $isallergies = $this->request->getPost("allergies");
                $date = $this->request->getPost("appdate");
                $time = $this->request->getPost("apptime");
                $services = $this->request->getPost("services");
                $reason = $this->request->getPost("reason");

                $validation = $this->validate([
                    "appdate" => [
                        "rules" =>
                            "required|checkAppDate[appdate]|checkAppDateHoliday[appdate]",
                        "errors" => [
                            "required" => "Date is required",
                            "checkAppDate" => "Please select a valid date",
                            "checkAppDateHoliday" =>
                                "Sorry, we do not open on that day.",
                        ],
                    ],
                    "apptime" => [
                        "rules" => "required|checkAppTime[apptime]",
                        "errors" => [
                            "required" => "Time is required",
                            "checkAppTime" =>
                                "Invalid time only available 9am-11pm",
                        ],
                    ],
                    "services" => [
                        "rules" => "required",
                        "errors" => [
                            "required" => "Service Type is required",
                        ],
                    ],
                    "reason" => [
                        "rules" =>
                            "required|checkHomeAddress[reason]|max_length[100]|min_length[10]",
                        "errors" => [
                            "required" =>
                                "Please provide some reason for the appointment.",
                            "checkHomeAddress" =>
                                "Text area only accept comman and dot.",
                            "min_length" =>
                                "Please provide more details about the reason",
                        ],
                    ],
                ]);
                $istrue = $this->checkBookingTime($time, $date);
    
                if (!$validation || $istrue == false) {
                    session()->setFlashdata(
                        "appdateError",
                        display_error($this->validator, "appdate")
                    );
                    session()->setFlashdata(
                        "apptimeError",
                        display_error($this->validator, "apptime")
                    );
                    session()->setFlashdata(
                        "servicesError",
                        display_error($this->validator, "services")
                    );
                    session()->setFlashdata(
                        "reasonError",
                        display_error($this->validator, "reason")
                    );
                    if ($istrue == false) {
                        session()->setFlashdata(
                            "apptimeError",
                            "Please make an appointment 30 minutes in advance"
                        );
                    }
                    /*
                    return redirect()
                        ->back()
                        ->withInput();
                    */
                    return redirect()->to('staff/createAppointment?patient='.$patientkey.'')->withInput();

                } else {
                   
   
                        date_default_timezone_set("Asia/Kuala_Lumpur");
                        $requestDate = date("Y-m-d h:i:s");
                        $gotEmail=$patientData[1]['email'];
                        if($gotEmail!="")
                        {
                            $email=$patientData[1]['email'];
                        }else{
                            $email="";

                        }
                        //values of user to array
                        $appointmentData = [
                            "allergies" => $isallergies,
                            "who" => $isForSelf,
                            "date" => $date,
                            "time" => $time,
                            "mode" => $mode,
                            "service" => $services,
                            "reason" => $reason,
                            "status" => "approved",
                            "user" =>$email,
                            "ic" => $patientData[1]["ic"],
                            "createdDatenTime" => $requestDate,
                        ];
    
                        $ref_table = "appointment";
                        //get connection to firebase
                        $database = FirebaseCon::getCon();
                        $postRef_result = $database
                            ->getReference($ref_table)
                            ->push($appointmentData);
                        //check insert success or not
                        if (!$postRef_result) {
                            session()->setFlashdata('fail','Appointment Added Fail Please Try Again');
                            return redirect()->to('staff/panel?patient='.$patientkey.'')->withInput();
            
                        } else {
                            session()->setFlashdata('success','Appointment registered successfully');
                            return redirect()->to('staff/panel?patient='.$patientkey.'')->withInput();
                        
                        }
                        //check how many appoint for today only 2 by checking the status peding
                    
                }
            
            
        }
        else{
            $patientkey = $this->request->getPost("addAppPatientID");
            $userInfo=session()->get('staffloggedUser');
            $data=[
                'userInfo'=>$userInfo,
                'patientkey'=>$patientkey,
                'pageTitle'=>'Create Appointment'];
                return view('staff/appointment',$data);
            }
            
        }
    }
    public function editAppointment(){
        if ($this->request->getMethod() == "post") {
            $date = $this->request->getPost("appdate");
            $time = $this->request->getPost("apptime");
            $id = $this->request->getPost("edit_id");
            $status = $this->request->getPost("edit_status");

        //echo $id;
        //echo $status;
        if($status=="cancel")
        {
            session()->setFlashdata(
                "fail",
                "You cannot update a cancel appointment. Please make a new appointment"
            );
            return redirect()
                            ->back()
                            ->withInput();
        }
        if($status=="rejected")
        {
            session()->setFlashdata(
                "fail",
                "You cannot update a cancel appointment. Please make a new appointment"
            );
            return redirect()
                            ->back()
                            ->withInput();
        }
        if($status=="pending"){
        $validation = $this->validate([
            "appdate" => [
                "rules" =>
                    "required|checkAppDate[appdate]|checkAppDateHoliday[appdate]",
                "errors" => [
                    "required" => "Date is required",
                    "checkAppDate" => "Please select a valid date",
                    "checkAppDateHoliday" =>
                        "Sorry, we do not open on that day.",
                ],
            ],
            "apptime" => [
                "rules" => "required|checkAppTime[apptime]",
                "errors" => [
                    "required" => "Time is required",
                    "checkAppTime" =>
                        "Invalid time only available 9am-11pm",
                ],
            ]
            ]);
            $istrue = $this->checkBookingTime($time, $date);

            if (!$validation || $istrue == false) {
                session()->setFlashdata(
                    "appdateError",
                    display_error($this->validator, "appdate")
                );
                session()->setFlashdata(
                    "apptimeError",
                    display_error($this->validator, "apptime")
                );
                if ($istrue == false) {
                    session()->setFlashdata(
                        "apptimeError",
                        "Please make an appointment 30 minutes in advance"
                    );
                }
                session()->setFlashdata(
                    "editError",
                    "editError"
                );
                return redirect()
                    ->back()
                    ->withInput();
            }else{
                $database = FirebaseCon::getCon();
                if (isset($database)) {
                    $updateAt = [
                        "date" => $date,
                        "time" => $time
                    ];
                    //get connection to firebase
                    $postRef_result = $database
                        ->getReference("appointment/" . $id)
                        ->update($updateAt);
                    //check insert success or not
                    if (!$postRef_result) {
                        session()->setFlashdata(
                            "fail",
                            "Appointment update Failed"
                        );
                        return redirect()
                            ->back()
                            ->withInput();
                    } else {
                        session()->setFlashdata(
                            "successEdit",
                            "successEdit"
                        );
                        return redirect()
                            ->back()
                            ->withInput();
                    }
                } else {
                    session()->setFlashdata("fail", "Something went wrong.");
                    return redirect()
                        ->back()
                        ->withInput();
                }
            }
        
        } 
     
        }
    }
    private function checkBookingTime($str, $date)
    {
        //Get total current minutes
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $currentTime = date("H:i");
        $currentTime = str_replace(":", ".", $currentTime);
        $str_arr = explode(".", $currentTime);
        $min = $str_arr[0] * 60;
        $currentTimeTotalMinutes = $min + $str_arr[1];
        ///////////////////////////////////////////
        //Get total booking minutes
        $book_time = str_replace(":", ".", $str);
        $str_arr2 = explode(".", $book_time);
        $min2 = $str_arr2[0] * 60;
        $BookingTimeTotalMinutes = $min2 + $str_arr2[1];
        /////////////////////
        $today = date("Y-m-d");
        if ($date > $today) {
            return true; //correct
        } else {
            if ($currentTimeTotalMinutes > $BookingTimeTotalMinutes) {
                return false;
            } else {
                //early 30 min
                $balance = $BookingTimeTotalMinutes - $currentTimeTotalMinutes;
                print_r($balance);
                if ($balance < 30) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
   
    public function time()
    {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $today = date("H:i");
        $my_time = "22:00";
        echo $today;
        if (strtotime($today) > strtotime($my_time)) {
            echo "early";
        } else {
            echo "late";
        }
        $time = strtotime($today);
        $endTime = date("H:i", strtotime("+30 minutes", $time));
        if ($my_time > $time) {
            echo "good";
        } else {
            echo "?";
        }

        echo $endTime;
    }
    public function time2()
    {
        //$str="13:12";
        //$time=str_replace(':', '.', $str);
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $current = date("H:i");
        $current = str_replace(":", ".", $current);
        $str_arr = explode(".", $current);
        $min = $str_arr[0] * 60;
        echo $min + $str_arr[1];
        $total1 = $min + $str_arr[1];
        echo "\n";
        $book_time = "13:12";
        $book_time = str_replace(":", ".", $book_time);
        $str_arr2 = explode(".", $book_time);
        $min2 = $str_arr2[0] * 60;
        echo $min2 + $str_arr2[1];
        $total2 = $min2 + $str_arr2[1];
        echo $total1 - $total2;

        //$balance=$time-$current;
        //$str_arr = explode (".", $balance);
        //print_r($str_arr);
        //$str_arr[0]=$str_arr[0]*60;
        //print_r($str_arr[0]+$str_arr[1]);
        //echo $balance;
        //if($time<$current)
        // {
        //    echo "invalid time";
        // }
        //else{
        //if($balance>=30)
        //  }
    }

    public function cancelAppointment()
    {
        if ($this->request->getMethod() == "post") {
            $key = $this->request->getPost("cancel_id");
            $status = $this->request->getPost("status_id");
            $date = $this->request->getPost("date_id");
            $time = $this->request->getPost("time_id");

            if ($status == "pending") {
                $database = FirebaseCon::getCon();
                if (isset($database)) {
                    $updateAt = [
                        "status" => "cancel",
                    ];
                    //get connection to firebase
                    $postRef_result = $database
                        ->getReference("appointment/" . $key)
                        ->update($updateAt);
                    //check insert success or not
                    if (!$postRef_result) {
                        session()->setFlashdata(
                            "fail",
                            "Appointment status update Failed"
                        );
                        return redirect()
                            ->back()
                            ->withInput();
                    } else {
                        session()->setFlashdata(
                            "successCancel",
                            "successCancel"
                        );
                        return redirect()
                            ->back()
                            ->withInput();
                    }
                } else {
                    session()->setFlashdata("fail", "Something went wrong.");
                    return redirect()
                        ->back()
                        ->withInput();
                }
            } elseif ($status == "approved") {
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $today = date("Y-m-d");
                if ($date < $today) {
                    session()->setFlashdata("fail", "You cannot cancel because it already after appointment date.");
                    return redirect()
                        ->back()
                        ->withInput();
                }else if($date>$today)
                {
                    $database = FirebaseCon::getCon();
                if (isset($database)) {
                    $updateAt = [
                        "status" => "cancel",
                    ];
                    //get connection to firebase
                    $postRef_result = $database
                        ->getReference("appointment/" . $key)
                        ->update($updateAt);
                    //check insert success or not
                    if (!$postRef_result) {
                        session()->setFlashdata(
                            "fail",
                            "Appointment status update Failed"
                        );
                        return redirect()
                            ->back()
                            ->withInput();
                    } else {
                        session()->setFlashdata(
                            "successCancel",
                            "successCancel"
                        );
                        return redirect()
                            ->back()
                            ->withInput();
                    }
                } else {
                    session()->setFlashdata("fail", "Something went wrong.");
                    return redirect()
                        ->back()
                        ->withInput();
                }
                }
            }elseif ($status == "rejected")
            {
                session()->setFlashdata("fail", "Sorry you cannot cancel rejected appointment.");
                    return redirect()
                        ->back()
                        ->withInput();
            }elseif($status=="cancel")
            {
                session()->setFlashdata("fail", "Sorry the appointment already cancel.");
                    return redirect()
                        ->back()
                        ->withInput();
            }
        }
    }
    public function viewAppointment()
    {
        $userInfo = session()->get("loggedUser");
        $limit = !empty(session()->get("records-limit"))
            ? session()->get("records-limit")
            : 5;

        $type = !empty(session()->get("typeFilter"))
            ? session()->get("typeFilter")
            : "Any";

        $allRecords = AppointmentLib::countRecords(
            "appointment",
            "user",
            $userInfo["email"]
        );
        // Calculate total pages
        $totoalPages = ceil($allRecords / $limit);

        // Current pagination page number
        $page =
            isset($_GET["page"]) && is_numeric($_GET["page"])
                ? $_GET["page"]
                : 1;
        //print_r($allRecords);
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
    //print_r($paginationStart);    
      //  print_r($end);    

        // Prev + Next
        $prev = $page - 1;
        $next = $page + 1;
        $record = AppointmentLib::paginationRecord(
                "appointment",
                $paginationStart,
                $end,
                "user",
                $userInfo["email"]
            );
        //print_r(
       //   
        //    $record
       // );
        
        $data = [
            "userInfo" => $userInfo,
            "pageTitle" => "View Appointment",
            "appointmentData" => $record,
            "limit" => $limit,
            "allRecords" => $allRecords,
            "totoalPages" => $totoalPages,
            "page" => $page,
            "paginationStart" => $paginationStart,
            "prev" => $prev,
            "next" => $next,
        ];

        return view("patientDashboard/viewAppointment", $data);
    }
    public function appointment()
    {
        $userInfo = session()->get("loggedUser");
        $data = [
            "userInfo" => $userInfo,
            "pageTitle" => "Appointment",
        ];

        return view("patientDashboard/appointment", $data);
    }
    public function __construct()
    {
        helper(["url", "form"]);
    }
    public function makeAppointment()
    {
        $userInfo = session()->get("loggedUser");
        $data = [
            "userInfo" => $userInfo,
            "pageTitle" => "Appointment",
        ];
        $isForSelf = $this->request->getPost("who");
        $mode = $this->request->getPost("mode");
        $isallergies = $this->request->getPost("allergies");
        $date = $this->request->getPost("appdate");
        $time = $this->request->getPost("apptime");
        //$mode=$this->request->getPost('mode');
        $services = $this->request->getPost("services");
        $reason = $this->request->getPost("reason");

        //this is for self appointment and walk in
        if ($isForSelf == "My Self" && $mode == "Walk In") {
            $validation = $this->validate([
                "appdate" => [
                    "rules" =>
                        "required|checkAppDate[appdate]|checkAppDateHoliday[appdate]",
                    "errors" => [
                        "required" => "Date is required",
                        "checkAppDate" => "Please select a valid date",
                        "checkAppDateHoliday" =>
                            "Sorry, we do not open on that day.",
                    ],
                ],
                "apptime" => [
                    "rules" => "required|checkAppTime[apptime]",
                    "errors" => [
                        "required" => "Time is required",
                        "checkAppTime" =>
                            "Invalid time only available 9am-11pm",
                    ],
                ],
                "services" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Service Type is required",
                    ],
                ],
                "reason" => [
                    "rules" =>
                        "required|checkHomeAddress[reason]|max_length[100]|min_length[10]",
                    "errors" => [
                        "required" =>
                            "Please provide some reason for the appointment.",
                        "checkHomeAddress" =>
                            "Text area only accept comman and dot.",
                        "min_length" =>
                            "Please provide more details about the reason",
                    ],
                ],
            ]);
            $istrue = $this->checkBookingTime($time, $date);

            if (!$validation || $istrue == false) {
                session()->setFlashdata(
                    "appdateError",
                    display_error($this->validator, "appdate")
                );
                session()->setFlashdata(
                    "apptimeError",
                    display_error($this->validator, "apptime")
                );
                session()->setFlashdata(
                    "servicesError",
                    display_error($this->validator, "services")
                );
                session()->setFlashdata(
                    "reasonError",
                    display_error($this->validator, "reason")
                );
                if ($istrue == false) {
                    session()->setFlashdata(
                        "apptimeError",
                        "Please make an appointment 30 minutes in advance"
                    );
                }
                return redirect()
                    ->back()
                    ->withInput();
            } else {
                $isOverLimit = AppointmentLib::checkAppointmentTimes(
                    $userInfo["email"]
                );
                // only 2 times for pending appointment
                if ($isOverLimit == false) {
                    return redirect()
                        ->back()
                        ->with(
                            "fail",
                            "You have more than two appointments and are pending, please try next time thanks."
                        );
                } else {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $requestDate = date("Y-m-d h:i:s");
                    //values of user to array
                    $appointmentData = [
                        "allergies" => $isallergies,
                        "who" => $isForSelf,
                        "date" => $date,
                        "time" => $time,
                        "mode" => $mode,
                        "service" => $services,
                        "reason" => $reason,
                        "status" => "pending",
                        "user" => $userInfo["email"],
                        "ic" => $userInfo["ic"],
                        "createdDatenTime" => $requestDate,
                    ];

                    $ref_table = "appointment";
                    //get connection to firebase
                    $database = FirebaseCon::getCon();
                    $postRef_result = $database
                        ->getReference($ref_table)
                        ->push($appointmentData);
                    //check insert success or not
                    if (!$postRef_result) {
                        return redirect()
                            ->back()
                            ->with("fail", "Something went wrong");
                    } else {
                        return redirect()
                            ->back()
                            ->with(
                                "success",
                                "Appointment registered successfully, please wait for us to approval."
                            );
                    }
                    //check how many appoint for today only 2 by checking the status peding
                }
            }
        }
        //this is for register for others appointment and walk in
        if ($isForSelf == "Others" && $mode == "Walk In") {
            //$isallergies=$this->request->getPost('allergies');
            //$date=$this->request->getPost('appdate');
            //$time=$this->request->getPost('apptime');
            //$mode=$this->request->getPost('mode');
            //$services=$this->request->getPost('services');
            //$reason=$this->request->getPost('reason');
            $name = $this->request->getPost("name");
            $ic = $this->request->getPost("ic");
            $contact = $this->request->getPost("contact");
            $address = $this->request->getPost("address");
            $postcode = $this->request->getPost("postcode");

            $validation = $this->validate([
                "appdate" => [
                    "rules" =>
                        "required|checkAppDate[appdate]|checkAppDateHoliday[appdate]",
                    "errors" => [
                        "required" => "Date is required",
                        "checkAppDate" => "Please select a valid date",
                        "checkAppDateHoliday" =>
                            "Sorry, we do not open on that day.",
                    ],
                ],
                "apptime" => [
                    "rules" => "required|checkAppTime[apptime]",
                    "errors" => [
                        "required" => "Time is required",
                        "checkAppTime" =>
                            "Invalid time only available 9am-11pm",
                    ],
                ],
                "services" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Service Type is required",
                    ],
                ],
                "reason" => [
                    "rules" =>
                        "required|checkHomeAddress[reason]|max_length[100]|min_length[10]",
                    "errors" => [
                        "required" =>
                            "Please provide some reason for the appointment.",
                        "checkHomeAddress" =>
                            "Text area only accept comman and dot.",
                        "min_length" =>
                            "Please provide more details about the reason",
                    ],
                ],
                "name" => [
                    "rules" =>
                        "required|max_length[50]|min_length[8]|alpha_space",
                    "errors" => [
                        "required" => "Please enter your full name",
                        "max_length" => "Maximum 50 characters only",
                        "min_length" => "Minimum 8 characters at least",
                    ],
                ],
                "contact" => [
                    "rules" => "required|max_length[11]|checkContact",
                    "errors" => [
                        "required" => "Contact number is required",
                        "max_length" => "Invalid contact number",
                        "checkContact" => "Invalid contact number",
                    ],
                ],
                "postcode" => [
                    "rules" =>
                        "required|max_length[5]|min_length[5]|checkPostcode[postcode]",
                    "errors" => [
                        "required" => "Postcode  is required",
                        "matches" => "Passwords do not match",
                        "max_length" => "Invalid postcode",
                        "min_length" => "Invalid postcode",
                        "checkPostcode" => "Invalid postcode",
                    ],
                ],
                "address" => [
                    "rules" =>
                        "required|max_length[100]|min_length[10]|checkHomeAddress[address]",
                    "errors" => [
                        "required" => "Address  is required",
                        "max_length" => "Maximum 100 characters only",
                        "min_length" => "Provide more details about address",
                        "checkHomeAddress" =>
                            "Invalid address can only contain comman, whitespace, number, letter only",
                    ],
                ],
                "ic" => [
                    "rules" =>
                        "checkIC[ic]|max_length[12]|min_length[12]|required",
                    "errors" => [
                        "required" => "Identity Number is required",
                        "checkIC" => "Invalid IC Number",
                        "max_length" => "Invalid IC Number",
                        "min_length" => "Invalid IC Number",
                    ],
                ],
            ]);
            $istrue = $this->checkBookingTime($time, $date);

            if (!$validation) {
                session()->setFlashdata(
                    "nameError",
                    display_error($this->validator, "name")
                );
                session()->setFlashdata(
                    "addressError",
                    display_error($this->validator, "address")
                );
                session()->setFlashdata(
                    "icError",
                    display_error($this->validator, "ic")
                );
                session()->setFlashdata(
                    "contactError",
                    display_error($this->validator, "contact")
                );
                session()->setFlashdata(
                    "postcodeError",
                    display_error($this->validator, "postcode")
                );

                session()->setFlashdata(
                    "appdateError",
                    display_error($this->validator, "appdate")
                );
                session()->setFlashdata(
                    "apptimeError",
                    display_error($this->validator, "apptime")
                );
                session()->setFlashdata(
                    "servicesError",
                    display_error($this->validator, "services")
                );
                session()->setFlashdata(
                    "reasonError",
                    display_error($this->validator, "reason")
                );
                session()->setFlashdata("otherForm", "otherForm");
                if ($istrue == false) {
                    session()->setFlashdata(
                        "apptimeError",
                        "Please make an appointment 30 minutes in advance"
                    );
                }
                return redirect()
                    ->back()
                    ->withInput();
            } else {
                $isOverLimit = AppointmentLib::checkAppointmentTimes(
                    $userInfo["email"]
                );
                // only 2 times for pending appointment
                if ($isOverLimit == false) {
                    return redirect()
                        ->back()
                        ->with(
                            "fail",
                            "You have more than two appointments and are pending, please try next time thanks."
                        );
                } else {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $requestDate = date("Y-m-d h:i:s");
                    //values of user to array
                    $appointmentData = [
                        "allergies" => $isallergies,
                        "who" => $isForSelf,
                        "date" => $date,
                        "time" => $time,
                        "mode" => $mode,
                        "service" => $services,
                        "reason" => $reason,
                        "status" => "pending",
                        "user" => $userInfo["email"],
                        "createdDatenTime" => $requestDate,
                        "name" => $name,
                        "ic" => $ic,
                        "contact" => $contact,
                        "postcode" => $postcode,
                    ];

                    $ref_table = "appointment";
                    //get connection to firebase
                    $database = FirebaseCon::getCon();
                    $postRef_result = $database
                        ->getReference($ref_table)
                        ->push($appointmentData);
                    //check insert success or not
                    if (!$postRef_result) {
                        return redirect()
                            ->back()
                            ->with("fail", "Something went wrong");
                    } else {
                        return redirect()
                            ->back()
                            ->with(
                                "success",
                                "Appointment registered successfully, please wait for us to approval."
                            );
                    }
                    //check how many appoint for today only 2 by checking the status peding
                }
            }
        }
        //this is for register for others appointment and walk in
        if ($isForSelf == "Others" && $mode == "E-Consult") {
            //$isallergies=$this->request->getPost('allergies');
            //$date=$this->request->getPost('appdate');
            //$time=$this->request->getPost('apptime');
            //$mode=$this->request->getPost('mode');
            //$services=$this->request->getPost('services');
            //$reason=$this->request->getPost('reason');
            $name = $this->request->getPost("name");
            $ic = $this->request->getPost("ic");
            $contact = $this->request->getPost("contact");
            $address = $this->request->getPost("address");
            $postcode = $this->request->getPost("postcode");

            $validation = $this->validate([
                "appdate" => [
                    "rules" =>
                        "required|checkAppDate[appdate]|checkAppDateHoliday[appdate]",
                    "errors" => [
                        "required" => "Date is required",
                        "checkAppDate" => "Please select a valid date",
                        "checkAppDateHoliday" =>
                            "Sorry, we do not open on that day.",
                    ],
                ],
                "apptime" => [
                    "rules" => "required|checkAppTime[apptime]",
                    "errors" => [
                        "required" => "Time is required",
                        "checkAppTime" =>
                            "Invalid time only available 9am-11pm",
                    ],
                ],
                "reason" => [
                    "rules" =>
                        "required|checkHomeAddress[reason]|max_length[100]|min_length[10]",
                    "errors" => [
                        "required" =>
                            "Please provide some reason for the appointment.",
                        "checkHomeAddress" =>
                            "Text area only accept comman and dot.",
                        "min_length" =>
                            "Please provide more details about the reason",
                    ],
                ],
                "name" => [
                    "rules" =>
                        "required|max_length[50]|min_length[8]|alpha_space",
                    "errors" => [
                        "required" => "Please enter your full name",
                        "max_length" => "Maximum 50 characters only",
                        "min_length" => "Minimum 8 characters at least",
                    ],
                ],
                "contact" => [
                    "rules" => "required|max_length[11]|checkContact",
                    "errors" => [
                        "required" => "Contact number is required",
                        "max_length" => "Invalid contact number",
                        "checkContact" => "Invalid contact number",
                    ],
                ],
                "postcode" => [
                    "rules" =>
                        "required|max_length[5]|min_length[5]|checkPostcode[postcode]",
                    "errors" => [
                        "required" => "Postcode  is required",
                        "matches" => "Passwords do not match",
                        "max_length" => "Invalid postcode",
                        "min_length" => "Invalid postcode",
                        "checkPostcode" => "Invalid postcode",
                    ],
                ],
                "address" => [
                    "rules" =>
                        "required|max_length[100]|min_length[10]|checkHomeAddress[address]",
                    "errors" => [
                        "required" => "Address  is required",
                        "max_length" => "Maximum 100 characters only",
                        "min_length" => "Provide more details about address",
                        "checkHomeAddress" =>
                            "Invalid address can only contain comman, whitespace, number, letter only",
                    ],
                ],
                "ic" => [
                    "rules" =>
                        "checkIC[ic]|max_length[12]|min_length[12]|required",
                    "errors" => [
                        "required" => "Identity Number is required",
                        "checkIC" => "Invalid IC Number",
                        "max_length" => "Invalid IC Number",
                        "min_length" => "Invalid IC Number",
                    ],
                ],
            ]);
            $istrue = $this->checkBookingTime($time, $date);

            if (!$validation) {
                session()->setFlashdata(
                    "nameError",
                    display_error($this->validator, "name")
                );
                session()->setFlashdata(
                    "addressError",
                    display_error($this->validator, "address")
                );
                session()->setFlashdata(
                    "icError",
                    display_error($this->validator, "ic")
                );
                session()->setFlashdata(
                    "contactError",
                    display_error($this->validator, "contact")
                );
                session()->setFlashdata(
                    "postcodeError",
                    display_error($this->validator, "postcode")
                );

                session()->setFlashdata(
                    "appdateError",
                    display_error($this->validator, "appdate")
                );
                session()->setFlashdata(
                    "apptimeError",
                    display_error($this->validator, "apptime")
                );
                session()->setFlashdata(
                    "servicesError",
                    display_error($this->validator, "services")
                );
                session()->setFlashdata(
                    "reasonError",
                    display_error($this->validator, "reason")
                );
                session()->setFlashdata("otherForm", "otherForm");
                if ($istrue == false) {
                    session()->setFlashdata(
                        "apptimeError",
                        "Please make an appointment 30 minutes in advance"
                    );
                }
                return redirect()
                    ->back()
                    ->withInput();
            } else {
                $isOverLimit = AppointmentLib::checkAppointmentTimes(
                    $userInfo["email"]
                );
                // only 2 times for pending appointment
                if ($isOverLimit == false) {
                    return redirect()
                        ->back()
                        ->with(
                            "fail",
                            "You have more than two appointments and are pending, please try next time thanks."
                        );
                } else {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $requestDate = date("Y-m-d h:i:s");
                    //values of user to array
                    $appointmentData = [
                        "allergies" => $isallergies,
                        "who" => $isForSelf,
                        "date" => $date,
                        "time" => $time,
                        "mode" => $mode,
                        "service" => "Online Consultation",
                        "reason" => $reason,
                        "status" => "pending",
                        "user" => $userInfo["email"],
                        "createdDatenTime" => $requestDate,
                        "name" => $name,
                        "ic" => $ic,
                        "contact" => $contact,
                        "postcode" => $postcode,
                    ];

                    $ref_table = "appointment";
                    //get connection to firebase
                    $database = FirebaseCon::getCon();
                    $postRef_result = $database
                        ->getReference($ref_table)
                        ->push($appointmentData);
                    //check insert success or not
                    if (!$postRef_result) {
                        return redirect()
                            ->back()
                            ->with("fail", "Something went wrong");
                    } else {
                        return redirect()
                            ->back()
                            ->with(
                                "success",
                                "Appointment registered successfully, please wait for us to approval."
                            );
                    }
                    //check how many appoint for today only 2 by checking the status peding
                }
            }
        }
        //this is for self appointment and e-consult
        if ($isForSelf == "My Self" && $mode == "E-Consult") {
            $isallergies = $this->request->getPost("allergies");
            $date = $this->request->getPost("appdate");
            $time = $this->request->getPost("apptime");
            $mode = $this->request->getPost("mode");
            $reason = $this->request->getPost("reason");

            $validation = $this->validate([
                "appdate" => [
                    "rules" =>
                        "required|checkAppDate[appdate]|checkAppDateHoliday[appdate]",
                    "errors" => [
                        "required" => "Date is required",
                        "checkAppDate" => "Please select a valid date",
                        "checkAppDateHoliday" =>
                            "Sorry, we do not open on that day.",
                    ],
                ],
                "apptime" => [
                    "rules" => "required|checkAppTime[apptime]",
                    "errors" => [
                        "required" => "Time is required",
                        "checkAppTime" =>
                            "Invalid time only available 9am-11pm",
                    ],
                ],
                "reason" => [
                    "rules" =>
                        "required|checkHomeAddress[reason]|max_length[100]|min_length[10]",
                    "errors" => [
                        "required" =>
                            "Please provide some reason for the appointment.",
                        "checkHomeAddress" =>
                            "Text area only accept comman and dot.",
                        "min_length" =>
                            "Please provide more details about the reason",
                    ],
                ],
            ]);
            $istrue = $this->checkBookingTime($time, $date);

            if (!$validation) {
                session()->setFlashdata(
                    "appdateError",
                    display_error($this->validator, "appdate")
                );
                session()->setFlashdata(
                    "apptimeError",
                    display_error($this->validator, "apptime")
                );
                //session()->setFlashdata('servicesError',display_error($this->validator,'services'));
                session()->setFlashdata(
                    "reasonError",
                    display_error($this->validator, "reason")
                );
                if ($istrue == false) {
                    session()->setFlashdata(
                        "apptimeError",
                        "Please make an appointment 30 minutes in advance"
                    );
                }
                //session()->setFlashdata('siteError',display_error($this->validator,'site'));
                //session()->setFlashdata('showAddress','showAddress');

                return redirect()
                    ->back()
                    ->withInput();
            } else {
                $isOverLimit = AppointmentLib::checkAppointmentTimes(
                    $userInfo["email"]
                );
                // only 2 times for pending appointment
                if ($isOverLimit == false) {
                    return redirect()
                        ->back()
                        ->with(
                            "fail",
                            "You have more than two appointments and are pending, please try next time thanks."
                        );
                } else {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $requestDate = date("Y-m-d h:i:s");
                    //values of user to array
                    $appointmentData = [
                        "allergies" => $isallergies,
                        "who" => $isForSelf,
                        "date" => $date,
                        "time" => $time,
                        "mode" => $mode,
                        "service" => "Online Consultation",
                        "reason" => $reason,
                        "status" => "pending",
                        "user" => $userInfo["email"],
                        "ic" => $userInfo["ic"],
                        "createdDatenTime" => $requestDate,
                    ];

                    $ref_table = "appointment";
                    //get connection to firebase
                    $database = FirebaseCon::getCon();
                    $postRef_result = $database
                        ->getReference($ref_table)
                        ->push($appointmentData);
                    //check insert success or not
                    if (!$postRef_result) {
                        return redirect()
                            ->back()
                            ->with("fail", "Something went wrong");
                    } else {
                        return redirect()
                            ->back()
                            ->with(
                                "success",
                                "Appointment registered successfully, please wait for us to approval."
                            );
                    }
                    //check how many appoint for today only 2 by checking the status peding
                }
            }
        }
        echo $isForSelf;
        echo $isallergies;
        echo $services;
        echo $mode;
        echo $ic;

        //return view("errors/error_500", $data);
        // return view('patientDashboard/appointment',$data);
    }
}
