<?php

namespace App\Controllers;
use App\Libraries\FirebaseCon;
use App\Libraries\QueueLib;
class Queuing extends BaseController
{
    public function __construct()
    {
        helper(["url", "form"]);
    }
    public function index()
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $TodayDate = date('Y-m-d');
        $waitingData=QueueLib::readDataWaiting($TodayDate);
        $progressData=QueueLib::readDataProgress($TodayDate);

        $data=[
            'waitingData'=>$waitingData,
            'progressData'=>$progressData,
          ];
        return view('counter/queue',$data);
    }
  
}
