<?php
namespace App\Libraries;
require '../vendor/autoload.php';
require_once '../vendor/firebase/php-jwt/src/BeforeValidException.php';
require_once '../vendor/firebase/php-jwt/src/ExpiredException.php';
require_once '../vendor/firebase/php-jwt/src/SignatureInvalidException.php';
require_once '../vendor/firebase/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;

class zoomLib{
    private $zoom_api_key='ymexxnDEQDeqCjA6GwYYEQ';
    private $zoom_secret_key='fV544AHbZ0YJ2ORzrPuDnHgMadAVCHXXhCni';
    //function to get generate jwt
    public  function generateJWTKey(){
        $key=$this->zoom_api_key;
        $secret=$this->zoom_secret_key;
        $token=array(
            "iss">$key,
            "exp"=>time()+3600//60 second suggested
        );
        return JWT::encode($token,$secret,'HS256');
    }
    public function createMeeting($data=array()){
        $post_time=$data['start_date'];
        $start_time=gmdate("Y-m-d\TH:i:s",strtotime($post_time));
        $createMeetingArray['topic']=$data['topic'];
        $createMeetingArray['agenda']=!empty($data['agenda'])?$data['agenda']:"";
        $createMeetingArray['type']=!empty($data['type'])?$data['type']:"2";
        $createMeetingArray['start_time']=$start_time;
        $createMeetingArray['timezone']='Asia/Kuala_Lumpur';
        $createMeetingArray['password']=!empty($data['password'])?$data['password']:"2";
        $createMeetingArray['duration']=!empty($data['duration'])?$data['duration']:"30";

        $createMeetingArray['settings']=array(
        'join_before_host'=>!empty($data['join_before_host'])?true:false,
        'host_video'=>!empty($data['option_host_video'])?true:false,
        'particiant_video'=>!empty($data['option_particiant_video'])?true:false,
        'mute_upon_entry'=>!empty($data['option_mute_participants'])?true:false,
        'enfore_login'=>!empty($data['option_enfore_login'])?true:false,
        'auto_recording'=>!empty($data['option_auto_recording'])?$data['option_auto_recording']:false,
        'alternative_hosts'=>isset($alternative_host_ids)?$alternative_host_ids:"",

        );
        return $this->sendRequest($createMeetingArray);
    }

    //function send request
    public function sendRequest($data)
    {
        $request_url="https://api.zoom.us/v2/users/hengzp-am19@student.tarc.edu.my/meetings";
        $headers=array(
            "authorization:Bearer".$this->generateJWTKey(),
            "content-type:application/json",
            "Accept:application/json",
        );
        $postFields=json_encode($data);
        $ch=curl_init();
        curl_setopt_array($ch,array(
            CURLOPT_URL=>$request_url,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_ENCODING=>"",
            CURLOPT_MAXREDIRS=>10,
            CURLOPT_TIMEOUT>30,
            CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST=>"Post",
            CURLOPT_POSTFIELDS=>$postFields,
            CURLOPT_HTTPHEADER=>$headers,
        ));
        $response=curl_exec($ch);
        $err=curl_error($ch);
        curl_close($ch);
        if(!$response)
        {
            return $err;
        
        }
        return json_decode($response);
    }
    
}
?>