<?php

namespace App\Controllers;

use App\Libraries\Hash;
use App\Libraries\FirebaseCon;
use App\Libraries\AdminLib;
use App\Libraries\myic;
use App\Libraries\InventoryLib;

class Inventory extends BaseController {
    public function test()
    {
        $record = AdminLib::paginationRecord('inventory', 0, 2);
        $quantity = array_column($record, 'quantity');
        $price = array();

        $price=array_multisort($quantity, SORT_ASC, $record);
        print_r($record);
        $quantity = array_column($record, 'quantity');
        $price=array_multisort($quantity, SORT_DESC, $record);
        print_r($record);
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
                    'description' => [
                        'rules' => 'required|max_length[100]|min_length[10]|checkHomeAddress[address]',
                        'errors' => [
                            'required' => 'Description is required',
                            'max_length' => 'Maximum 100 characters only',
                            'min_length' => 'Provide more details',
                            'checkHomeAddress' => 'Invalid description can only contain comman, whitespace, number, letter only'
                        ]
                    ],
                    'price' => [
                        'rules' => 'required|checkPrice[price]|priceSmallThanZero[price]',
                        'errors' => [
                            'required' => 'price is required',
                            'checkPrice' => 'price only accept eg 10.00 or 10',
                            'priceSmallThanZero' => 'price cannot be zero or negative'
                        ]
                    ],
                    'quantity' => [
                        'rules' => 'required|checkQuantity[quantity]',
                        'errors' => [
                            'required' => 'Quantity  is required',
                            'checkQuantity' => 'Quantity cannot be zero or smaller than 0'
                        ]
                    ],
                    'Supplier' => [
                        'rules' => 'required|max_length[100]|min_length[10]|alpha_space',
                        'errors' => [
                            'required' => 'Supplier  is required',
                            'max_length' => 'Maximum 100 characters only',
                            'min_length' => 'Provide more details about Supplier'
                        ]
                        ],
                    'Notes' => [
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
                    session()->setFlashdata('descError',display_error($this->validator,'description'));
                    session()->setFlashdata('priceError',display_error($this->validator,'price'));
                    session()->setFlashdata('quantityError',display_error($this->validator,'quantity'));
                    session()->setFlashdata('supplierError',display_error($this->validator,'Supplier'));
                    session()->setFlashdata('notesError',display_error($this->validator,'Notes'));
                    session()->setFlashdata('error','error');

                    $userInfo=session()->get('staffloggedUser');
                    $inventoryData=InventoryLib::readDataByKey($key);
                    if($inventoryData!=false)
                    {
                    $data=[
                        'userInfo'=>$userInfo,
                        'inventoryData'=>$inventoryData[1],
                        'pageTitle'=>'Update Inventory Item'];
                        return view('staff/inventoryUpdate',$data);
                    }

                }else{
                    //if no error
                    $name=$this->request->getPost('name');
                    $description=$this->request->getPost('description');
                    $price=$this->request->getPost('price');
                    $quantity=$this->request->getPost('quantity');
                    $Supplier=$this->request->getPost('Supplier');
                    $Notes=$this->request->getPost('Notes');
                    $date=$this->request->getPost('date');
                    $dispensation=$this->request->getPost('Dispensation');
    
                    $itemData=[
                        'desc'=>$description,
                        'dispensation'=>$dispensation,
                        'expiryDate'=>$date,
                        'medicineName'=>strtoupper($name),
                        'notes'=>$Notes,
                        'price'=>$price,
                        'quantity'=>$quantity,
                        'supplier'=>$Supplier
                    ];
                   
                    //get connection to firebase
                    $database=FirebaseCon::getCon();
                    
                    //$postRef_result=$database->getReference("patient/".$key)->update($userData);
                    $postRef_result=$database->getReference("inventory/".$key)->update($itemData);
                    if(!$postRef_result){
                        $userInfo=session()->get('staffloggedUser');
                        $inventoryData=InventoryLib::readDataByKey($key);
                        if($inventoryData!=false)
                        {
                        $data=[
                            'userInfo'=>$userInfo,
                            'inventoryData'=>$inventoryData[1],
                            'pageTitle'=>'Update Inventory Item'];
                            session()->setFlashdata('failfail','Something error......');

                            return view('staff/inventoryUpdate',$data);
                        }
        
                    }else{

                        $userInfo=session()->get('staffloggedUser');
                        $inventoryData=InventoryLib::readDataByKey($key);
                        if($inventoryData!=false)
                        {
                        $data=[
                            'userInfo'=>$userInfo,
                            'inventoryData'=>$inventoryData[1],
                            'pageTitle'=>'Update Inventory Item'];
                            session()->setFlashdata('successsuccess','Updated Successfully.');

                            return view('staff/inventoryUpdate',$data);
                        }                    } 
                }
            
            }
            else{
                // this is go to update page
                $key=$this->request->getPost('id');
                $userInfo=session()->get('staffloggedUser');
                $inventoryData=InventoryLib::readDataByKey($key);
                if($inventoryData!=false)
                {
                $data=[
                    'userInfo'=>$userInfo,
                    'inventoryData'=>$inventoryData[1],
                    'pageTitle'=>'Update Inventory Item'];
                
                return view('staff/inventoryUpdate',$data);
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
            ->getReference('inventory/'.$id)
            ->remove();
            if($postRef_result)
            {
                return redirect()
                ->back()
                ->with("success", "Item delete successfully.");
            }
            else{
                return redirect()
                ->back()
                ->with("fail", "Item delete failed.");
            }
        }
        else{
            echo "something wrong.";
        }
    }
    public function __construct() {
        helper(["url", "form"]);
    }

