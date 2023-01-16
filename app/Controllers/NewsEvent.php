<?php

namespace App\Controllers;
use App\Libraries\PatientLib;
use App\Libraries\FirebaseCon;
use App\Libraries\LabLib;
use App\Libraries\EventLib;
use App\Libraries\AdminLib;

class NewsEvent extends BaseController
{
    public function uploadImageEvent()
    {
       
        if($this->request->getMethod()=='post')
        {
            $key=$this->request->getPost('key');
            $eventData=EventLib::readDataByKeySpecify($key);
            $userInfo=session()->get('staffloggedUser');
            $data=[
             'userInfo'=>$userInfo,
             'eventData'=>$eventData[1],
             'eventkey'=>$key,
             'pageTitle'=>'Upate Event'
            ];
            $rules=[
                'image'=>[
                    'rules'=>'uploaded[image]|max_size[image,4000]|is_image[image]',
                    'label'=>'image',
                    'errors'=>[
                        'uploaded'=>'Image uploaded file is required',  
                        'max_size'=>'Image file cannot over 4mb',
                        'is_image'=>'Uploaded file is not a valid, please upload image file',
                        //'ext_in'=>'The file does not have a valid file extension, only accept png,jpeg,jpg'
                        ]
                ]
            ];
        }
        if($this->validate($rules))
        {
     
           $file=$this->request->getFile('image');
         
           if($file->isValid()){   
            session()->setFlashdata('processing','update pdf');
            $newName = $file->getRandomName(); //This is if you want to change the file name to encrypted name
            $file->move(ROOTPATH . 'public/images/event', $newName);
            $directory = ROOTPATH."'public/images/event/$newName'";
           // print_r($_FILES['labReport']['name']);
           session()->setFlashdata('dir',$newName);
           session()->setFlashdata('eventkey',$key);

           // return redirect()->to('staff/profile')->withInput($data);
           return view('staff/eventUpdate',$data);

           }
        }else{
            session()->setFlashdata('failUploadReport',display_error($this->validator,'image'));
            return view('staff/eventUpdate',$data);

        }
    }
    public function update()
    {
        if ($this->request->getMethod() == "post") {
            $key=$this->request->getPost('key');
                $validation = $this->validate([
                    "name" => [
                        "rules" => "required|max_length[100]|min_length[2]",
                        "errors" => [
                            "required" => "Please enter your event name",
                            "max_length" => "Maximum 50 characters only",
                            "min_length" => "Minimum 8 characters at least",
                        ],
                    ],
                    "description" => [
                        "rules" => "required|max_length[255]|min_length[30]",
                        "errors" => [
                            "required" => "Description is required",
                            "max_length" => "Maximum 100 characters only",
                            "min_length" => "Provide more details",
                        ],
                    ],
                ]);
                if (!$validation) {
                    $userInfo = session()->get("staffloggedUser");

                    $data = [
                        "userInfo" => $userInfo,
                        "validation" => $this->validator,
                        "pageTitle" => "Post New Event",
                    ];
                    return view("staff/eventUpdate", $data);
                } else {
                    $name = $this->request->getPost("name");
                    $description = $this->request->getPost("description");
                    $Validity = $this->request->getPost("Validity");
                    //get malaysia create date
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $CreateDate = date("Y-m-d");
                    $eventData = [
                        "title" => strtoupper($name),
                        "desc" => $description,
                        "validity" => $Validity,
                        "expiryDate" => date(
                            "Y-m-d",
                            strtotime($CreateDate . " +" . $Validity . "days")
                        ),
                    ];
                    $ref_table = "event";
                    //get connection to firebase
                    $database = FirebaseCon::getCon();
                    $postRef_result = $database
                        ->getReference("event/".$key)
                        ->update($eventData);
                    //check insert success or not
                    if (!$postRef_result) {
                        return redirect()
                            ->to("staff/eventManage")
                            ->with("failevup", "Something went wrong");
                    } else {
                        return redirect()
                            ->to("staff/eventManage")
                            ->with(
                                "successevup",
                                "Event Updated Successfully."
                            );
                    }
                
            
            }
        } else {
            "didnot posted";
        
        }
    }
    public function handleAjaxRequestEventUpdate()
    {
        $data=$this->request->getVar();
         $imgurl=$this->request->getVar('name');
         $key=$this->request->getVar('key');
         //$checkUpdate=StaffLib::updatedProfileImg($key,$imgurl);
         $eventData = [
            "image"=>$imgurl
        ];
        $database = FirebaseCon::getCon();
        $postRef_result = $database
            ->getReference("event/".$key)
            ->update($eventData);
        session()->setFlashdata('processing','');

         echo json_encode(array(
             "status"=>1,
             "message"=>"Successful request",
             "data"=>$data
         ));
    }
    public function updateEvent()
    {
        if ($this->request->getMethod() == "post") {
            $userInfo = session()->get("staffloggedUser");
            $key=$this->request->getPost("id");
            $eventData=EventLib::readDataByKeySpecify($key);

            $data = [
                "userInfo" => $userInfo,
                "pageTitle" => "Update Event",
                "eventkey"=>$key,
                "eventData"=>$eventData[1],
            ];
            return view("staff/eventUpdate", $data);

        }


        
    }
    public function eventDelete()
    {
        if ($this->request->getMethod() == "post") {
            $id=$this->request->getPost("delete_id");
           // echo $id;
           $database = FirebaseCon::getCon();
           $postRef_result = $database
            ->getReference('event/'.$id)
            ->remove();
            if($postRef_result)
            {
                return redirect()
                ->back()
                ->with("successev", "Item delete successfully.");
            }
            else{
                return redirect()
                ->back()
                ->with("failev", "Item delete failed.");
            }
        }
        else{
            echo "something wrong.";
        }
    }
    public function eventManage()
    {
        $userInfo = session()->get("staffloggedUser");

    
        // Dynamic limit
        $limit = 20;
        // Get total records
        $allRecords = AdminLib::countRecords('event');
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
        $record = AdminLib::paginationRecord('event', $paginationStart, $end);
        $data = [
            "userInfo" => $userInfo,
            "eventData" => $record,
            'limit' => $limit,
            'allRecords' => $allRecords,
            'totoalPages' => $totoalPages,
            'page' => $page,
            'paginationStart' => $paginationStart,
            'prev' => $prev,
            'next' => $next,
            "pageTitle" => "Event Management",
        ];
        return view("staff/eventManage", $data);
    }
    public function handleAjaxRequestEvent()
    {
         $data=$this->request->getVar();
         $imgurl=$this->request->getVar('name');
         $key=$this->request->getVar('key');
         //$checkUpdate=StaffLib::updatedProfileImg($key,$imgurl);
         $eventData = [
            "image"=>$imgurl
        ];
        $database = FirebaseCon::getCon();
        $postRef_result = $database
            ->getReference("event/".$key)
            ->update($eventData);
    
         echo json_encode(array(
             "status"=>1,
             "message"=>"Successful request",
             "data"=>$data
         ));
    }
    private function insert()
    {
        $eventData = [
            "haha"=>"lolo"
        ];
        $key=122121;
        $database = FirebaseCon::getCon();
        $postRef_result = $database
            ->getReference("mock/".$key)
            ->push($eventData);
    }
    private function gogo()
    {
        echo $this->generateRandomString();

    }
   private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function testing()
    {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $CreateDate = date("Y-m-d");

        $vali = 10;
        echo date("Y-m-d", strtotime($CreateDate . " +" . $vali . "days"));

        $today = date_create($today);
        $expiry = date_create($expiredDate);
        $diff = date_diff($today, $expiry);
        echo $diff->format("%R%a days");
    }
    public function saveEvent()
    {
        if ($this->request->getMethod() == "post") {
            if (empty($_FILES)) {
                $validation = $this->validate([
                    "name" => [
                        "rules" => "required|max_length[100]|min_length[2]",
                        "errors" => [
                            "required" => "Please enter your event name",
                            "max_length" => "Maximum 50 characters only",
                            "min_length" => "Minimum 8 characters at least",
                        ],
                    ],
                    "description" => [
                        "rules" => "required|max_length[255]|min_length[30]",
                        "errors" => [
                            "required" => "Description is required",
                            "max_length" => "Maximum 100 characters only",
                            "min_length" => "Provide more details",
                        ],
                    ],
                ]);
                if (!$validation) {
                    $userInfo = session()->get("staffloggedUser");

                    $data = [
                        "userInfo" => $userInfo,
                        "validation" => $this->validator,
                        "pageTitle" => "Post New Event",
                    ];
                    return view("staff/addEvent", $data);
                } else {
                    $name = $this->request->getPost("name");
                    $description = $this->request->getPost("description");
                    $Validity = $this->request->getPost("Validity");
                    //get malaysia create date
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $CreateDate = date("Y-m-d");
                    $eventData = [
                        "title" => strtoupper($name),
                        "desc" => $description,
                        "validity" => $Validity,
                        "image" => "",
                        "createdDate" => $CreateDate,
                        "expiryDate" => date(
                            "Y-m-d",
                            strtotime($CreateDate . " +" . $Validity . "days")
                        ),
                    ];
                    $ref_table = "event";
                    //get connection to firebase
                    $database = FirebaseCon::getCon();
                    $postRef_result = $database
                        ->getReference($ref_table)
                        ->push($eventData);
                    //check insert success or not
                    if (!$postRef_result) {
                        return redirect()
                            ->to("staff/postEvent")
                            ->with("failEvent", "Something went wrong");
                    } else {
                        return redirect()
                            ->to("staff/postEvent")
                            ->with(
                                "successEvent",
                                "Event Posted Successfully."
                            );
                    }
                }
            }elseif(!empty($_FILES))
            {
                $validation = $this->validate([
                    "name" => [
                        "rules" => "required|max_length[100]|min_length[2]",
                        "errors" => [
                            "required" => "Please enter your event name",
                            "max_length" => "Maximum 50 characters only",
                            "min_length" => "Minimum 8 characters at least",
                        ],
                    ],
                    "description" => [
                        "rules" => "required|max_length[255]|min_length[30]",
                        "errors" => [
                            "required" => "Description is required",
                            "max_length" => "Maximum 100 characters only",
                            "min_length" => "Provide more details",
                        ],
                    ],
                    'image'=>[
                        'rules'=>'uploaded[image]|max_size[image,4000]|is_image[image]',
                        'label'=>'image',
                        'errors'=>[
                            'uploaded'=>'Image uploaded file is required',  
                            'max_size'=>'Image file cannot over 4mb',
                            'is_image'=>'Uploaded file is not a valid, please upload image file',
                            //'ext_in'=>'The file does not have a valid file extension, only accept png,jpeg,jpg'
                            ]
                    ]
                
                ]);
                if (!$validation) {
                    $userInfo = session()->get("staffloggedUser");

                    $data = [
                        "userInfo" => $userInfo,
                        "validation" => $this->validator,
                        "pageTitle" => "Post New Event",
                    ];
                    return view("staff/addEvent", $data);
                } else {
                    $userInfo = session()->get("staffloggedUser");

                    $data = [
                        "userInfo" => $userInfo,
                        "pageTitle" => "Post New Event"
                    ];
                    $file=$this->request->getFile('image');
                    if($file->isValid()){   
                        $name = $this->request->getPost("name");
                        $description = $this->request->getPost("description");
                        $Validity = $this->request->getPost("Validity");
                        //get malaysia create date
                        date_default_timezone_set("Asia/Kuala_Lumpur");
                        $CreateDate = date("Y-m-d");
                        $eventData = [
                            "title" => strtoupper($name),
                            "desc" => $description,
                            "validity" => $Validity,
                            "image" => "",
                            "createdDate" => $CreateDate,
                            "expiryDate" => date(
                                "Y-m-d",
                                strtotime($CreateDate . " +" . $Validity . "days")
                            ),
                        ];
                        $key=$this->generateRandomString();
                        $database = FirebaseCon::getCon();
                        $postRef_result = $database
                            ->getReference("event/$key")
                            ->update($eventData);
                        //check insert success or not
                        if (!$postRef_result) {
                            return redirect()
                                ->to("staff/postEvent")
                                ->with("failEvent", "Something went wrong");
                        } else {
                            session()->setFlashdata('processing','update image');
                            $newName = $file->getRandomName(); //This is if you want to change the file name to encrypted name
                            $file->move(ROOTPATH . 'public/images/event', $newName);
                            $directory = ROOTPATH."'public/images/event/$newName'";
                            session()->setFlashdata('dir',$newName);
                            session()->setFlashdata('eventKey',$key);

                            return redirect()->to('staff/postEvent')->withInput($data);
                        }
                   
                       }
                    else{
                        session()->setFlashdata('failEvent',display_error($this->validator,'image'));
                        return redirect()->to('staff/postEvent')->withInput($data);
                    }
                }
            }
        } else {
            "didnot posted";
        }
    }
    public function __construct()
    {
        helper(["url", "form"]);
    }
    public function postEvent()
    {
        //page

        $userInfo = session()->get("staffloggedUser");
        $data = [
            "userInfo" => $userInfo,
            "pageTitle" => "Post New Event",
        ];

        return view("staff/addEvent", $data);
    }
}
