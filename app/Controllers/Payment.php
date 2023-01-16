<?php

namespace App\Controllers;
use App\Libraries\myic;
use App\Libraries\Hash;
use App\Libraries\FirebaseCon;
use App\Libraries\PaymentLib;
use App\Libraries\AppointmentLib;
use App\Libraries\zoomLib;


use App\Libraries\User;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Exception\FirebaseException;
class Payment extends BaseController
{
    public function testmeet(){
        $length = 5;

        $randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890"), 0, $length);

        echo $randomletter;
    }
    public function processPayment(){
       //appointment id
       //check balance
       //validate account
       //session
       //change status to paid
       session()->set('paymentSession','paymentSession');
       if ($this->request->getMethod() == "post") {
        $id=$this->request->getPost("paymentid");
        $holdername = $this->request->getPost("holdername");
        $cardnumber = $this->request->getPost("cardnumber");
        $exp = $this->request->getPost("exp");
        $cvv = $this->request->getPost("cvv");
        //echo $holdername,$cardnumber,$exp,$cvv;
        $isExists=PaymentLib::checkAccountExists($holdername,$cardnumber,$cvv,$exp);
        if($isExists==false)
        {
            //failed
            session()->remove('paymentSession','paymentSession');
            //setflash and return to view
            session()->setFlashdata(
                "fail",
                "Credential information failed please try again."
            );
            return redirect()
                            ->back()
                            ->withInput();
        }
        else{
            $isBalance=PaymentLib::checkBalance($holdername,$cardnumber,$cvv,$exp);
            if($isBalance==false)
            {
                session()->remove('paymentSession','paymentSession');
                //setflash and return to view
                session()->setFlashdata(
                    "fail",
                    "Please add funds to your bank account due to insufficient funds."
                );
                return redirect()
                                ->back()
                                ->withInput();
            }else if($isBalance==true)
            {
                $length = 5;

                $randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890"), 0, $length);
                $database = FirebaseCon::getCon();
                if (isset($database)) {
                    $updateAt = [
                        "payment" => "paid",
                        "room" => $randomletter,
                        "session" => "Not for the moment"

                    ];
                    $b=PaymentLib::getBalance($holdername,$cardnumber,$cvv,$exp);
                    $b=$b-40;
                    $updateBalance=[
                    "balance"=>$b
                    ];
                    $visaKey=PaymentLib::getKey($holdername,$cardnumber,$cvv,$exp);

                    $postRef_result2= $database
                    ->getReference("visa/" . $visaKey)
                    ->update($updateBalance);
                    //get connection to firebase
                    $postRef_result = $database
                        ->getReference("appointment/" . $id)
                        ->update($updateAt);
                    //check insert success or not
                    if (!$postRef_result) {
                        session()->setFlashdata(
                            "fail",
                            "Something went wrong please try again."
                        );
                        return redirect()
                                ->back()
                                ->withInput();
                    }else{
                        session()->setFlashdata(
                            "success",
                            "Payment successfully, as soon you will received a meeting room link."
                        );
                        return redirect()
                                ->back()
                                ->withInput();
                    }
            }
            }
        }
    }
       if(empty(session()->get('paymentSession')))
        {
            return redirect()
            ->back();
        }

    }
    public function __construct()
    {
        helper(["url", "form"]);
    }
    public function index()
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

    $allRecords = AppointmentLib::countRecordsPayment(
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

           $record = PaymentLib::readData(
            $userInfo["email"],
            $paginationStart,
            $end
        );
        $data=[
            'userInfo'=>$user_info,
            'pageTitle'=>'Payment',
            "appointmentData" => $record,
            "limit" => $limit,
            "allRecords" => $allRecords,
            "totoalPages" => $totoalPages,
            "page" => $page,
            "paginationStart" => $paginationStart,
            "prev" => $prev,
            "next" => $next,
           ];
        return view('patientDashboard/payment',$data);
    }
  
}