    public function add() {
        $userInfo = session()->get('staffloggedUser');

        $data=[
            'userInfo'=>$userInfo,
            "pageTitle" => "Add New Medicine"
            ]; 
        if ($this->request->getMethod() == "post") {
            //validation for register form
            $validation = $this->validate([
                'name' => [
                    'rules' => 'required|max_length[100]|min_length[2]',
                    'errors' => [
                        'required' => 'Please enter your medicine name',
                        'max_length' => 'Maximum 50 characters only',
                        'min_length' => 'Minimum 8 characters at least'
                    ]
                ],
                'description' => [
                    'rules' => 'required|max_length[100]|min_length[10]|checkHomeAddress[address]',
                    'errors' => [
                        'required' => 'Description is required',
                        'max_length' => 'Maximum 100 characters only',
                        'min_length' => 'Provide more details',
                        'checkHomeAddress' => 'Invalid description can only contain comman, whitespace, number, letter only'
                    ]
                ],
                'price' => [
                    'rules' => 'required|checkPrice[price]|priceSmallThanZero[price]',
                    'errors' => [
                        'required' => 'price is required',
                        'checkPrice' => 'price only accept eg 10.00 or 10',
                        'priceSmallThanZero' => 'price cannot be zero or negative'
                    ]
                ],
                'quantity' => [
                    'rules' => 'required|checkQuantity[quantity]',
                    'errors' => [
                        'required' => 'Quantity  is required',
                        'checkQuantity' => 'Quantity cannot be zero or smaller than 0'
                    ]
                ],
                'Supplier' => [
                    'rules' => 'required|max_length[100]|min_length[10]|alpha_space',
                    'errors' => [
                        'required' => 'Supplier  is required',
                        'max_length' => 'Maximum 100 characters only',
                        'min_length' => 'Provide more details about Supplier'
                    ]
                ],
                'Notes' => [
                    'rules' => 'max_length[100]|min_length[10]',
                    'errors' => [
                        'max_length' => 'Maximum 100 characters only',
                        'min_length' => 'Provide more details about Notes'
                    ]
                ]
            ]);
            if(!$validation)
            {
                 $data=[
                'userInfo'=>$userInfo,
                "pageTitle" => "Add New Medicine",
                'validation'=>$this->validator
                ]; 

                return view('staff/addInventory',$data);
            }else{
                        $name=$this->request->getPost('name');
                        $description=$this->request->getPost('description');
                        $price=$this->request->getPost('price');
                        $quantity=$this->request->getPost('quantity');
                        $Supplier=$this->request->getPost('Supplier');
                        $Notes=$this->request->getPost('Notes');
                        $date=$this->request->getPost('date');
                        $Dispensation=$this->request->getPost('Dispensation');
                        $itemData=[
                            'medicineName'=>strtoupper($name),
                            'desc'=>$description,
                            'price'=>$price,
                            'quantity'=>$quantity,
                            'supplier'=>$Supplier,
                            'notes'=>$Notes,
                            'expiryDate'=>$date,
                            'dispensation'=>$Dispensation
                        ];
                        $ref_table="inventory";
                        //get connection to firebase
                        $database=FirebaseCon::getCon();
                        $postRef_result=$database->getReference($ref_table)->push($itemData);
                          //check insert success or not
                          if(!$postRef_result){
                            return redirect()->to('Inventory/add')->with('fail','Something went wrong');
                        }else{
                            return redirect()->to('Inventory/add')->with('success','Item Added Successfully.');
                        }    
            }
        }
        return view('staff/addInventory', $data);

    }

