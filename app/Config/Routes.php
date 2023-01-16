<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');


$routes->group('',['filter'=>'AdminAuthCheck'],function($routes){
    $routes->get('/admin/manage', 'Admin::manage');
    $routes->post('/admin/addEmployee', 'Admin::add');
    $routes->get('/admin/editEmployee', 'Admin::editEmployee');
    $routes->get('/admin/delete', 'Admin::delete');
    $routes->get('/admin/logout', 'Admin::logout');
});
$routes->group('patient',['filter'=>'AuthCheck'],function($routes){

    $routes->get('home','PatientDash::home',['as'=>'patient.home']);
    $routes->get('profile','PatientDash::profile',['as'=>'patient.profile']);
    $routes->get('logout','PatientDash::logout',['as'=>'patient.logout']);
    $routes->post('updateProfile','PatientDash::updateProfile',['as'=>'patient.updateProfile']);
    $routes->post('uploadImage','PatientDash::uploadImage',['as'=>'patient.uploadImage']);
    $routes->post('updatePassword','PatientDash::updatePassword',['as'=>'patient.updatePassword']);
    $routes->get('appointment','Appointment::appointment',['as'=>'patient.appointment']);
    $routes->post('appointment','Appointment::makeAppointment',['as'=>'patient.appointment']);
    $routes->get('viewAppointment','Appointment::viewAppointment',['as'=>'patient.viewAppointment']);
    $routes->post('cancelAppointment','Appointment::cancelAppointment',['as'=>'patient.cancelAppointment']);
    $routes->post('editAppointment','Appointment::editAppointment',['as'=>'patient.editAppointment']);
    $routes->get('payment','Payment::index',['as'=>'patient.payment']);
    $routes->post('payment','Payment::processPayment',['as'=>'patient.processPayment']);
    $routes->get('consult','Consult::index',['as'=>'patient.consult']);
    $routes->post('consult','Consult::index',['as'=>'patient.consult']);
    $routes->get('number','PatientDash::number',['as'=>'patient.number']);
    $routes->get('lab','PatientLab::lab',['as'=>'patient.lab']);
    $routes->get('history','PatientDash::history',['as'=>'patient.history']);
    $routes->post('viewReceipt','PatientDash::viewReceipt',['as'=>'patient.viewReceipt']);


});


