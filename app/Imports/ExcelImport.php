<?php

namespace App\Imports;

use App\Services;
use App\Price_list_services;
use App\Price_lists;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class ExcelImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $selected_price_list_id;
    public function __construct($selected_price_list_id)
    {
        $this->selected_price_list_id = $selected_price_list_id;
    }

    
    public function collection(Collection $rows)
    {
        $validator=  Validator::make($rows->toArray(), [
            '*.2' => 'required',
            '*.3' => 'required',
            '*.5' => 'required',
        ]);
       
        if ($validator->fails()) {
            return back()->withErrors(["other10"=>"Sorry, Something is wrong with this file (file format is change)!"]);
        } else {
            //file strcution id right
            $i=0;
            foreach ($rows as $row) {
                if ($i!==0) {
                    if ($row[3]!=='-') {//normal service
                        price_list_services::create([
                            'service_id' => $row[3],
                            'price_list_id' => $this->selected_price_list_id,
                            'current_price' => $row[5],
                            'ex_code'   => '-',
                            'Created_by' => (Auth::user()->name),
                        ]);
                    } else {//extra service
                        price_list_services::create([
                            'service_id' => 0,
                            'ex_code'   => $row[2],
                            'price_list_id' => $this->selected_price_list_id,
                            'current_price' => $row[5],
                            'Created_by' => (Auth::user()->name),
                        ]);
                    }
                } else {//check if file header not change
                    if ($row[0]!=='Active'||$row[1]!=='Code'||$row[2]!=='ex_code'||$row[3]!=='Service_id'||$row[4]!=='Name'||$row[5]!=='Fee') {
                        return back()->withErrors(["other10"=>"Sorry, Something is wrong with this file (header format is change)!"]);
                        break;
                    } else {
                        //delete all old prices on the previous price list
                        price_list_services::where('price_list_id', $this->selected_price_list_id)->delete();
                    }
                }
                $i++;
            }
        }
    }
}