    public function index() {
        session()->setFlashdata('sucess','');
        session()->setFlashdata('fail','');

        if ($this->request->getMethod() == "post") {
      
            $searchName=$this->request->getPost("searchName");
            $sort=$this->request->getPost("sort");
            $expired=$this->request->getPost("expired");

            
         
        }
        $userInfo = session()->get('staffloggedUser');

        // Dynamic limit
        $limit = 5;
        // Get total records
        $allRecords = AdminLib::countRecords('inventory');
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
        if(empty($searchName)&&empty($sort)&&empty($expired))
        {
        $record = AdminLib::paginationRecord('inventory', $paginationStart, $end);
        $quantity = array_column($record, 'medicineName');
        $price=array_multisort($quantity, SORT_ASC, $record);
        }
        if(!empty($searchName)&&empty($expired))
        {
            $record = InventoryLib::paginationRecordSearchName('inventory', $paginationStart, $end,'medicineName',$searchName);
            if(empty($record))
            {
                session()->setFlashdata('fail','no data found');

            }else{
                session()->setFlashdata('success','data found');

            }
        }
        if(!empty($expired))
        {
        
        $record = InventoryLib::paginationRecordExpired('inventory', $paginationStart, $end);
        if(empty($record))
        {
            session()->setFlashdata('fail','no data found');

        }else{
            session()->setFlashdata('success','data found');

        }
        }
        if(empty($searchName)&&!empty($sort)&&$sort=="hightToLow")
        {
        
        $record = AdminLib::paginationRecord('inventory', $paginationStart, $end);
        $quantity = array_column($record, 'quantity');
        $price=array_multisort($quantity, SORT_DESC, $record);
        }
        if(empty($searchName)&&!empty($sort)&&$sort=="LowToHigh")
        {
        
        $record = AdminLib::paginationRecord('inventory', $paginationStart, $end);
        $quantity = array_column($record, 'quantity');
        $price=array_multisort($quantity, SORT_ASC, $record);
        }
        if (!empty($record)) {
            $data = [
                "userInfo" => $userInfo,
                "pageTitle" => "Inventory Management",
                "inventoryData" => $record,
                'limit' => $limit,
                'allRecords' => $allRecords,
                'totoalPages' => $totoalPages,
                'page' => $page,
                'paginationStart' => $paginationStart,
                'prev' => $prev,
                'next' => $next
            ];
            return view("staff/inventory", $data);
        } else {
            $data = [
                "userInfo" => $userInfo,
                "pageTitle" => "Inventory Management",
                'limit' => $limit,
                'allRecords' => $allRecords,
                'totoalPages' => $totoalPages,
                'page' => $page,
                'paginationStart' => $paginationStart,
                'prev' => $prev,
                'next' => $next
            ];
            return view('staff/inventory', $data);
        }
    }

}
