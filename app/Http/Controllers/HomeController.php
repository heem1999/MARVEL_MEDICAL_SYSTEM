<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\invoices;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;
use App\AppBooking;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $AppBooking = AppBooking::all();
        $booking_status=[0=>"UNDER REVIEWING",1=>"Confirmed",2=>"Approved",3=>"Processing",4=>"Collected",5=>"Completed",6=>"Canceled",7=>"Rejected",];

//=================احصائية نسبة تنفيذ الحالات======================

if(Auth::user()->user_titile&&Auth::user()->doctor_id){
           
    return redirect()->to('http://192.168.43.138:8000/clinic/');
}elseif(Auth::user()->user_titile=='pharmacy'){
    
    return redirect()->to('http://192.168.43.138:8000/clinic/');
}else{
    
    return view('Dashboard.Dashboard', compact('AppBooking','booking_status'));
}
   /*

        $count_all =invoices::count();
        $count_invoices1 = invoices::where('Value_Status', 1)->count();
        $count_invoices2 = invoices::where('Value_Status', 2)->count();
        $count_invoices3 = invoices::where('Value_Status', 3)->count();
        return view('Dashboard.Dashboard');
        
     
              if($count_invoices2 == 0){
                  $nspainvoices2=0;
              }
              else{
                  $nspainvoices2 = $count_invoices2/ $count_all*100;
              }

                if($count_invoices1 == 0){
                    $nspainvoices1=0;
                }
                else{
                    $nspainvoices1 = $count_invoices1/ $count_all*100;
                }

                if($count_invoices3 == 0){
                    $nspainvoices3=0;
                }
                else{
                    $nspainvoices3 = $count_invoices3/ $count_all*100;
                }


                $chartjs = app()->chartjs
                    ->name('barChartTest')
                    ->type('bar')
                    ->size(['width' => 350, 'height' => 200])
                    ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
                    ->datasets([
                        [
                            "label" => "الفواتير الغير المدفوعة",
                            'backgroundColor' => ['#ec5858'],
                            'data' => [$nspainvoices2]
                        ],
                        [
                            "label" => "الفواتير المدفوعة",
                            'backgroundColor' => ['#81b214'],
                            'data' => [$nspainvoices1]
                        ],
                        [
                            "label" => "الفواتير المدفوعة جزئيا",
                            'backgroundColor' => ['#ff9642'],
                            'data' => [$nspainvoices3]
                        ],


                    ])
                    ->options([]);


                $chartjs_2 = app()->chartjs
                    ->name('pieChartTest')
                    ->type('pie')
                    ->size(['width' => 340, 'height' => 200])
                    ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
                    ->datasets([
                        [
                            'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                            'data' => [$nspainvoices2, $nspainvoices1,$nspainvoices3]
                        ]
                    ])
                    ->options([]);

                return view('home', compact('chartjs','chartjs_2'));
        */
    }

    public function clinic()
    {
        $user_id=Auth::user()->id;
        return redirect()->to('http://192.168.43.138/clinic/index.php?user_session='. $user_id);
    }

    public function perform()
    {
        Session::flush();
        
        Auth::logout();

        return redirect('/');
    }
}