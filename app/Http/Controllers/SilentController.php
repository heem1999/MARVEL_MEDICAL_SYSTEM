<?php

namespace App\Http\Controllers;

use  Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\registrations;
use App\Services;
use App\Payers;
use App\Payer_contracts;
use App\contracts_price_list_settings;
use App\contract_branches;
use App\Price_lists;
use App\Price_list_services;
use App\service_tests;
use App\AssignSerToProUnits;
use App\service_nested_services;
use App\Test_branch_samples_branches;
use App\registered_serv_prices;
use App\registrations_details;
use App\registration_samples_barcodes;
use App\registration_samples_barcode_services;
use App\reg_samples_barcode_servs_test;
use App\result_clutuer_org_antis;
use App\result_clutuer_tests;
use App\registration_payment_transaction;
use App\registered_serv_ex_prices;
use App\company_infos;
use App\Branches;
use Hash;


use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExport;
use App\Imports\ExcelImport;

class SilentController extends Controller
{
    public $generalOptions=['footer-center'=>'[page]','footer-left'=>'All Rights Reseved © Dara Solutions','footer-right'=>'Powered by LMS www.dara.sd','header-right'=>'Printed date: [time] [date]','header-line'=>true,'footer-line'=>true,'footer-font-size'=>7,'header-font-size'=>7];

    public function printSampleDetails_Silent(Request $request)//this comes from patient new registration
    {
        $company_infos=company_infos::all()->first();
        $branch=Auth::user()->branch;

        $acc=request('acc');
        $registrations_details=registrations_details::where('acc', $acc)->first();//main data

        $registration_samples_barcodes=registration_samples_barcodes::where('acc', $acc)->get();
        $sample_date='';
        foreach ($registration_samples_barcodes as $key => $sample_id) {
            $sample_date=$sample_id->created_at;
            break;
        }

        $registration_samples_barcode_services=registration_samples_barcode_services::all();
        //get data
        $pdf = PDF::loadView('reports.silent.sampleDetails_Silent', compact('sample_date', 'registrations_details', 'registration_samples_barcode_services', 'registration_samples_barcodes', 'company_infos', 'branch'));
        $pdf->setOptions($this->generalOptions);
        $Printed_by='Printed by: '.(Auth::user()->full_name);
        $pdf->setOptions(['header-left'=>$Printed_by]);
        //file name
        $file_name='C:\LmsPrintTemp\samples\sample_Details_acc-'.$acc.'.pdf';
        //delete old file if exsist
        shell_exec('del '.$file_name);
        //save new file
        $pdf->save($file_name);

        //print file
        //get printer name
        $printers = file_get_contents("C:/LmsPrintTemp/printers.txt");
        $a4=explode(',', $printers);//a4 printer
        shell_exec('"C:\Program Files (x86)\Foxit Software\Foxit PDF Reader\FoxitPDFReader.exe" /t '.$file_name.' "'.$a4[0].'" "'.$a4[0].'"');
        //print sample id's bracode
        $this->reprint_sample_id($acc, null);
       
        //go to pay money
        return Redirect::to('SubmitPatientPayments?acc='.$acc);
        // return $pdf->stream();
    }

    public function show_reprint_sample_details(Type $var = null)
    {
        return view('tools.reprint_sample_details');
    }

