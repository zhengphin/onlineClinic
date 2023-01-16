<?php

namespace App\Controllers;
use App\Libraries\ConsultLib;

class Consult extends BaseController
{
    public function lobby()
    {
        return view('patientDashboard/lobby');

    }
    public function meet()
    {
        if ($this->request->getMethod() == "post") {
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
                    return view('patientDashboard/meet',$data);

                }else{
                    echo "something went wrong";
                }
               }
            }else{
                return redirect()->to('Staff/consult')->with('fail','Something went wrong no room.');
    
            }
        }else{
            
        $userInfo=session()->get('loggedUser');

        if(isset($_GET['room']))
        {
            $room=$_GET['room'];
            //echo $room;
           $isRoom= ConsultLib::checkRoom($room,$userInfo['email']);
           $checkRoomSession= ConsultLib::checkRoomSession($room,$userInfo['email']);
           if($isRoom==false)
           {
            return redirect()->to('Consult')->with('fail','Invalid Room.');

           }elseif($checkRoomSession==false)
           {
            return redirect()->to('Consult')->with('fail','The consultation room is already completed.');

           }
           else{
            
            return view('patientDashboard/meet');
           }
        }else{
            return redirect()->to('Consult')->with('fail','Something went wrong no room.');

        }
    }
        
        //return view('patientDashboard/meet');

    }
    
    public function __construct()
    {
        helper(["url", "form"]);
    }
    public function index()
    {
        $userInfo=session()->get('loggedUser');

         ////////////////////////////////////////////
    $limit = !empty(session()->get("records-limit"))
    ? session()->get("records-limit")
    : 5;

$type = !empty(session()->get("typeFilter"))
    ? session()->get("typeFilter")
    : "Any";

$allRecords = ConsultLib::countRecords(
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

   $record = ConsultLib::readData(
    $userInfo["email"],
    $paginationStart,
    $end
);
        $userInfo=session()->get('loggedUser');
       
        $data=[
            'userInfo'=>$userInfo,
            'pageTitle'=>'Remote Consultation',
            "appointmentData" => $record,
            "limit" => $limit,
            "allRecords" => $allRecords,
            "totoalPages" => $totoalPages,
            "page" => $page,
            "paginationStart" => $paginationStart,
            "prev" => $prev,
            "next" => $next,
           ];
        return view('patientDashboard/consult',$data);
    }
 
}
