<?php

namespace App\Controllers;
use App\Libraries\PatientLib;
use App\Libraries\FirebaseCon;
use App\Libraries\LabLib;
use App\Libraries\AppointmentLib;
use App\Libraries\User;
use App\Libraries\PaymentLib;

class PatientLab extends BaseController
{
  public function lab()
  {
    $userInfo=session()->get('loggedUser');
    $user_info=User::getUserInfoByEmail($userInfo['email']);
       
    ////////////////////////////////////////////
    $limit = !empty(session()->get("records-limit"))
            ? session()->get("records-limit")
            : 10;

    $type = !empty(session()->get("typeFilter"))
            ? session()->get("typeFilter")
            : "Any";

    $patientKey=PatientLib::readPatientKeyByIC($user_info['ic']);
    $allRecords = AppointmentLib::countRecords(
        "lab",
        "patientkey",
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

       $record = LabLib::readData(
        $patientKey,
        $paginationStart,
        $end
    );
    $data=[
        'userInfo'=>$user_info,
        'pageTitle'=>'Laboratory Report page',
        "labData" => $record,
        "limit" => $limit,
        "allRecords" => $allRecords,
        "totoalPages" => $totoalPages,
        "page" => $page,
        "paginationStart" => $paginationStart,
        "prev" => $prev,
        "next" => $next,
       ];

    return view('patientDashboard/patientLab',$data);
    }
  
   public function __construct(){
        helper(['url','form']);

    }
}
