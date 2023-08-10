<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services;
use App\Price_list_services;
use App\Price_lists;
use App\extra_services;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExport;
use App\Imports\ExcelImport;

class PriceListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $price_lists = price_lists::all();

        return view('administration.financial.price_lists.price_lists', compact('price_lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_en' => 'required|unique:price_lists|max:255',
            'code' => 'required|unique:price_lists|max:255',
        ], [
            'name_en.unique' =>'Sorry, Price list name already exist.',
            'name_en.required' =>'Sorry, Price list name is required.',
            'code.unique' =>'Sorry, Price list code already exist.',
            'code.required' =>'Sorry, Price list code is required.',
        ]);

        price_lists::create([
                'name_en' => $request->name_en,
                'code' => $request->code,
                'Created_by' => (Auth::user()->name),
            ]);
        session()->flash('Add', 'Price list add successfully!! ');
        return redirect('/price_lists');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Price_lists  $price_lists
     * @return \Illuminate\Http\Response
     */
    public function show(Price_lists $price_lists)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Price_lists  $price_lists
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $services = services::all(); //service not have price
        $extra_services = extra_services::all(); //service not have price
        $extra_services_all = extra_services::all(); //service not have price
        
        $price_list = price_lists::where('id', $id)->first();
        $price_list_services = price_list_services::where('price_list_id', $id)->get();
        
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
        return view('administration.financial.price_lists.edit_price_list', compact('price_list', 'price_list_services', 'services', 'extra_services','extra_services_all'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Price_lists  $price_lists
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Price_lists $price_lists)
    {
        $price_lists = price_lists::findOrFail($request->price_list_id);

        $validatedData = $request->validate([
            'name_en' => 'required:price_lists|max:255',
            'code' => 'required:price_lists|max:255',
        ], [
            'name_en.required' =>'Price list name is required.',
            'code.required' =>'Price list code is required.',
        ]);

        //check if code or service name is already exist
        $price_list_name_en = price_lists::where('name_en', $request->name_en)->where('id', '<>', $request->price_list_id)->get();
        $price_list_code = price_lists::where('code', $request->code)->where('id', '<>', $request->price_list_id)->get();

        if (count($price_list_name_en)>0) {
            return back()->withErrors(["other10"=>"Sorry, Price list name $request->name_en is already exist."]);
        } elseif (count($price_list_code)>0) {
            return back()->withErrors(['other10'=>'Sorry, Price list code already used, use another code.']);
        } else {
            $price_lists->update([
                'name_en' => $request->name_en,
                'code' => $request->code,
                'Created_by' => (Auth::user()->name),
        ]);
            session()->flash('Edit', 'Price list edit successfully!!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Price_lists  $price_lists
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Price_lists $price_lists)
    {
        $id = $request->price_list_data_id;
        price_lists::find($id)->delete();
        price_list_services::where('price_list_id', $id)->delete();
        session()->flash('delete', 'Price list deleted successfully!!');
        return redirect('/price_lists');
    }


    public function edit_service_price(Request $request, price_list_services $price_list_services)
    {
        $price_list_services = price_list_services::where('price_list_id', $request->price_list_id)->where('service_id', $request->service_id)->get();
        
        if (count($price_list_services)>0) {//update service price
            //get id
            $id= $price_list_services[0]['id'];
            $price_list_services = price_list_services::find($id);
            $price_list_services->update([
                'current_price' => $request->new_price,
                'Created_by' => (Auth::user()->name),
      ]);
        } else { //add service price
            price_list_services::create([
                'service_id' => $request->service_id,
                'price_list_id' => $request->price_list_id,
                'current_price' => $request->new_price,
                'Created_by' => (Auth::user()->name),
            ]);
        }
        session()->flash('Edit', 'Price list edit successfully!!');
        return redirect()->back();
    }

    public function edit_extra_service_price(Request $request, price_list_services $price_list_services)
    {
        $price_list_services = price_list_services::where('price_list_id', $request->price_list_id)->where('ex_code', $request->extra_service_ex_code)->get();
        
        if (count($price_list_services)>0) {//update service price
            //get id
            $id= $price_list_services[0]['id'];
            $price_list_services = price_list_services::find($id);
            $price_list_services->update([
                'current_price' => $request->new_price,
                'Created_by' => (Auth::user()->name),
      ]);
        } else { //add service price
            price_list_services::create([
                'service_id' => 0,
                'ex_code' => $request->extra_service_ex_code,
                'price_list_id' => $request->price_list_id,
                'current_price' => $request->new_price,
                'Created_by' => (Auth::user()->name),
            ]);
        }
        session()->flash('Edit', 'Price list edit successfully!!');
        return redirect()->back();
    }

    public function copy_price_list(Request $request, price_list_services $price_list_services)
    {
        $price_list_services = price_list_services::where('price_list_id', $request->selected_price_list_id)->get();
        $new_price_list_id =$request->new_price_list;
        if (count($price_list_services)>0) {//update service price
            price_list_services::where('price_list_id', $new_price_list_id)->delete();//delete old price on the new list
            foreach ($price_list_services as $key => $price_list_service) {
                //add service price
                price_list_services::create([
                'service_id' => $price_list_service->service_id,
                'price_list_id' => $new_price_list_id,
                'current_price' => $price_list_service->current_price,
                'Created_by' => (Auth::user()->name),
            ]);
            }
            session()->flash('Edit', 'Price list copied successfully!!');
            return redirect()->back();
        } else {
            return back()->withErrors(["other10"=>"Sorry, All services on the price list you had selected not have prices."]);
        }
    }



    public function export_price_list($selected_price_list_id)
    {
        $price_list = price_lists::where('id', $selected_price_list_id)->first();
        $name=$price_list->name_en;
        return (new ExcelExport($selected_price_list_id))->download($name.'.xlsx');
    }

    public function import_price_list(Request $request)
    {
        if ($request->hasFile('price_list_file')) {
            $updateFile = $request->file('price_list_file');
            
            $fileExtension = $updateFile->getClientOriginalExtension();
            
            $formats = ['xls', 'xlsx'];
            if (! in_array($fileExtension, $formats)) {
                return back()->withErrors(["other10"=>"Sorry, The uploaded file format is not allowed."]);
            } else {
                // upload file to server
                $file_name = $updateFile->getClientOriginalName();
                $request->price_list_file->move(public_path('Attachments/temp_price_list'), $file_name);
                $file_name ='Attachments/temp_price_list/'.$file_name;
                
                //inser file to db
                Excel::import(new ExcelImport($request->price_list_id), $file_name);
                
                //delete file from server
                \File::delete(public_path($file_name));
                $errors = Session::get('errors');
                if (!$errors) {
                    session()->flash('Edit', 'Price list updated successfully!!'.$errors);
                }
                return redirect()->back();
            }
        } else {
            return back()->withErrors(["other10"=>"Sorry, Please choose the file you want to upload."]);
        }
    }
}