    public function print_sample_details(Request $requests)
    {
        $company_infos=company_infos::all()->first();
        $branch=Auth::user()->branch;


        $Print_sample_id =0;
        $Print_sample_details = 0;
        if (isset($requests-> Print_sample_details)) {
            $Print_sample_details = 1;
        }

        if (isset($requests-> Print_sample_id)) {
            $Print_sample_id = 1;
        }

        $acc=$requests->ACC;
        $Sample_ID=$requests->Sample_ID;

        if ($Sample_ID) {
            $registration_samples_barcodes=registration_samples_barcodes::where('sample_barcode', $Sample_ID)->first();

            if ($registration_samples_barcodes) {
                $this->reprint_sample_id(null, $Sample_ID);
                return redirect()->back();
            } else {
                return back()->withErrors(['other11'=>'Sorry, No data found for this Sample ID.']);
            }
        } elseif ($acc) {
            $registrations_details=registrations_details::where('acc', $acc)->first();//main data

            if ($registrations_details) {
                if ($Print_sample_details == 1) {
                    $registration_samples_barcodes=registration_samples_barcodes::where('acc', $acc)->get();
                    $sample_date='';
                    foreach ($registration_samples_barcodes as $key => $sample_id) {
                        $sample_date=$sample_id->created_at;
                        break;
                    }

                    $registration_samples_barcode_services=registration_samples_barcode_services::all();
                    //get data
                    $pdf = PDF::loadView('reports.silent.sampleDetails_Silent', compact('sample_date', 'registrations_details', 'registration_samples_barcode_services', 'registration_samples_barcodes', 'company_infos', 'branch'));
                    $pdf->setOptions($this->generalOptions);
                    $Printed_by='Printed by: '.(Auth::user()->full_name);
                    $pdf->setOptions(['header-left'=>$Printed_by]);
                    //file name
                    $file_name='C:\LmsPrintTemp\samples\sample_Details_acc-'.$acc.'.pdf';
                    //delete old file if exsist
                    shell_exec('del '.$file_name);
                    //save new file
                    $pdf->save($file_name);
                    //print file
                    //get printer name
                    $printers = file_get_contents("C:/LmsPrintTemp/printers.txt");
                    $a4=explode(',', $printers);//a4 printer
                    shell_exec('"C:\Program Files (x86)\Foxit Software\Foxit PDF Reader\FoxitPDFReader.exe" /t '.$file_name.' "'.$a4[0].'" "'.$a4[0].'"');
                }
                if ($Print_sample_id == 1) {
                    $this->reprint_sample_id($acc, null);
                }
                return redirect()->back();
            } else {
                return back()->withErrors(['other11'=>'Sorry, No data found for this ACC.']);
            }
        } else {
            return back()->withErrors(['other11'=>'No data entered for search.']);
        }
    }

    public function reprint_sample_id($acc, $sample_id)
    {
        if ($acc) {
            $registrations_details=registrations_details::where('acc', $acc)->first();//main data
            $registration_samples_barcodes=registration_samples_barcodes::where('acc', $acc)->get();

            //get data
            $pdfWrapper = resolve(\Barryvdh\Snappy\PdfWrapper::class);
            $pdf1 = $pdfWrapper->loadView('reports.silent.print_sample_id', compact('registrations_details', 'registration_samples_barcodes'));

            //$pdf1 = PDF::loadView('reports.silent.print_sample_id', compact('registrations_details', 'registration_samples_barcodes'));
            $generalOptions=['page-size'=>'a9','orientation'=>'landscape','zoom'=>1,];
            $pdf1->setOptions($generalOptions);
            $pdf1->setOption('margin-bottom', 5);
            $pdf1->setOption('margin-left', 5);
            $pdf1->setOption('margin-right', 5);
            $pdf1->setOption('margin-top', 5);
            //file name
            $file_name='C:\LmsPrintTemp\samples\sample_id_acc-'.$acc.'.pdf';
            //delete old file if exsist
            shell_exec('del '.$file_name);
            //save new file
            $pdf1->save($file_name);
            //print file
            //get printer name
            $printers = file_get_contents("C:/LmsPrintTemp/printers.txt");
            $barcode=explode(',', $printers);//barcode printer
            shell_exec('"C:\Program Files (x86)\Foxit Software\Foxit PDF Reader\FoxitPDFReader.exe" /t '.$file_name.' "'.$barcode[1].'" "'.$barcode[1].'"');
            return null;
        }

        if ($sample_id) {
            $registration_samples_barcodes=registration_samples_barcodes::where('sample_barcode', $sample_id)->get();
            $registrations_details=registrations_details::where('acc', $registration_samples_barcodes[0]['acc'])->first();//main data
            //get data
            $pdf = PDF::loadView('reports.silent.print_sample_id', compact('registrations_details', 'registration_samples_barcodes'));
            $generalOptions=['page-size'=>'a9','orientation'=>'landscape','zoom'=>1,];
            $pdf->setOptions($generalOptions);
            $pdf->setOption('margin-bottom', 5);
            $pdf->setOption('margin-left', 5);
            $pdf->setOption('margin-right', 5);
            $pdf->setOption('margin-top', 5);
            //file name
            $file_name='C:\LmsPrintTemp\samples\sample_id_acc-'.$sample_id.'.pdf';
            //delete old file if exsist
            shell_exec('del '.$file_name);
            //save new file
            $pdf->save($file_name);
            //print file
            //get printer name
            $printers = file_get_contents("C:/LmsPrintTemp/printers.txt");
            $barcode=explode(',', $printers);//barcode printer
            shell_exec('"C:\Program Files (x86)\Foxit Software\Foxit PDF Reader\FoxitPDFReader.exe" /t '.$file_name.' "'.$barcode[1].'" "'.$barcode[1].'"');
            return null;
        }


        //return $pdf->stream();
    }

