<?php

use App\Http\Livewire\Counter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Financial\SubmitPatientPayments;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('analyzer_service', 'AnalyzersController@analyzer_service')->name('analyzer_service');
Auth::routes();
//Auth::routes(['register' => false]);


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
      
        //to redirct user to clinic system or to lab system
        if(Auth::user()->user_titile&&Auth::user()->doctor_id){
           
            return redirect()->to('http://192.168.43.138:8000/clinic/');
        }elseif(Auth::user()->user_titile=='pharmacy'){
            
            return redirect()->to('http://192.168.43.138:8000/clinic/');
        }else{

            
            return view('Dashboard.Dashboard');
        }
        
        //return view('auth.login');
    });

    
    Route::resource('roles', 'RoleController');

    Route::resource('users', 'UserController');


   Route::get('/', 'HomeController@index')->name('home');
   Route::get('/home', 'HomeController@index')->name('home');
    
    //Lab link

    //regions
    Route::resource('regions', 'RegionsController');

    //branches
    Route::resource('branches', 'BranchesController');
    Route::get('/edit_branch/{id}', 'BranchesController@edit');
    Route::get('add_Processing_units', 'BranchesController@add_Processing_units')->name('add_Processing_units');
    Route::POST('delete_processing_unit', 'BranchesController@delete_processing_unit')->name('delete_processing_unit');
    Route::post('update_processing_unit', 'BranchesController@update_processing_unit')->name('update_processing_unit');
    Route::get('open_Clinical_units', 'BranchesController@open_Clinical_units')->name('open_Clinical_units');
    Route::post('add_Clinical_unit', 'BranchesController@add_Clinical_unit')->name('add_Clinical_unit');
    Route::post('delete_Clinical_unit', 'BranchesController@delete_Clinical_unit')->name('delete_Clinical_unit');
    Route::post('update_Clinical_unit', 'BranchesController@update_Clinical_unit')->name('update_Clinical_unit');


    //samples
    Route::resource('sample_types', 'SampleTypesController');
    Route::post('add_sample_type', 'SampleTypesController@store')->name('add_sample_type');
    Route::post('delete_sample_type', 'SampleTypesController@destroy')->name('delete_sample_type');
    Route::post('edit_sample_type', 'SampleTypesController@update')->name('edit_sample_type');
    Route::get('/show_sample_conditions/{id}', 'SampleTypesController@show_sample_conditions');

    Route::post('add_sample_condition', 'SampleConditionsController@store')->name('add_sample_condition');
    Route::post('delete_sample_condition', 'SampleConditionsController@destroy')->name('delete_sample_condition');
    Route::post('edit_sample_condition', 'SampleConditionsController@update')->name('edit_sample_condition');

    //Analyzers
    Route::resource('Analyzers', 'AnalyzersController');
    Route::get('/edit_analyzer/{id}', 'AnalyzersController@edit');
    Route::post('addAnalyzer_test', 'AnalyzersController@addAnalyzer_test')->name('addAnalyzer_test');
    Route::post('delete_Analyzer_test', 'AnalyzersController@delete_Analyzer_test')->name('delete_Analyzer_test');
    Route::post('copy_analyzer_tests', 'AnalyzersController@copy_analyzer_tests')->name('copy_analyzer_tests');
    


    //Tests
    Route::resource('units', 'UnitsController');
    Route::post('add_Unit', 'UnitsController@store')->name('add_Unit');
    Route::post('delete_unit', 'UnitsController@destroy')->name('delete_unit');
    Route::post('edit_Unit', 'UnitsController@update')->name('edit_Unit');

    Route::resource('tests', 'TestsController');
    Route::get('/edit_test/{id}', 'TestsController@edit');
    Route::get('/get_sample_conditions/{id}', 'TestsController@get_sample_conditions');


    Route::post('add_configurations_numeric', 'TestsController@add_configurations_numeric')->name('add_configurations_numeric');
    Route::post('delete_configurations_numeric', 'TestsController@delete_configurations_numeric')->name('delete_configurations_numeric');
    Route::post('edit_configurations_numeric', 'TestsController@edit_configurations_numeric')->name('edit_configurations_numeric');

    Route::post('add_configurations_option_list', 'TestsController@add_configurations_option_list')->name('add_configurations_option_list');
    Route::post('delete_configurations_option_list', 'TestsController@delete_configurations_option_list')->name('delete_configurations_option_list');
    Route::post('edit_configurations_option_list', 'TestsController@edit_configurations_option_list')->name('edit_configurations_option_list');

    Route::resource('preparation_questions', 'PreparationQuestionsController');

    Route::get('NonClinicalUsers', 'PreparationQuestionsController@NonClinicalUsers');
    Route::post('add_NonClinicalUser', 'PreparationQuestionsController@add_NonClinicalUser')->name('add_NonClinicalUser');
    Route::post('delete_NonClinicalUser', 'PreparationQuestionsController@delete_NonClinicalUser')->name('delete_NonClinicalUser');
    Route::post('edit_NonClinicalUser', 'PreparationQuestionsController@edit_NonClinicalUser')->name('edit_NonClinicalUser');

    Route::get('referringDoctors', 'PreparationQuestionsController@referringDoctors');
    Route::post('add_referringDoctor', 'PreparationQuestionsController@add_referringDoctor')->name('add_referringDoctor');
    Route::post('delete_referringDoctor', 'PreparationQuestionsController@delete_referringDoctor')->name('delete_referringDoctor');
    Route::post('edit_referringDoctor', 'PreparationQuestionsController@edit_referringDoctor')->name('edit_referringDoctor');

    Route::resource('cancel_reasons', 'CancelReasonsController');

    Route::post('add_question_to_test', 'TestsController@add_question_to_test')->name('add_question_to_test');
    Route::post('delete_question_from_test', 'TestsController@delete_question_from_test')->name('delete_question_from_test');

    Route::post('add_branch_sample', 'TestsController@add_branch_sample')->name('add_branch_sample');
    Route::post('delete_test_branch_sample', 'TestsController@delete_test_branch_sample')->name('delete_test_branch_sample');
    Route::post('delete_single_branch_sample', 'TestsController@delete_single_branch_sample')->name('delete_single_branch_sample');

    Route::get('antibiotics', 'TestsController@antibiotics');
    Route::post('add_antibiotic', 'TestsController@add_antibiotic')->name('add_antibiotic');
    Route::post('delete_antibiotic', 'TestsController@delete_antibiotic')->name('delete_antibiotic');
    Route::post('edit_antibiotic', 'TestsController@edit_antibiotic')->name('edit_antibiotic');

    Route::get('organisms', 'TestsController@organisms');
    Route::post('add_organism', 'TestsController@add_organism')->name('add_organism');
    Route::post('delete_organism', 'TestsController@delete_organism')->name('delete_organism');
    Route::post('edit_organism', 'TestsController@edit_organism')->name('edit_organism');


    //Services
    Route::resource('services', 'ServicesController');
    Route::get('/edit_service/{id}', 'ServicesController@edit');
    Route::post('delete_service_test', 'ServicesController@delete_service_test')->name('delete_service_test');
    Route::post('delete_nested_service', 'ServicesController@delete_nested_service')->name('delete_nested_service');
    Route::post('add_service_test', 'ServicesController@add_service_test')->name('add_service_test');
    Route::post('add_service_package', 'ServicesController@add_service_package')->name('add_service_package');

    Route::get('extra_services', 'ServicesController@extra_services');
    Route::post('add_extra_service', 'ServicesController@add_extra_service')->name('add_extra_service');
    Route::post('delete_extra_service', 'ServicesController@delete_extra_service')->name('delete_extra_service');
    Route::post('edit_extra_service', 'ServicesController@edit_extra_service')->name('edit_extra_service');

    
    Route::view('assign_service_to_processing_unit', 'livewire.services.assign-service-to-processing-unit_main');

    //currencies
    Route::resource('currencies', 'CurrenciesController');

    //contract_classifications
    Route::resource('contract_classifications', 'ContractClassificationsController');

    //DiscountCommentsController
    Route::resource('discount_comments', 'DiscountCommentsController');

    //price_lists
    Route::resource('price_lists', 'PriceListsController');
    Route::get('/edit_price_lists/{id}', 'PriceListsController@edit');
    Route::post('edit_service_price', 'PriceListsController@edit_service_price')->name('edit_service_price');
    Route::post('edit_extra_service_price', 'PriceListsController@edit_extra_service_price')->name('edit_extra_service_price');
    Route::post('copy_price_list', 'PriceListsController@copy_price_list')->name('copy_price_list');
    Route::get('/export_price_list/{id}', 'PriceListsController@export_price_list');
    Route::post('/import_price_list', 'PriceListsController@import_price_list')->name('import_price_list');


    //Payers
    Route::resource('payers', 'PayersController');
    Route::get('/edit_payer/{id}', 'PayersController@edit');
    Route::post('add_payer_contract', 'PayersController@add_payer_contract')->name('add_payer_contract');
    Route::post('edit_payer_contract', 'PayersController@edit_payer_contract')->name('edit_payer_contract');
    Route::post('delete_payer_contract', 'PayersController@delete_payer_contract')->name('delete_payer_contract');

    Route::get('/contract_price_list_settings/{id}', 'PayersController@contract_price_list_settings');

    Route::post('add_price_list_to_contract', 'PayersController@add_price_list_to_contract')->name('add_price_list_to_contract');
    Route::post('edit_price_list_contract', 'PayersController@edit_price_list_contract')->name('edit_price_list_contract');
    Route::post('delete_price_list_from_contract', 'PayersController@delete_price_list_from_contract')->name('delete_price_list_from_contract');


    //Treasuries
    Route::resource('treasuries', 'TreasuriesController');
    Route::get('open_treasuries_requests', 'TreasuriesController@open_treasuries_requests')->name('open_treasuries_requests');
    Route::get('/get_branch_treasuries/{id}', 'TreasuriesController@get_branch_treasuries');
    Route::post('new_treasury_request', 'TreasuriesController@new_treasury_request')->name('new_treasury_request');
    Route::get('open_handle_treasuries_requests', 'TreasuriesController@open_handle_treasuries_requests')->name('open_handle_treasuries_requests');
    Route::get('/Search_treasuries_requests/{treasury_id}', 'TreasuriesController@Search_treasuries_requests');

    Route::post('update_treasury_request', 'TreasuriesController@update_treasury_request')->name('update_treasury_request');
    Route::post('delete_treasury_request', 'TreasuriesController@delete_treasury_request')->name('delete_treasury_request');

    //Sample Location
    Route::resource('sampleLocation', 'SampleLocationController');
    Route::get('monitor_sampleLocation', 'SampleLocationController@monitor_sampleLocation')->name('monitor_sampleLocation');
    Route::get('/get_branch_Processing_units/{id}', 'SampleLocationController@get_branch_Processing_units');
    Route::get('/get_current_sampleStatus/{id}', 'SampleLocationController@get_current_sampleStatus');
    Route::post('new_sampleLocation_request', 'SampleLocationController@new_sampleLocation_request')->name('new_sampleLocation_request');
    Route::post('update_sampleLocation_request_status', 'SampleLocationController@update_sampleLocation_request_status')->name('update_sampleLocation_request_status');
    Route::post('delete_sampleLocation_request', 'SampleLocationController@delete_sampleLocation_request')->name('delete_sampleLocation_request');
    Route::get('receive_sample', 'SampleLocationController@receive_sample')->name('receive_sample');
    Route::get('/receive_Sample_barcode/{Sample_barcode}/{sample_location_id}', 'SampleLocationController@receive_Sample_barcode');


    //Registration
    //Route::resource('registration', 'RegistrationsController');

    Route::view('registration', 'livewire.registration.registration_main');
    Route::view('searchregistration', 'livewire.registration.search_registration_main');
    Route::view('homeservices', 'livewire.registration.homeservices_main');

    
    //Financial
    Route::view('SubmitPatientPayments', 'livewire.financial.SubmitPatientPayments_main');
    Route::view('SearchPayment', 'livewire.financial.SearchPayment_main');

    //pring documents
    //Route::post('reprintSampleDetails', 'SilentController@ReprintSampleDetails');
    Route::get('printSampleDetails_Silent', 'SilentController@printSampleDetails_Silent');

    //print patient result
    Route::get('print_result_Silent', 'SilentController@print_result_Silent');
    Route::get('download_result', 'SilentController@download_result');
    Route::get('reprint_sample_details', 'SilentController@show_reprint_sample_details');
    Route::post('print_sample_details', 'SilentController@print_sample_details')->name('print_sample_details');

    Route::get('reprint_sample_id', 'SilentController@reprint_sample_id');

    Route::get('View_Receipt_List', 'SilentController@View_Receipt_List');

    Route::get('Reprint_Receipt_number', 'SilentController@Reprint_Receipt_number');

    Route::get('View_Patient_Last_Results', 'SilentController@View_Patient_Last_Results');
    Route::get('View__regisration_comment', 'SilentController@View__regisration_comment');
    Route::get('View_Financial_Claim', 'SilentController@View_Financial_Claim');//details
    Route::get('View_Financial_Brief', 'SilentController@View_Financial_Brief');//short report

    Route::get('service_income_report', 'SilentController@service_income_report');//short report
    Route::get('/get_payer_contract_list/{payer_id}', 'SilentController@get_payer_contract_list');
    Route::post('view_service_income_report', 'SilentController@view_service_income_report')->name('view_service_income_report');
    
    Route::get('patients_income_report', 'SilentController@patients_income_report');//short report
    Route::post('view_patients_income_report', 'SilentController@view_patients_income_report')->name('view_patients_income_report');
    
    Route::get('header_paper', 'SilentController@header_paper');//short report
    Route::post('view_header_paper', 'SilentController@view_header_paper')->name('view_header_paper');


    //tools
   // Route::get('change_processing_unit', 'SilentController@change_processing_unit');//short report

    Route::view('tools', 'livewire.tools.tools_main');

