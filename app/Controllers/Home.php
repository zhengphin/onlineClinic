<?php

namespace App\Controllers;
use App\Libraries\FirebaseCon;
use App\Libraries\EventLib;

class Home extends BaseController
{
    public function index()
    {
        return view('home/home');
    }
    public function aboutUs()
    {
        return view('home/aboutUs');
    }
    public function services()
    {
        return view('home/services');
    }
    public function location()
    {
        return view('home/location');
    }
    public function newsEvent()
    {
         //get connection to firebase
         //$database=FirebaseCon::getCon();
                    
        //$fetch_data=$database->getReference('event')->getValue();

        $record=EventLib::getEvent();
        $expdate = array_column($record, 'expiryDate');
        array_multisort($expdate, SORT_ASC, $record);
        $data = [
            "record" => $record,
        ];

        return view('home/newsEvent',$data);
    }
    public function __construct(){
        helper(['url','form']);

    }
}