    //Results
    public function print_result_Silent(Request $request)
    {
        $acc=request('acc');
        $registrations_details=registrations_details::where('acc', $acc)->first();//main data

        $company_infos=company_infos::all()->first();
        $branch=Auth::user()->branch;

        //get job order services details
        //$patient_services = registered_serv_prices::where('acc', $acc)->Where('isCanceled', false)->get();
        $patient_services_final=[];
        $Culture_tests=[];
        $registration_samples_barcodes=registration_samples_barcodes::where('acc', $acc)->get();
        foreach ($registration_samples_barcodes as $key => $rsb) {
            //$this->show_sample_ids[]=$rsb->sample_barcode;
            //samples_barcode_status 

            //get only reviewd once service_status
            $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $rsb->id)->where('service_status', 'Reviewed')->get();
            foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                //get the services tests
                $rsbs_id=$registration_samples_barcode_service->id;
                $rsbsts=reg_samples_barcode_servs_test::where('rsbs_id', $rsbs_id)->get();
                //saparate cultuer test form other tests
                $rsbsts1=$rsbsts;

                foreach ($rsbsts1 as $key => $rsbst) {
                    if ($rsbst->test->test_type=='Culture') {
                        $Culture_tests[]=$rsbst;
                        unset($rsbsts[$key]);
                    }
                }
                if (count($rsbsts)>0) {
                    $x=['service_tests'=>$rsbsts,'clinical_unit'=>$registration_samples_barcode_service->service->clinical_unit->name_en];
                    $service_tests[]=$x;
                }
            }
        }
        $result_clutuer_tests= result_clutuer_tests::all();
        $result_clutuer_org_antis= result_clutuer_org_antis::all();

        $patient_services_final = collect($service_tests)->groupBy('clinical_unit');
        $pdf = PDF::loadView('reports.silent.print_result_Silent', compact('registrations_details', 'patient_services_final', 'Culture_tests', 'result_clutuer_tests', 'result_clutuer_org_antis', 'company_infos', 'branch'));
        $pdf->setOptions($this->generalOptions);
        $Printed_by='Printed by: '.(Auth::user()->full_name);
        $pdf->setOptions(['header-left'=>$Printed_by]);
        $pdf->setOption('images', true);

        //file name
        $file_name='C:\LmsPrintTemp\results\patient_result_acc-'.$acc.'.pdf';

        //delete old file if exsist
        shell_exec('del /f '.$file_name);

        //save new file
        $pdf->save($file_name);
        //print file
        //get printer name
        $printers = file_get_contents("C:/LmsPrintTemp/printers.txt");
        $a4=explode(',', $printers);//a4 printer
        shell_exec('"C:\Program Files (x86)\Foxit Software\Foxit PDF Reader\FoxitPDFReader.exe" /t '.$file_name.' "'.$a4[0].'" "'.$a4[0].'"');
        return redirect()->back();
        //return $pdf->stream();
    }

    public function download_result(Request $request)
    {
        $acc=request('acc');

        $company_infos=company_infos::all()->first();
        $branch=Auth::user()->branch;

        $registrations_details=registrations_details::where('acc', $acc)->first();//main data
        //get job order services details
        //$patient_services = registered_serv_prices::where('acc', $acc)->Where('isCanceled', false)->get();
        $patient_services_final=[];
        $Culture_tests=[];
        $service_tests=[];
        $registration_samples_barcodes=registration_samples_barcodes::where('acc', $acc)->get();
        foreach ($registration_samples_barcodes as $key => $rsb) {
            //$this->show_sample_ids[]=$rsb->sample_barcode;
            //samples_barcode_status
            
             //get only reviewd once service_status
            $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $rsb->id)->where('service_status', 'Reviewed')->get();
            foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                //get the services tests
                $rsbs_id=$registration_samples_barcode_service->id;
                $rsbsts=reg_samples_barcode_servs_test::where('rsbs_id', $rsbs_id)->get();
                //saparate cultuer test form other tests
                $rsbsts1=$rsbsts;

                foreach ($rsbsts1 as $key => $rsbst) {
                    if ($rsbst->test->test_type=='Culture') {
                        $Culture_tests[]=$rsbst;
                        unset($rsbsts[$key]);
                    }
                }
                if (count($rsbsts)>0) {
                    $x=['service_tests'=>$rsbsts,'clinical_unit'=>$registration_samples_barcode_service->service->clinical_unit->name_en];
                    $service_tests[]=$x;
                }
            }
        }
        $result_clutuer_tests= result_clutuer_tests::all();
        $result_clutuer_org_antis= result_clutuer_org_antis::all();

        $patient_services_final = collect($service_tests)->groupBy('clinical_unit');

        $pdf = PDF::loadView('reports.silent.print_result_Silent', compact('registrations_details', 'patient_services_final', 'Culture_tests', 'result_clutuer_tests', 'result_clutuer_org_antis', 'company_infos', 'branch'));

        $pdf->setOptions($this->generalOptions);
        $Printed_by='Printed by: '.(Auth::user()->full_name);
        $pdf->setOptions(['header-left'=>$Printed_by]);
        $pdf->setOption('images', true);
        //file name
        $file_name='patient_result acc-'.$acc.'.pdf';
        //save new file

        return $pdf->download($file_name);
    }


    public function view_clinic_result(Request $request)
    {
       
        $clinic_trans_no=$request->clinic_trans_no;
        $can_print_result=$this->can_print_result($clinic_trans_no);
        if (!$can_print_result['can_print_result']) {
            $error_msg=$can_print_result['error_msg'];

            $pdf = PDF::loadView('reports.silent.result_error', compact('error_msg'));

            $pdf->setOptions($this->generalOptions);
            $Printed_by='Printed by: '.(Auth::user()->full_name);
            $pdf->setOptions(['header-left'=>$Printed_by]);
            $pdf->setOption('images', true);

            return $pdf->stream();
        } else {
            $acc=$can_print_result['acc'];

            $company_infos=company_infos::all()->first();
            $branch=Auth::user()->branch;

            $registrations_details=registrations_details::where('acc', $acc)->first();//main data
            //get job order services details
            //$patient_services = registered_serv_prices::where('acc', $acc)->Where('isCanceled', false)->get();
            $patient_services_final=[];
            $Culture_tests=[];
            $service_tests=[];
            $registration_samples_barcodes=registration_samples_barcodes::where('acc', $acc)->get();
            foreach ($registration_samples_barcodes as $key => $rsb) {
                //$this->show_sample_ids[]=$rsb->sample_barcode;
                //samples_barcode_status
                $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $rsb->id)->get();
                foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                    //get the services tests
                    $rsbs_id=$registration_samples_barcode_service->id;
                    $rsbsts=reg_samples_barcode_servs_test::where('rsbs_id', $rsbs_id)->get();
                    //saparate cultuer test form other tests
                    $rsbsts1=$rsbsts;

                    foreach ($rsbsts1 as $key => $rsbst) {
                        if ($rsbst->test->test_type=='Culture') {
                            $Culture_tests[]=$rsbst;
                            unset($rsbsts[$key]);
                        }
                    }
                    if (count($rsbsts)>0) {
                        $x=['service_tests'=>$rsbsts,'clinical_unit'=>$registration_samples_barcode_service->service->clinical_unit->name_en];
                        $service_tests[]=$x;
                    }
                }
            }
            $result_clutuer_tests= result_clutuer_tests::all();
            $result_clutuer_org_antis= result_clutuer_org_antis::all();

            $patient_services_final = collect($service_tests)->groupBy('clinical_unit');

            $pdf = PDF::loadView('reports.silent.print_result_Silent', compact('registrations_details', 'patient_services_final', 'Culture_tests', 'result_clutuer_tests', 'result_clutuer_org_antis', 'company_infos', 'branch'));

            $pdf->setOptions($this->generalOptions);
            $Printed_by='Printed by: '.(Auth::user()->full_name);
            $pdf->setOptions(['header-left'=>$Printed_by]);
            $pdf->setOption('images', true);

            return $pdf->stream();
        }
    }

    public function can_print_result($clinic_trans_no)
    {
        $can_print_result=false;

        $registration_details = registrations_details::where('clinic_trans_no', $clinic_trans_no)->first();
        

        if ($registration_details) {
            $Delivery_Details_ACC=$registration_details->acc;
            //get Patient details
            $patient_data = registrations::where('id', $registration_details->patient_id)->first();

            //get job order services details
            $patient_services = registered_serv_prices::where('acc', $Delivery_Details_ACC)->Where('isCanceled', false)->get();

            //calculate the total job order amount
            $total_amout=0;
            foreach ($patient_services as $key => $patient_service) {
                $total_amout=$total_amout+$patient_service['current_price'];
            }

            $flag=0;
            $registration_samples_barcodes=registration_samples_barcodes::where('acc', $Delivery_Details_ACC)->get();
            foreach ($registration_samples_barcodes as $key => $rsb) {
                $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $rsb->id)->get();
                foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                    if ($flag==0 && $registration_samples_barcode_service->service_status!=='Reviewed') {
                        $can_print_result=false;
                        $flag=1;
                    }
                    $rsbs_id=$registration_samples_barcode_service->id;
                    $x=['service'=>$registration_samples_barcode_service,'clinical_unit'=>$registration_samples_barcode_service->service->clinical_unit->name_en];
                    $patient_services[]=$x;
                }
            }
    
            $error_msg='';
            if ($flag!==0) {
                $can_print_result=false;
                $error_msg="Sorry, the patient result is not ready.";
            // session()->flash('Error', "Sorry, the patient result is not ready.");
            } elseif ($registration_details->remaining>0) {
                $can_print_result=false;
                $error_msg="Sorry, this patient should pay the remaining money.";
            ///session()->flash('Error', "Sorry, this patient should pay the remaining money.");
            } else {
                $can_print_result=true;
            }
    
            return ["can_print_result"=>$can_print_result,"acc"=>$Delivery_Details_ACC,"error_msg"=>$error_msg];

        }else{
            $error_msg="Sorry, no examinations registered for this patient.";
            return ["can_print_result"=>false,"error_msg"=>$error_msg];
        }
       
    }

    public function View_Receipt_List(Request $request)//this comes from patient new registration
    {
        $payment_method=request('payment_method');
        $transaction_type=request('transaction_type');
        $branch_id=request('branch_id');
        $Created_by=request('selected_user_id');
        $dateFrom=request('dateFrom');
        $dateTo=request('dateTo');

        
        $x=['transaction_type'=>$transaction_type,'payment_method'=> $payment_method,'branch_id'=> $branch_id,'Created_by'=>$Created_by];

        if ($dateFrom) {
            if (!$dateTo) {
                return "<b style='color: red'>Reg. date field (To) is empty.</b>";
            }
        } else {
            return "<b style='color: red'>Reg. date field (From) is empty.</b>";
        }

        $dateFrom=Carbon::parse(Carbon::parse($dateFrom)->toDateString())->format('Y-m-d');
        $time = strtotime($dateFrom);
        $dateFrom = date('Y-m-d 00:00', $time);

        $dateTo=Carbon::parse(Carbon::parse($dateTo)->toDateString())->format('Y-m-d');
        $time1 = strtotime($dateTo);
        $dateTo = date('Y-m-d 23:59', $time1);

        if (!$transaction_type) {
            unset($x['transaction_type']);
        }
        if (!$payment_method) {
            unset($x['payment_method']);
        }
        if (!$branch_id) {
            unset($x['branch_id']);
        }
        if (!$Created_by) {
            unset($x['Created_by']);
        }
        $registration_payment_transaction=registration_payment_transaction::whereBetween('created_at', [$dateFrom, $dateTo])->Where('payment_method', '<>', '-')->where($x)->get()->groupBy('payment_method');

        $registrations_details_all=registrations_details::all();
        $registrations_all=registrations::all();

        $pdf = PDF::loadView('reports.silent.view_receipt_list', compact('dateTo', 'dateFrom', 'registration_payment_transaction', 'registrations_details_all', 'registrations_all'));
        $pdf->setOptions($this->generalOptions);
        $pdf->setOptions(['orientation'=>'landscape']);
        $Printed_by='Printed by: '.(Auth::user()->full_name);
        $pdf->setOptions(['header-left'=>$Printed_by]);

        return $pdf->stream();
    }

    public function View_Patient_Last_Results(Request $request)//this comes from patient new registration
    {
        $current_tests=request('current_tests');
        $current_tests = unserialize(urldecode($current_tests));
        $patient_id=request('patient_id');
        $patient_name='';

        //get patient ACC's
        $registrations_details=registrations_details::where('patient_id', $patient_id)->get();
        $sample_barcodes_ids=[];
        $last_tests_results=[];
        $last_tests_results_header=[];

        foreach ($registrations_details as $key => $registrations_detail) {
            $patient_name=$registrations_detail->patient->patient_name;
            $registration_samples_barcodes= registration_samples_barcodes::where('acc', $registrations_detail->acc)->get();
            foreach ($registration_samples_barcodes as $key => $registration_samples_barcode) {
                $sample_barcodes_ids[]= $registration_samples_barcode->id;
            }
        }

        foreach ($sample_barcodes_ids as  $samples_barcode_id) {
            $rsbs_ids=  registration_samples_barcode_services::where('samples_barcode_id', $samples_barcode_id)->get();
            foreach ($rsbs_ids as $key => $rsbs) {
                foreach ($current_tests as $key => $current_test) {
                    $last_test=reg_samples_barcode_servs_test::where('rsbs_id', $rsbs->id)->where('test_id', $current_test)->first();
                    //->where('id', '<>', $current_tests->id)
                    if ($last_test) {
                        $last_tests_results[]=$last_test;
                        $last_tests_results_header[]=$last_test;
                    }
                }
            }
        }

        $last_tests_results = collect($last_tests_results)->groupBy('test_id');
        $last_tests_results_header = collect($last_tests_results_header)->groupBy(function ($item, $key) {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('Y-m-d H:i:s');
        });

        $pdf = PDF::loadView('reports.silent.view_patient_last_results', compact('last_tests_results_header', 'last_tests_results', 'patient_name'));
        $pdf->setOptions($this->generalOptions);
        $pdf->setOptions(['orientation'=>'landscape']);
        $Printed_by='Printed by: '.(Auth::user()->full_name);
        $pdf->setOptions(['header-left'=>$Printed_by]);

        return $pdf->stream();
    }


    public function Reprint_Receipt_number(Request $request)//this comes from patient new registration
    {
        $ACC=request('acc');
        $redirect=request('redirect');
        $company_infos=company_infos::all()->first();
        $branch=Auth::user()->branch;

        //get job order details be ACC
        $registration_details = registrations_details::where('acc', $ACC)->first();
        if ($registration_details) {
            //get Patient details

            //get job order services details ->Where('isCanceled', false)
            $patient_services = registered_serv_prices::where('acc', $ACC)->get();
            //get job order services details ->Where('isCanceled', false)
            $patient_extra_services = registered_serv_ex_prices::where('acc', $ACC)->get();

            //get job order payment transactions details
            $registration_payment_transaction=registration_payment_transaction::where('acc', $ACC)->orderBy('id', 'DESC')->get();



            $pdf = PDF::loadView('reports.silent.Reprint_Receipt_number', compact('registration_details', 'patient_services', 'patient_extra_services', 'registration_payment_transaction', 'company_infos', 'branch'));
            $pdf->setOptions($this->generalOptions);
            $Printed_by='Printed by: '.(Auth::user()->full_name);
            $pdf->setOptions(['header-left'=>$Printed_by]);

            //file name
            $file_name='C:\LmsPrintTemp\Receipt_number\Receipt_number_acc-'.$ACC.'.pdf';

            //delete old file if exsist
            shell_exec('del /f '.$file_name);

            //save new file
            $pdf->save($file_name);
            //print file
            //get printer name
            $printers = file_get_contents("C:/LmsPrintTemp/printers.txt");
            $a4=explode(',', $printers);//a4 printer
            shell_exec('"C:\Program Files (x86)\Foxit Software\Foxit PDF Reader\FoxitPDFReader.exe" /t '.$file_name.' "'.$a4[0].'" "'.$a4[0].'"');
            if (!$redirect) {
                // return redirect()->back();
               // return $pdf->stream();
               return null;
            } else {
                return Redirect::to('registration');
            }
        } else {
            return "<b style='color: red'>Wrong payment details..</b>";
        }
    }

    public function View_Financial_Claim(Request $request)//this comes from patient new registration
    {
        $current_tests=request('excluded_services');
        $excluded_services = unserialize(urldecode($current_tests));

        $payer_id=request('payer_id');
        $branch_id=request('branch_id');
        $contract_id=request('contract_id');
        $dateFrom=request('date_from');
        $dateTo=request('date_To');

        $x=['payer_id'=> $payer_id,'branch_id'=> $branch_id,'contract_id'=>$contract_id];

        if (!$branch_id) {
            unset($x['branch_id']);
        }
        if (!$contract_id) {
            unset($x['contract_id']);
        }
        if (!$payer_id) {
            unset($x['payer_id']);
        }

        $dateFrom=Carbon::parse(Carbon::parse($dateFrom)->toDateString())->format('Y-m-d');
        $time = strtotime($dateFrom);
        $dateFrom = date('Y-m-d 00:00', $time);

        $dateTo=Carbon::parse(Carbon::parse($dateTo)->toDateString())->format('Y-m-d');
        $time1 = strtotime($dateTo);
        $dateTo = date('Y-m-d 23:59', $time1);
        
        $registered_serv_prices=registered_serv_prices::all();
        $registration_details=registrations_details::whereBetween('created_at', [$dateFrom, $dateTo])->Where($x)->whereNotIn('id', $excluded_services)->get();

        $pdf = PDF::loadView('reports.silent.View_Financial_Claim', compact('contract_id', 'dateTo', 'dateFrom', 'registration_details', 'registered_serv_prices'));
        $pdf->setOptions($this->generalOptions);
        $pdf->setOptions(['orientation'=>'landscape']);
        $Printed_by='Printed by: '.(Auth::user()->full_name);
        $pdf->setOptions(['header-left'=>$Printed_by]);

        return $pdf->stream();
    }

    public function View_Financial_Brief(Request $request)//this comes from patient new registration
    {
        $current_tests=request('excluded_services');
        $excluded_services = unserialize(urldecode($current_tests));

        $payer_id=request('payer_id');
        $branch_id=request('branch_id');
        $contract_id=request('contract_id');
        $dateFrom=request('date_from');
        $dateTo=request('date_To');

        $x=['payer_id'=> $payer_id,'branch_id'=> $branch_id,'contract_id'=>$contract_id];

        if (!$branch_id) {
            unset($x['branch_id']);
        }
        if (!$contract_id) {
            unset($x['contract_id']);
        }
        if (!$payer_id) {
            unset($x['payer_id']);
        }

        $dateFrom=Carbon::parse(Carbon::parse($dateFrom)->toDateString())->format('Y-m-d');
        $time = strtotime($dateFrom);
        $dateFrom = date('Y-m-d 00:00', $time);

        $dateTo=Carbon::parse(Carbon::parse($dateTo)->toDateString())->format('Y-m-d');
        $time1 = strtotime($dateTo);
        $dateTo = date('Y-m-d 23:59', $time1);
        
        $registered_serv_prices=registered_serv_prices::all();
        $registration_details=registrations_details::whereBetween('created_at', [$dateFrom, $dateTo])->Where($x)->whereNotIn('id', $excluded_services)->get();

        $pdf = PDF::loadView('reports.silent.View_Financial_Brief', compact('contract_id', 'dateTo', 'dateFrom', 'registration_details', 'registered_serv_prices'));
        $pdf->setOptions($this->generalOptions);
        $pdf->setOptions(['orientation'=>'landscape']);
        $Printed_by='Printed by: '.(Auth::user()->full_name);
        $pdf->setOptions(['header-left'=>$Printed_by]);

        return $pdf->stream();
    }


    public function service_income_report(Request $request)//this comes from patient new registration
    {
        $Branches=Branches::all();
        $Services=Services::all();
        $Payers=Payers::all();

        return view('reports.service_income_report', compact('Branches', 'Services', 'Payers'));
    }

    public function get_payer_contract_list(Request $request)//this comes from patient new registration
    {
        $payer_contracts=payer_contracts::where('payer_id', $request->payer_id)->get();
        return $payer_contracts;
    }


    public function view_service_income_report(Request $request)//this comes from patient new registration
    {
        $payer_id=request('payer_id');
        $branch_id=request('branch_id');
        $contract_id=request('contract_id');
        $dateFrom=request('dateFrom');
        $dateTo=request('dateTo');
        $services_ids=request('services_ids');

        if ($dateTo && $dateFrom) {
            $dateFrom=Carbon::parse(Carbon::parse($dateFrom)->toDateString())->format('Y-m-d');
            $dateTo=Carbon::parse(Carbon::parse($dateTo)->toDateString())->format('Y-m-d');
            $time = strtotime($dateFrom);
            $time2 = strtotime($dateTo);
            $dateFrom = date('Y-m-d 00:00', $time);
            $dateTo = date('Y-m-d 23:59', $time2);


            $x=['payer_id'=> $payer_id,'branch_id'=> $branch_id,'contract_id'=>$contract_id];

            if (!$branch_id) {
                unset($x['branch_id']);
            }
            if (!$contract_id) {
                unset($x['contract_id']);
            }
            if (!$payer_id||$payer_id=='all') {
                unset($x['payer_id']);
            }

            $registered_serv_prices=[];
            $payer_name='all';
            $branch_name='all';
            $contract_name='all';
            $services_names=['all'];

            if ($services_ids) {
                $services_names=[];
                $Services= Services::whereIn('id', $services_ids)->get('name_en');
                foreach ($Services as $key => $Service) {
                    $services_names[]=$Service->name_en;
                }
            }

            $registration_details=registrations_details::whereBetween('created_at', [$dateFrom, $dateTo])->where($x)->get();


            if (count($registration_details)>0) {
                if ($branch_id) {
                    $branch_name=$registration_details[0]->branch->name_en;
                }
                if ($contract_id) {
                    $contract_name=$registration_details[0]->payer_contract->name_en;
                }
                if ($payer_id) {
                    $payer_name=$registration_details[0]->payer->name_en;
                }
                // $registration_details = $registration_details->groupBy('branch_id');
            }


            if ($services_ids && count($registration_details)>0) {
                foreach ($registration_details as $key => $value) {
                    $acc=$value->acc;
                    $rsp=registered_serv_prices::where('acc', $acc)->whereIn('service_id', $services_ids)->where('isCanceled', 0)->get();
                    if (count($rsp)>0) {
                        foreach ($rsp as $key => $value) {
                            $registered_serv_prices[]=$value;
                        }
                    }
                }
            } elseif (count($registration_details)>0) {
                $services_names=['all'];
                foreach ($registration_details as $key => $value) {
                    $acc=$value->acc;
                    $rsp=registered_serv_prices::where('acc', $acc)->where('isCanceled', 0)->get();
                    if (count($rsp)>0) {
                        foreach ($rsp as $key => $value) {
                            $registered_serv_prices[]=$value;
                        }
                    }
                }
            }
            $rsp_ids=[];
            foreach ($registered_serv_prices as $key => $value) {
                $rsp_ids[]=$value->id;
            }
            // $collection =registered_serv_prices::groupBy('service_id')->selectRaw('count(*) as total, service_id')->get();
            $rsp_collection =registered_serv_prices::whereIn('id', $rsp_ids)->groupBy('service_id')->selectRaw('count(*) as service_count, service_id')->selectRaw('SUM(service_price_cash) as Cash')->selectRaw('SUM(service_price_credit) as Credit')->get();
            //dd($rsp_collection[0]->service);

            return view('reports.service_income_result', compact('registration_details', 'rsp_collection', 'dateFrom', 'dateTo', 'payer_name', 'branch_name', 'contract_name', 'services_names'));
        } else {
            session()->flash('Error', 'Date From and TO is required.');
            return redirect()->back();
        }
    }


    public function patients_income_report(Request $request)//this comes from patient new registration
    {
        $Branches=Branches::all();
        return view('reports.patients_income_report', compact('Branches'));
    }


    public function view_patients_income_report(Request $request)//this comes from patient new registration
    {
        $branch_id=request('branch_id');
        $dateFrom=request('dateFrom');
        $dateTo=request('dateTo');

        if ($dateTo && $dateFrom) {
            $dateFrom=Carbon::parse(Carbon::parse($dateFrom)->toDateString())->format('Y-m-d');
            $dateTo=Carbon::parse(Carbon::parse($dateTo)->toDateString())->format('Y-m-d');
            $time = strtotime($dateFrom);
            $time2 = strtotime($dateTo);
            $dateFrom = date('Y-m-d 00:00', $time);
            $dateTo = date('Y-m-d 23:59', $time2);


            $x=['branch_id'=> $branch_id];

            if (!$branch_id) {
                unset($x['branch_id']);
            }
            
            $registered_serv_prices=[];
            $branch_name='all';
            $service_count_total=0;

            $registration_details=registrations_details::whereBetween('created_at', [$dateFrom, $dateTo])->where($x)->get();

            

           if (count($registration_details)>0) {
            if ($branch_id) {
                $branch_name=$registration_details[0]->branch->name_en;
            }
                foreach ($registration_details as $key => $value) {
                    $acc=$value->acc;
                    $rsp=registered_serv_prices::where('acc', $acc)->where('isCanceled', 0)->get();
                    if (count($rsp)>0) {
                        foreach ($rsp as $key => $value) {
                            $service_count_total++;
                            $registered_serv_prices[]=$value;
                        }
                    }
                }
            }
            $registered_serv_prices=collect($registered_serv_prices);
           
           // $rsp_collection =registered_serv_prices::whereIn('id', $rsp_ids)->groupBy('service_id')->selectRaw('count(*) as service_count, service_id')->selectRaw('SUM(service_price_cash) as Cash')->selectRaw('SUM(service_price_credit) as Credit')->get();

            return view('reports.patients_income_result', compact('registration_details', 'registered_serv_prices', 'dateFrom', 'dateTo',  'branch_name','service_count_total'));
        } else {
            session()->flash('Error', 'Date From and TO is required.');
            return redirect()->back();
        }
    }

    public static function get_hash_clinic(Request $request)
    {
        return  Hash::make($request->pass_has);
    }


   

    public function header_paper(Request $request)
    {
        return view('reports.header_paper');
    }

    public function view_header_paper(Request $request)
    {
        $company_infos=company_infos::all()->first();
        $content=$request->content;
        $title=$request->title;
        $dateFrom=$request->dateFrom;
        
        $dateFrom=Carbon::parse(Carbon::parse($dateFrom)->toDateString())->format('Y-m-d');
        $time = strtotime($dateFrom);
        $dateFrom = date('Y-m-d', $time);
        
        $pdf = PDF::loadView('reports.silent.header_paper_Silent', compact('company_infos', 'dateFrom','content','title'));

        $pdf->setOptions($this->generalOptions);
       // $Printed_by='Printed by: '.(Auth::user()->full_name);
        //$pdf->setOptions(['header-left'=>$Printed_by]);
        $pdf->setOption('images', true);
        //file name
        $file_name='header_paper.pdf';
        //save new file download

        return $pdf->stream($file_name);
    }
    

}
