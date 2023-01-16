<?php

namespace App\Controllers;
use App\Libraries\PatientLib;
use App\Libraries\FirebaseCon;
use App\Libraries\LabLib;

class Lab extends BaseController
{
    public function add()
    {
        if($this->request->getMethod()=='post')
        {
            $key=$this->request->getPost('addLabPatientID');
            $patientData=PatientLib::readDataByKey($key);
            if($patientData!=false)
            {
                $userInfo=session()->get('staffloggedUser');
                $data=[
                    'userInfo'=>$userInfo,
                    'patientData'=>$patientData[1],
                    'pageTitle'=>'Add Lab Test'];
                
                    return view('staff/addLab',$data);
                }
            
        }
    }
    public function handleAjaxRequestPdf(){
        // $request=\Config\Services::Request();
 
         $data=$this->request->getVar();
         $imgurl=$this->request->getVar('name');
         $key=$this->request->getVar('key');
         $checkUpdate=LabLib::updatedReportUrl($key,$imgurl);
         /*
         $userInfo=session()->get('staffloggedUser');
         $labData=LabLib::readDataByKeySpecify($key);
         if($labData!=false)
         {
         $data=[
             'userInfo'=>$userInfo,
             'labData'=>$labData[1],
             'pageTitle'=>'Upate Lab Test Record'];
             session()->setFlashdata('successlab','Updated Successfully.');
             return view('staff/labUpdate',$data);
         }*/
         echo json_encode(array(
            "status"=>1,
            "message"=>"Successful request",
            "data"=>$data

        ));

 
     }
    public function __construct() {
        helper(["url", "form"]);
    }
    public function uploadPdf()
    {
       
        if($this->request->getMethod()=='post')
        {
            $key=$this->request->getPost('key');
            $labData=LabLib::readDataByKeySpecify($key);
            $userInfo=session()->get('staffloggedUser');
            $data=[
             'userInfo'=>$userInfo,
             'labData'=>$labData[1],
             'pageTitle'=>'Upate Lab Test Record'
            ];
            $rules=[
            'labReport'=>[
                'rules'=>'uploaded[labReport]|ext_in[labReport,pdf]',
                'label'=>'labReport',
                'errors'=>[
                    'uploaded'=>'Please uploaded file before click upload',  
                    'ext_in'=>'The file does not have a valid file extension, only accept pdf'
                    ]
            ]
            ];
        }
        if($this->validate($rules))
        {
     
           $file=$this->request->getFile('labReport');
         
           if($file->isValid()){   
            session()->setFlashdata('processing','update pdf');
            $newName = $file->getRandomName(); //This is if you want to change the file name to encrypted name
            $file->move(ROOTPATH . 'public/labReport/users', $newName);
            $directory = ROOTPATH."'public/labReport/users/$newName'";
           // print_r($_FILES['labReport']['name']);
           session()->setFlashdata('dir',$newName);
           session()->setFlashdata('filename',$_FILES['labReport']['name']);

           // return redirect()->to('staff/profile')->withInput($data);
           return view('staff/labUpdate',$data);

           }
        }else{
            session()->setFlashdata('failUploadReport',display_error($this->validator,'labReport'));
            return view('staff/labUpdate',$data);

        }
    }
    public function update()
    {
        if ($this->request->getMethod() == "post") {
            if(!empty($this->request->getPost('key')))
            {
                $key=$this->request->getPost('key');

                $validation = $this->validate([
                    'name' => [
                        'rules' => 'required|max_length[100]|min_length[2]',
                        'errors' => [
                            'required' => 'Please enter your medicine name',
                            'max_length' => 'Maximum 50 characters only',
                            'min_length' => 'Minimum 8 characters at least'
                        ]
                    ],
                    'laboratory' => [
                        'rules' => 'required|max_length[100]|min_length[10]',
                        'errors' => [
                            'required' => 'Description is required',
                            'max_length' => 'Maximum 100 characters only',
                            'min_length' => 'Provide more details'
                        ]
                    ],
                    'specimens' => [
                        'rules' => 'required|max_length[100]|min_length[2]',
                        'errors' => [
                            'required' => 'Please enter your specimens name',
                            'max_length' => 'Maximum 50 characters only',
                            'min_length' => 'Minimum 8 characters at least'
                        ]
                    ],
                    'desc' => [
                        'rules' => 'max_length[100]|min_length[10]',
                        'errors' => [
                            'max_length' => 'Maximum 100 characters only',
                            'min_length' => 'Provide more details about Notes'
                        ]
                        ]
                      
                ]);
                if(!$validation)
                {
                    //return view('patientDashboard/profile',['validation'=>$this->validator]);
                    session()->setFlashdata('nameError',display_error($this->validator,'name'));
                    session()->setFlashdata('laboratoryError',display_error($this->validator,'laboratory'));
                    session()->setFlashdata('specimensError',display_error($this->validator,'specimens'));
                    session()->setFlashdata('descError',display_error($this->validator,'desc'));
                   
                    session()->setFlashdata('error','error');

                    $userInfo=session()->get('staffloggedUser');
                    $labData=LabLib::readDataByKeySpecify($key);
                    if($labData!=false)
                    {
                    $data=[
                        'userInfo'=>$userInfo,
                        'labData'=>$labData[1],
                        'pageTitle'=>'Upate Lab Test Record'];
                        return view('staff/labUpdate',$data);
                    }else{
                        echo "no lab record found";
                    }

                }else{
                    //if no error
                    $name=$this->request->getPost('name');
                    $laboratory=$this->request->getPost('laboratory');
                    $specimens=$this->request->getPost('specimens');
                    $desc=$this->request->getPost('desc');
                    $status=$this->request->getPost('status');
                    
                    $labData=[
                        'desc'=>$desc,
                        'testname'=>$name,
                        'specimens'=>$specimens,
                        'laboratory'=>strtoupper($laboratory),
                        'status'=>$status,
                    ];
                   
                    //get connection to firebase
                    $database=FirebaseCon::getCon();
                    
                    //$postRef_result=$database->getReference("patient/".$key)->update($userData);
                    $postRef_result=$database->getReference("lab/".$key)->update($labData);
                    if(!$postRef_result){
                        $userInfo=session()->get('staffloggedUser');
                        $labData=LabLib::readDataByKeySpecify($key);
                        if($labData!=false)
                        {
                        $data=[
                            'userInfo'=>$userInfo,
                            'labData'=>$labData[1],
                            'pageTitle'=>'Upate Lab Test Record'];
                            session()->setFlashdata('failab','Something error......');

                            return view('staff/labUpdate',$data);
                        }
        
                    }else{

                        $userInfo=session()->get('staffloggedUser');
                        $labData=LabLib::readDataByKeySpecify($key);

                        if($labData!=false)
                        {
                        $data=[
                            'userInfo'=>$userInfo,
                            'labData'=>$labData[1],
                            'pageTitle'=>'Upate Lab Test Record'];
                            session()->setFlashdata('successlab','Updated Successfully.');
                           if($status=="completed")
                           {
                            $patientData=PatientLib::readDataByKey($labData[1]['patientkey']);
                            if($patientData[1]['email']!="")
                            {
                                //echo "send email";
                                //print_r($patientData[1]);
                                $email=$patientData[1]['email'];
                            
                                $to=$email;
                                $subject='Your Laboratory Test Result Completed.';
                                $message='Hi, '.$patientData[1]['email'].'<br><br>'
                                .'Your lab result was come out, please come to Mendiklinik Kampar to consult with our doctor any, if you have any issue please call 013-760 1108'
                                .' ,Thanks<br>';
                                $email = \Config\Services::email();
                                $email->setFrom('hengzp-am19@student.tarc.edu.my', 'Online Clinic');
                                $email->setTo($patientData[1]['email']);
                                $email->setSubject($subject);
                                $email->setMessage($message);
                                if($email->send())
                                {
                                    session()->setFlashdata('successlab','
                                    Updated Successfully, An email has been send to the patient if you want remind him this please Call To '.$patientData[1]['name'].' with Contact Number:'.$patientData[1]['phone']);
                                    return view('staff/labUpdate',$data);
            
                                }
                                else{
                                    session()->setFlashdata('faillab','Something went wrong');
                                    return view('staff/labUpdate',$data);            
                                }
                            }else{
                                session()->setFlashdata('successlab','
                                Updated Successfully, Please Call To '.$patientData[1]['name'].' with Contact Number: '.
                                $patientData[1]['phone']);
                                //echo "call him";
                                return view('staff/labUpdate',$data);
                            }
                           }
                            //return view('staff/labUpdate',$data);
                        }                    
                    } 
                }
            
            }
            else{
                // this is go to update page
                $key=$this->request->getPost("id");
                $userInfo=session()->get('staffloggedUser');
                $labData=LabLib::readDataByKeySpecify($key);
                if($labData!=false)
                {
                $data=[
                    'userInfo'=>$userInfo,
                    'labData'=>$labData[1],
                    'pageTitle'=>'Upate Lab Test Record'];
                    return view('staff/labUpdate',$data);
                }
            }
      
        }
    }
    public function updatePage()
    {
        if ($this->request->getMethod() == "post") {
        $key=$this->request->getPost("id");
        $userInfo=session()->get('staffloggedUser');
        $labData=LabLib::readDataByKeySpecify($key);
        if($labData!=false)
        {
        $data=[
            'userInfo'=>$userInfo,
            'labData'=>$labData[1],
            'pageTitle'=>'Upate Lab Test Record'];
            return view('staff/labUpdate',$data);
        }
    }
}
public function delete()
{
     //delete_id
     if ($this->request->getMethod() == "post") {
        $id=$this->request->getPost("delete_id");
        $patient_key=$this->request->getPost("patient_key");
       // echo $id;
       $database = FirebaseCon::getCon();
       $postRef_result = $database
        ->getReference('lab/'.$id)
        ->remove();
        if($postRef_result)
        {
            session()->setFlashdata('success','Delete lab succussfully');
                return redirect()->to('staff/panel?patient='.$patient_key.'')->withInput();

        }
        else{
            session()->setFlashdata('fail','Something went wrong');
            return redirect()->to('staff/panel?patient='.$patient_key.'')->withInput();
        }
    }
    else{
        echo "something wrong.";
    }
}
public function saveLab()
{
if ($this->request->getMethod() == "post") {
    $key=$this->request->getPost('key');
    $validation = $this->validate([
        'name' => [
            'rules' => 'required|max_length[100]|min_length[2]',
            'errors' => [
                'required' => 'Please enter your medicine name',
                'max_length' => 'Maximum 50 characters only',
                'min_length' => 'Minimum 8 characters at least'
            ]
        ],
        'laboratory' => [
            'rules' => 'required|max_length[100]|min_length[10]',
            'errors' => [
                'required' => 'Description is required',
                'max_length' => 'Maximum 100 characters only',
                'min_length' => 'Provide more details'
            ]
        ],
        'specimens' => [
            'rules' => 'required|max_length[100]|min_length[2]',
            'errors' => [
                'required' => 'Please enter your specimens name',
                'max_length' => 'Maximum 50 characters only',
                'min_length' => 'Minimum 8 characters at least'
            ]
        ],
        'desc' => [
            'rules' => 'max_length[100]|min_length[10]',
            'errors' => [
                'max_length' => 'Maximum 100 characters only',
                'min_length' => 'Provide more details about Notes'
            ]
        ]
    ]);
    if(!$validation)
    {

        $userInfo=session()->get('staffloggedUser');
        $patientData=PatientLib::readDataByKey($key);
        if($patientData!=false)
        {
        $data=[
            'userInfo'=>$userInfo,
            'patientData'=>$patientData[1],
            'validation'=>$this->validator,
            'pageTitle'=>'Add Lab Test'];
        
            return view('staff/addLab',$data);
        }
          }else{
            $name=$this->request->getPost('name');
            $laboratory=$this->request->getPost('laboratory');
            $specimens=$this->request->getPost('specimens');
            $desc=$this->request->getPost('desc');
            $status="processing";
        
            //get malaysia create date
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $CreateDate = date('Y-m-d');
            
            //values of user to array
            $labData=[
                'testname'=>strtoupper($name),
                'laboratory'=>strtoupper($laboratory),
                'specimens'=>$specimens,
                'desc'=>$desc,
                'status'=>$status,
                'date'=>$CreateDate,
                'report'=>"",
                'patientkey'=>$key

            ];

            $ref_table="lab";
            //get connection to firebase
            $database=FirebaseCon::getCon();
            $postRef_result=$database->getReference($ref_table)->push($labData);
            
            //check insert success or not
            if(!$postRef_result){
                session()->setFlashdata('fail','Something went wrong');
                return redirect()->to('staff/panel?patient='.$key.'')->withInput();

            }else{
                session()->setFlashdata('success','Added successfully.');
                return redirect()->to('staff/panel?patient='.$key.'')->withInput();

                
            }    
        }
   
}

}
  
}