$routes->group('staff',['filter'=>'StaffAuthCheck'],function($routes){

    $routes->post('createAppointment','Appointment::createAppointment',['as'=>'staff.createAppointment']);
    $routes->get('createAppointment','Appointment::createAppointment',['as'=>'staff.createAppointment']);


    $routes->get('home','Staff::home',['as'=>'staff.home']);
    $routes->get('profile','Staff::profile',['as'=>'staff.profile']);
    //receiptionist
    $routes->get('pending','Staff::pending',['as'=>'staff.pending']);
    $routes->post('pending','Staff::pending',['as'=>'staff.pending']);
    $routes->post('updateStatus','Staff::updateStatus',['as'=>'staff.updateStatus']);
    $routes->get('consult','Staff::consult',['as'=>'staff.consult']);
    $routes->post('consult','Staff::consult',['as'=>'staff.consult']);

    //

    $routes->post('uploadImage','Staff::uploadImage',['as'=>'staff.uploadImage']);
    $routes->post('updateProfile','Staff::updateProfile',['as'=>'staff.updateProfile']);
    $routes->post('updatePassword','Staff::updatePassword',['as'=>'staff.updatePassword']);
    $routes->post('updatePassword','Staff::updatePassword',['as'=>'staff.updatePassword']);
    $routes->post('close','Staff::close',['as'=>'staff.close']);

    $routes->get('queue','Queue::manage',['as'=>'staff.queue']);
    $routes->get('register','Patient::index',['as'=>'patient.register']);
    $routes->post('register','Patient::register',['as'=>'patient.register']);
    $routes->get('view','Patient::view',['as'=>'patient.view']);
    $routes->post('view','Patient::view',['as'=>'patient.view']);
    $routes->post('panel','Patient::panel',['as'=>'patient.panel']);
    $routes->post('visitDetails','Patient::visitDetails',['as'=>'staff.visitDetails']);

    $routes->post('viewReceipt','Patient::viewReceipt',['as'=>'staff.viewReceipt']);
    
    $routes->post('update','Inventory::update',['as'=>'inventory.update']);

    $routes->get('panel','Patient::panel',['as'=>'patient.panel']);
    $routes->post('addQueue','Patient::addQueue',['as'=>'patient.addQueue']);

    $routes->post('updatePanel','Patient::update',['as'=>'patient.updatePanel']);
    $routes->post('moveQueue','Queue::moveQueue',['as'=>'patient.moveQueue']);
    $routes->get('queuePanel','Queuing::index',['as'=>'staff.queuePanel']);
    $routes->get('medicineCollect','Checkout::index',['as'=>'staff.medicineCollect']);

    $routes->get('/Queuing', 'Queuing::index');
    $routes->get('approvedAppointment','Staff::approvedAppointment',['as'=>'staff.approvedAppointment']);
    $routes->post('approvedAppointment','Staff::approvedAppointment',['as'=>'staff.approvedAppointment']);
    $routes->get('inventory','Inventory::index',['as'=>'staff.inventory']);
    $routes->get('addInventory','Inventory::add',['as'=>'staff.addInventory']);

    $routes->post('addInventory','Inventory::add',['as'=>'staff.addInventory']);
    $routes->post('updateInventory','Inventory::update',['as'=>'staff.updateInventory']);
    $routes->post('inventory','Inventory::index',['as'=>'staff.inventory']);

    $routes->post('addLab','Lab::add',['as'=>'patient.addLab']);
    $routes->post('saveLab','Lab::saveLab',['as'=>'patient.saveLab']);
    $routes->post('updatePage','Lab::updatePage',['as'=>'lab.updatePage']);
    $routes->post('update','Lab::update',['as'=>'lab.update']);
    
    $routes->post('uploadPdf','Lab::uploadPdf',['as'=>'lab.uploadPdf']);
    $routes->get('postEvent','NewsEvent::postEvent',['as'=>'staff.postEvent']);
    $routes->post('saveEvent','NewsEvent::saveEvent',['as'=>'staff.saveEvent']);
    $routes->get('saveEvent','NewsEvent::eventUpdate',['as'=>'staff.eventUpdate']);
    $routes->get('eventManage','NewsEvent::eventManage',['as'=>'staff.eventManage']);
    $routes->post('eventDelete','NewsEvent::eventDelete',['as'=>'staff.eventDelete']);
    $routes->post('updateEvent','NewsEvent::updateEvent',['as'=>'staff.updateEvent']);
    $routes->post('update','NewsEvent::update',['as'=>'event.update']);
    $routes->get('holiday','Staff::holiday',['as'=>'staff.holiday']);
    $routes->post('holiday','Staff::holiday',['as'=>'staff.holiday']);
    $routes->post('deleteHoliday','Staff::deleteHoliday',['as'=>'staff.deleteHoliday']);

    
    $routes->post('uploadImageEvent','NewsEvent::uploadImageEvent',['as'=>'staff.uploadImageEvent']);
    
    $routes->post('toBill','Queue::toBill',['as'=>'staff.toBill']);
    $routes->post('toCheckout','Checkout::toCheckout',['as'=>'staff.toCheckout']);
    $routes->post('toPayment','Checkout::toPayment',['as'=>'staff.toPayment']);
    $routes->post('pay','Checkout::pay',['as'=>'staff.pay']);
    $routes->post('receipt','Checkout::receipt',['as'=>'staff.receipt']);


    
    $routes->post('removePrescription','Queue::removePrescription',['as'=>'staff.removePrescription']);

    
});
$routes->group('',['filter'=>'StaffAuthCheck'],function($routes){
    $routes->post('/handle-myajax-event','NewsEvent::handleAjaxRequestEvent');
    $routes->post('/handle-myajax-eventupdate','NewsEvent::handleAjaxRequestEventUpdate');
   // $routes->post('/handle-myajax-addPrescription','Queue::handleAjaxRequestPrescription');

   

   // $routes->post('/handle-myajax','Staff::handleAjaxRequest');
   $routes->post('/handle-myajax2','Staff::handleAjaxRequest');

   $routes->post('/handle-myajax-uploadPdf','Lab::handleAjaxRequestPdf');

   $routes->post('/handle-myajax-progress','Queue::handleAjaxRequest');
   $routes->post('/handle-myajax-remove','Queue::handleAjaxRequestRemove');
   $routes->post('/handle-myajax-waiting','Queue::handleAjaxRequestWaiting');
   $routes->get('/Queuing', 'Queuing::index');
   $routes->get('/Inventory', 'Inventory::index');

   $routes->get('/Inventory/add', 'Inventory::add');
   $routes->post('/Inventory/add', 'Inventory::add');

   $routes->post('/staff/uploadImage', 'Staff::uploadImage');
   $routes->post('/staff/close', 'Staff::close');
   $routes->get('/queue/manage','Queue::manage');
   $routes->get('/patient/register','Patient::index');
   $routes->post('/patient/register', 'Patient::register');
   $routes->get('/patient/view', 'Patient::view');
   $routes->post('/patient/view', 'Patient::view');
   $routes->post('/patient/panel', 'Patient::panel');
   $routes->post('/patient/visitDetails', 'Patient::visitDetails');
   $routes->post('/patient/viewReceipt', 'Patient::viewReceipt');

   
   $routes->post('/patient/updatePanel', 'Patient::updatePanel');
   $routes->get('/patient/panel', 'Patient::panel');
   $routes->post('/Queue/moveQueue', 'Queue::moveQueue');
   $routes->get('/Queue/manage', 'Queue::manage');
   $routes->post('/Inventory/delete', 'Inventory::delete');
   $routes->post('/Lab/add', 'Lab::add');
   $routes->post('/Lab/saveLab', 'Lab::saveLab');
   $routes->post('/Lab/delete', 'Lab::delete');
   $routes->post('/Lab/updatePage', 'Lab::updatePage');
   $routes->post('/Lab/update', 'Lab::update');
   $routes->post('/Lab/uploadPdf', 'Lab::uploadPdf');

   $routes->post('/Inventory/updatePage', 'Inventory::updatePage');
   $routes->get('/NewsEvent/postEvent','NewsEvent::postEvent');
   $routes->post('/NewsEvent/saveEvent', 'NewsEvent::saveEvent');
   $routes->get('/NewsEvent/saveEvent','NewsEvent::saveEvent');
   $routes->get('/NewsEvent/eventManage','NewsEvent::eventManage');
   $routes->post('/NewsEvent/eventDelete', 'NewsEvent::eventDelete');
   $routes->post('/NewsEvent/updateEvent', 'NewsEvent::updateEvent');
   $routes->post('/NewsEvent/update', 'NewsEvent::update');
   $routes->post('/NewsEvent/uploadImageEvent', 'NewsEvent::uploadImageEvent');

   $routes->get('/Staff/holiday','Staff::holiday');
   $routes->post('/Staff/holiday','Staff::holiday');
   $routes->get('/Staff/deleteHoliday','Staff::deleteHoliday');

   $routes->post('/Appointment/createAppointment','Appointment::createAppointment');
   $routes->get('/Appointment/createAppointment','Appointment::createAppointment');

   $routes->post('/Queue/removePrescription','Queue::removePrescription');

   $routes->post('/Queue/toBill','Queue::toBill');
   $routes->post('/Checkout/toCheckout','Checkout::toCheckout');
   $routes->post('/Checkout/toPayment','Checkout::toPayment');
   $routes->post('/Checkout/pay','Checkout::pay');
   $routes->post('/Checkout/receipt','Checkout::receipt');
   
   

});

