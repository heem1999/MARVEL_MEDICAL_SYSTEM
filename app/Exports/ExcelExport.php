<?php

namespace App\Exports;

use App\Services;
use App\Price_list_services;
use App\Price_lists;
use App\extra_services;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExport implements FromCollection, WithHeadings
{
    use Exportable;
    private $selected_price_list_id;
    public function __construct($selected_price_list_id)
    {
        $this->selected_price_list_id = $selected_price_list_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $services = services::all(); //service not have price
        $extra_services = extra_services::all();
        $extra_services_all = extra_services::all();

        $price_list = price_lists::where('id', $this->selected_price_list_id)->first();
        $price_list_services = price_list_services::where('price_list_id', $this->selected_price_list_id)->get();
     
        if (count($price_list_services)>0) {//their is service have price
            $services1=$services;
            foreach ($price_list_services as $key2 => $price_list_service) {
                if ($price_list_service->service_id>0) {//if extra service have price
                    foreach ($services1 as $key => $service) {
                        if ($price_list_service->service->id==$service->id) {
                            unset($services[$key]);
                        }
                    }
                }
            }
        }

        if (count($price_list_services)>0) {//their is service have price
            $extra_services1=$extra_services;
            foreach ($price_list_services as $key2 => $price_list_service) {
                if ($price_list_service->ex_code) {//if extra service have price
                    foreach ($extra_services1 as $key => $extra_service) {
                        if ($price_list_service->ex_code==$extra_service->ex_code) {
                            unset($extra_services[$key]);
                        }
                    }
                }
            }
        }

        $customer_array = array();

        //the price lis contain prices
        foreach ($price_list_services as $price_list_service) {
            if ($price_list_service->service_id>0) {
                $customer_array[] = [
                    'Active'  =>  $price_list_service->service->active,
                    'Code'   => $price_list_service->service->code,
                    'ex_code'   => '-',
                    'Service_id'   => $price_list_service->service->id,
                    'Name'   => $price_list_service->service->name_en,
                    'Fee'   => $price_list_service->current_price,
                ];
            } elseif ($price_list_service->ex_code!=='-') {
                $customer_array[] = [
                    'Active'  =>  $extra_services_all->where('ex_code', $price_list_service->ex_code)->first()->active,
                    'Code'   => '-',
                    'ex_code'   => $price_list_service->ex_code,
                    'Service_id'   => '-',
                    'Name'   =>$extra_services_all->where('ex_code', $price_list_service->ex_code)->first()->name_en,
                    'Fee'   => $price_list_service->current_price,
                ];
            }
        }
       
       
        //rest of service that not have prices
        foreach ($services as $service) {
            $customer_array[] =[
        'Active'  => $service->active,
        'Code'   => $service->code,
        'ex_code'   => '-',
        'Service_id'   => $service->id,
        'Name'    => $service->name_en,
        'Fee'  => '0',
            ];
        }

        //rest of service that not have prices
        foreach ($extra_services as $service) {
            $customer_array[] = [
        'Active'  => $service->active,
        'Code'   => '-',
        'ex_code'   => $service->ex_code,
        'Service_id'   => '-',
        'Name'    => $service->name_en,
        'Fee'  => '0',
             ];
        }
         
        return  collect($customer_array);
    }

    public function headings() :array
    {
        return ['Active', 'Code','ex_code', 'Service_id', 'Name', 'Fee'];
    }
}