//results
    Route::view('results', 'livewire.results.results_main');
    //Route::view('new_result', 'livewire.results.registration_main');

/*Route::get('sampleDetails_Silent',  function (){
   // $pdf = App::make('snappy.pdf.wrapper');
$pdf=PDF::loadHTML('<h1>Test DDD</h1>');
return $pdf->inline();
});*/
});

//************************* Clinic API *************************************** */
Route::get('get_hash_clinic/{pass_has}', 'SilentController@get_hash_clinic');


Route::get('/clinic', 'HomeController@clinic')->name('clinic');
Route::get('/logout_mms', 'HomeController@perform')->name('logout_mms');

Route::get('view_clinic_result/{clinic_trans_no}', 'SilentController@view_clinic_result');


//************************* call center routers *************************************** */
Route::get('open_LabTechDrivers', 'AppUsersController@open_LabTechDrivers')->name('open_LabTechDrivers');
Route::post('add_LabTechDriver', 'AppUsersController@add_LabTechDriver')->name('add_LabTechDriver');
Route::post('delete_LabTechDriver', 'AppUsersController@delete_LabTechDriver')->name('delete_LabTechDriver');
Route::post('update_LabTechDriver', 'AppUsersController@update_LabTechDriver')->name('update_LabTechDriver');

Route::get('open_AppUsers', 'AppUsersController@open_AppUsers')->name('open_AppUsers');
Route::get('/change_AppUserStatus/{id}', 'AppUsersController@change_AppUserStatus');