$routes->group('',['filter'=>'AuthCheck'],function($routes){
    $routes->get('/PatientDash/profile','PatientDash::profile');
    $routes->get('/PatientDash/Profile','PatientDash::profile');
    $routes->get('/PatientDash/home','PatientDash::home');
    $routes->post('/PatientDash/updateProfile','PatientDash::updateProfile');
    $routes->post('/PatientDash/uploadImage','PatientDash::uploadImage');
    $routes->post('/handle-myajax','PatientDash::handleAjaxRequest');
    $routes->post('/PatientDash/updatePassword','PatientDash::updatePassword');
    $routes->get('/Appointment/appointment','Appointment::appointment');
    $routes->get('/Appointment/makeAppointment','Appointment::makeAppointment'); 
    $routes->get('/Appointment/viewAppointment','Appointment::viewAppointment'); 
    $routes->post('/Appointment/cancelAppointment','Appointment::cancelAppointment'); 
    $routes->post('/Appointment/editAppointment','Appointment::editAppointment'); 
    $routes->post('/Appointment/editAppointment','Appointment::editAppointment'); 
    $routes->get('/Payment','Payment::index'); 
    $routes->post('/Payment','Payment::processPayment'); 
    $routes->get('/Payment','Payment::index'); 
    $routes->get('/Consult','Consult::index'); 
    $routes->post('/Consult','Consult::index'); 
    $routes->post('/consult','Consult::index'); 
    $routes->get('/PatientDash/number','PatientDash::number'); 
    $routes->get('/PatientLab/lab','PatientLab::lab'); 

    $routes->get('/PatientDash/history','PatientDash::history'); 
    $routes->post('/PatientDash/viewReceipt','PatientDash::viewReceipt'); 


});
$routes->group('',['filter'=>'AlreadyLoggedIn'],function($routes){
    $routes->get('/auth','Auth::index');
    $routes->get('/Auth','Auth::index');
    $routes->get('/Auth/register','Auth::register');
    $routes->get('/auth/register','Auth::register');
    $routes->get('/Auth/forgot','Auth::forgot');
    $routes->get('/auth/forgot','Auth::forgot');

});
$routes->group('',['filter'=>'AdminAlreadyLoggedIn'],function($routes){
    $routes->get('/admin','Admin::index');

});
$routes->group('',['filter'=>'StaffAlreadyLoggedIn'],function($routes){
    $routes->get('/staff','Staff::index');

});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