Route::get('open_Area', 'AppUsersController@open_Area')->name('open_Area');
Route::post('add_Area', 'AppUsersController@add_Area')->name('add_Area');
Route::post('delete_Area', 'AppUsersController@delete_Area')->name('delete_Area');
Route::post('update_Area', 'AppUsersController@update_Area')->name('update_Area');

Route::get('App_General_Setting', 'AppUsersController@App_General_Setting')->name('App_General_Setting');
Route::post('update_App_General_Setting', 'AppUsersController@update_App_General_Setting')->name('update_App_General_Setting');

Route::get('appBranches', 'AppUsersController@appBranches')->name('appBranches');
Route::get('/edit_appBranch/{id}', 'AppUsersController@edit_appBranch');
Route::get('add_appBranch', 'AppUsersController@add_appBranch')->name('add_appBranch');
Route::post('store_appBranch', 'AppUsersController@store_appBranch')->name('store_appBranch');
Route::post('delete_appBranch', 'AppUsersController@delete_appBranch')->name('delete_appBranch');
Route::post('update_appBranch', 'AppUsersController@update_appBranch')->name('update_appBranch');




//**************************************************************** */

//Route::resource('invoices', 'InvoicesController');
/*
Route::resource('sections', 'SectionsController');

Route::resource('products', 'ProductsController');

Route::resource('InvoiceAttachments', 'InvoiceAttachmentsController');

//Route::resource('InvoicesDetails', 'InvoicesDetailsController');

Route::get('/section/{id}', 'InvoicesController@getproducts');

Route::get('/InvoicesDetails/{id}', 'InvoicesDetailsController@edit');

Route::get('download/{invoice_number}/{file_name}', 'InvoicesDetailsController@get_file');

Route::get('View_file/{invoice_number}/{file_name}', 'InvoicesDetailsController@open_file');

Route::post('delete_file', 'InvoicesDetailsController@destroy')->name('delete_file');

Route::get('/edit_invoice/{id}', 'InvoicesController@edit');

Route::get('/Status_show/{id}', 'InvoicesController@show')->name('Status_show');

Route::post('/Status_Update/{id}', 'InvoicesController@Status_Update')->name('Status_Update');

Route::resource('Archive', 'InvoiceAchiveController');

Route::get('Invoice_Paid', 'InvoicesController@Invoice_Paid');

Route::get('Invoice_UnPaid', 'InvoicesController@Invoice_UnPaid');

Route::get('Invoice_Partial', 'InvoicesController@Invoice_Partial');

Route::get('Print_invoice/{id}', 'InvoicesController@Print_invoice');

Route::get('export_invoices', 'InvoicesController@export');



Route::get('invoices_report', 'Invoices_Report@index');

Route::post('Search_invoices', 'Invoices_Report@Search_invoices');

Route::get('customers_report', 'Customers_Report@index')->name("customers_report");

Route::post('Search_customers', 'Customers_Report@Search_customers');

Route::get('MarkAsRead_all', 'InvoicesController@MarkAsRead_all')->name('MarkAsRead_all');

Route::get('unreadNotifications_count', 'InvoicesController@unreadNotifications_count')->name('unreadNotifications_count');

Route::get('unreadNotifications', 'InvoicesController@unreadNotifications')->name('unreadNotifications');
*/

Route::get('/{page}', 'AdminController@index');