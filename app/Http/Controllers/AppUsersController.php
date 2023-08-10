<?php

namespace App\Http\Controllers;

use App\AppUsers;
use App\Services;
use App\Clinical_units;
use App\Payers;
use App\Payer_contracts;
use App\Contract_classifications;
use App\Contracts_price_list_settings;
use App\Price_list_services;
use App\Service_tests;
use App\service_nested_services;
use App\Areas;
use App\Offer;
use App\MedicalAttachments;
use App\lab_tech_users;
use App\PaymentsAttachments;
use App\app_General_Setting;
use App\Regions;
use App\appBranches;
use App\Rules\CurrentPasswordCheckRule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
use Hash;

class AppUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AppUsers  $appUsers
     * @return \Illuminate\Http\Response
     */
    public function show(AppUsers $appUsers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AppUsers  $appUsers
     * @return \Illuminate\Http\Response
     */
    public function edit(AppUsers $appUsers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AppUsers  $appUsers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AppUsers $appUsers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AppUsers  $appUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppUsers $appUsers)
    {
        //
    }


    public function login(Request $request)
    {
        $user = AppUsers::where('phone_no', $request->phone_no)->first();
        
        if ($user && Hash::check($request->password, $user->password)) {
            /*if ($user['verified'] != 1) {
                return response()->json(['msg' => 'Please Verify your account','msg_ar' => 'يرجى التحقق من حسابك', 'data' => null, 'success' => false, 'verification' => true], 200);
            }*/
            if ($user['status'] == 0) {
                return response()->json(['msg' => 'Sorry, this account is blocked by the administration.','msg_ar' =>"عذرا ، تم حظر هذا الحساب من قبل الإدارة.", 'data' => null, 'success' => false], 200);
            }
            $token = $user->createToken('user')->accessToken;
            $user['device_token'] = $request->device_token;
            $user->save();
            $user['token'] = $token;
            return response()->json(['msg' => 'Welcome back!','msg_ar' => 'مرحبا بك!', 'data' => $user, 'success' => true], 200);
        } else {
            return response()->json(['msg' => 'The phone or password does not match our records','msg_ar' => 'الهاتف أو كلمة المرور لا تتطابق مع سجلاتنا', 'data' => null, 'success' => false], 200);
        }
    }

    public function forgot(Request $request)
    {
        $userData = AppUsers::where([['phone_no', $request->phone_no]])->first();
        if ($userData) {
            $res = (new AdminController)->sendOTPUser($request->phone_no);
            if ($res['success'] === true) {
                $reqData['OTP'] = $res['otp'];
                $userData->update($reqData);
                return response()->json(['msg' => 'OTP send to your phone.','msg_ar' => 'تم إرسال OTP إلى هاتفك.', 'data' => null, 'success' => true], 200);
            } else {
                return response()->json(['msg' => 'Something went wrong!','msg_ar' => '!حدث خطأ ما.', 'data' => null, 'success' => false], 200);
            }
        }
        return response()->json(['request'=>$request,'msg' => 'You are not a registered user.','msg_ar' => 'أنت غير مسجل.', 'data' => null, 'success' => false], 200);
    }

    public function forgotValidate(Request $request)
    {
       
        $userData = AppUsers::where([['phone_no', $request->phone_no], ['OTP', $request->otp]])->first();
        if ($userData) {
            //$userData->update(['otp' => '']);
            $data['token'] = $userData->createToken('user')->accessToken;
            return response()->json(['msg' => 'OTP is verified.','msg_ar' => 'تم التحقق من OTP.', 'data' => $data, 'success' => true], 200);
        }
        return response()->json(['msg' => 'Given OTP is invalid.','msg_ar' => 'رمز التحقق غير صالح.', 'data' => null, 'success' => false], 200);
    }

    public function SignupPageOTP(Request $request)
    {
        $request->validate([
            //'email' => 'bail|required|email|unique:app_users,email',
            'name' => 'bail|required',
            'password' => 'bail|required|confirmed|min:6',
            'phone_no' => 'bail|required|digits:9|unique:app_users,phone_no',
        ], [
        'password.min' =>json_encode(['err'=>'The password must be at least 6 characters.','err_ar'=>'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل.']),
        'password.confirmed' =>json_encode(['err'=>'The password confirmation does not match.','err_ar'=>'تأكيد كلمة المرور غير متطابق.']),
        'phone_no.digits' =>json_encode(['err'=>'The phone no must be 9 digits.','err_ar'=>'يجب أن يتكون رقم الهاتف من 9 أرقام.']),
        'phone_no.unique' =>json_encode(['err'=>'This phone number has already been registered.','err_ar'=>'تم تسجيل رقم الهاتف هذا بالفعل.']),
        ]);
        $reqData = $request->all();
        try {
            $res = (new Admin\AdminController)->sendOTPUser($request);
            if ($res['success'] === true) {
                $reqData['otp'] = $res['otp'];
                return response()->json(['msg' => 'OTP send to your phone.','msg_ar' => 'تم إرسال OTP إلى هاتفك.', 'data' => $reqData, 'success' => true], 200);
            } else {
                return response()->json(['msg' => 'Something went wrong.','msg_ar' => 'حدث خطأ ما.', 'data' => null, 'success' => false], 200);
            }
        } catch (\Exception $e) {
            //$reqData['verified'] = 1;
            $reqData['otp'] = '0000';
        }
    }


    public function newPassword(Request $request)
    {
        //return response()->json(['msg' => auth()->user(), 'msg_ar' => 'أهلا بكم من جديد ...', 'success' => true], 200);

        $request->validate([
            'password' => 'required|confirmed|min:6',
        ], [
            'password.min' =>json_encode(['err'=>'The password must be at least 6 characters.','err_ar'=>'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل.']),
            'password.confirmed' =>json_encode(['err'=>'The password confirmation does not match.','err_ar'=>'تأكيد كلمة المرور غير متطابق.']),
            ]);

        auth()->user()->update(['password' => Hash::make($request->password)]);

        $data['token'] = auth()->user()->createToken('users')->accessToken;
        return response()->json(['msg' => 'Welcome back...', 'msg_ar' => 'أهلا بكم من جديد ...','data' => $data, 'success' => true], 200);
    }

    public function password(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'min:6', new CurrentPasswordCheckRule],
            'password' => ['required', 'min:6', 'confirmed', 'different:old_password'],
            'password_confirmation' => ['required', 'min:6'],
        ], [
        'password.min' =>json_encode(['err'=>'The password must be at least 6 characters.','err_ar'=>'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل.']),
        'password.confirmed' =>json_encode(['err'=>'The password confirmation does not match.','err_ar'=>'تأكيد كلمة المرور غير متطابق.']),
        'password_confirmation.min' =>json_encode(['err'=>'The password must be at least 6 characters.','err_ar'=>'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل.']),
        'password.different'=>json_encode(['err'=>'The new password matches your current password.','err_ar'=>'كلمة المرور الجديدة تطابق كلمة مرورك الحالية.']),
       
        ]);

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);
        $data['token'] = auth()->user()->createToken('user')->accessToken;
        return response()->json(['msg' => "Password changed",'msg_ar' => "تم تغيير كلمة السر", 'data' => $data['token'], 'success' => true], 200);
    }

    public function profileUpdate(Request $request)
    {
        auth()->user()->update($request->all());
        return response()->json(['msg' => 'Profile Updated','msg_ar' => 'تم تحديث الملف الشخصي', 'data' => null, 'success' => true], 200);
    }
    public function profilePictureUpdate(Request $request)
    {
        $name = $this->saveBase64($request->image);

        auth()->user()->update([
            'image' => $name,
        ]);
        return response()->json(['msg' => 'Profile Updated','msg_ar' => 'تم تحديث الملف الشخصي', 'data' => null, 'success' => true], 200);
    }

    public function saveBase64($baseString)
    {
        $img = $baseString;
        $img = str_replace('data:image/jpg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);

        $data = base64_decode($img);
        $Iname = uniqid();
        $file = public_path('/upload/usersProfile/') . $Iname . ".jpg";
        $success = file_put_contents($file, $data);
        return $Iname . ".jpg";
    }

    public function updateFCMToken(Request $request)
    {
       // auth()->user()->update(['fcm_token'=>$request->token]);
       $userData = AppUsers::where('id', $request->user_id)->update(['fcm_token'=>$request->token]);
        return response()->json(['msg' => 'FCM Updated'], 200);
    }

    public function update_app_lang(Request $request)
    {
       $userData = AppUsers::where('id', $request->user_id)->update(['app_lang'=>$request->selected_lang]);
        return response()->json(['msg' => 'Language Updated successfuly!'], 200);
    }



    /** AlborgService */
    public function AlborgService(Request $request)
    {
       
        $payer_contract_id=$request->payer_contract_id;
        $payer_code=$request->payer_code; //to show price list of walkin contact only without extra service
        $cpl=Contracts_price_list_settings::where('contract_id',$payer_contract_id)->first();
        $price_list_id=$cpl->price_list->id;
        if($payer_code=='1515'){//walkin contact  
            $Price_list_services=Price_list_services::with(['service' => function ($q) {
                $q->with('clinical_unit')->where('active', 1)->get();
            }])->where('price_list_id', $price_list_id)->where('current_price','>', 0)->where('service_id','>', 0)->get();  

            foreach ($Price_list_services as $key => $Price_list_service) {
                $Price_list_service['clinical_unit_id']=$Price_list_service->service->clinical_unit_id;
            }
          $Price_list_services=collect($Price_list_services)->groupBy('clinical_unit_id');
          $new=[];
          foreach ($Price_list_services as $key => $Price_list_service) {
            $x=['clinical_id'=>$key,'services'=>$Price_list_service];
            $new[]=$x;
        }
            $Clinical_units =  Clinical_units::all();
            $Clinical_units[] =  ["id"=>0,"name_en"=>'Other',"name_ar"=>'اخرى'];
           
            
    return response()->json(['msg' => null, 'data' => $new,'Price_list_services' => $Price_list_services,'Clinical_units' => $Clinical_units, 'success' => true], 200);

        }else{
            return response()->json(['msg' => 'Your insurance is on a company, please attach the insurance card and prescription for verification and complete the registration process.', 'msg_ar' =>'التأمين الخاص بك على شركة ، يرجى إرفاق بطاقة التأمين والوصفة الطبية للتحقق وإكمال عملية التسجيل.', 'success' => false], 200);
        }
      
    }

       
    public function PayerList(Request $request)
    {
        $Payer_contracts =  Payer_contracts::where('active', 1)->get();
        $Payers =  Payers::where('active', 1)->get();
        $Contract_classifications =  Contract_classifications::all();
        
        $Contract_classifications[] =  ["id"=>0,"name_en"=>'All',"name_ar"=>'الكل'];
        $keys=[];
        foreach ($Payers as $key => $Payer) { 
            if($request->classification_id<>0){
                $d =  Payer_contracts::with('classification')->where('active', 1)->where('payer_id', $Payer->id)->where('classification_id', $request->classification_id)->get();
              
               if(count($d)>0){
                $Payer['contracts']=$d;
                }else{
                    $keys[]=$key;
                  // $Payer['contracts']=$d;
           // unset($Payers[$key]);
                }
            }else{
                $Payer['contracts'] =  Payer_contracts::with('classification')->where('active', 1)->where('payer_id', $Payer->id)->get();
            }
        }
        $new_p=[];
       foreach ($keys as $key => $value) {
        unset($Payers[$value]);
       }
       foreach ($Payers as $key => $value) {
        $new_p[]=$value;
       }
      //  return  $new_p;
        $data=['Payers'=>$new_p,'Payer_contracts'=>$Payer_contracts,'Contract_classifications'=>$Contract_classifications,];
        $Areas = Areas::all();
        return response()->json(['msg' => null,'Areas' => $Areas, 'data' => $data, 'success' => true], 200);
    }


    public function ServiceTests(Request $request)
    { 
        $service_id=$request->service_id;
        $is_nested_services=$request->is_nested_services;
        $services=[];
        if($is_nested_services==1){
            $service_nested_services=service_nested_services::with('nested_service')->where('service_id', $service_id)->get();
            foreach ($service_nested_services as $key => $value) {
                $services[]=$value->nested_service->id;
            }
        }else{
            $services[]=$service_id;
        }
        $Service_tests=[];
        foreach ($services as $key => $value) {
            $Service_tests[] =  Service_tests::with(['test' => function ($q) {
                $q->with('clinical_unit')->with('sample_type')->with('sample_condition')->with('unit')->where('active', 1)->get(); 
            }])->where('service_id', $value)->get();
        }

        
       
        return response()->json(['msg' =>  null, 'data' => $Service_tests, 'success' => true], 200);
    }
    
    public function calculat_visit_by_location(Request $request)
    { 
        $visit_lat=$request->lat;
        $visit_lng=$request->lng;
        //home visit setting => home vist start from, minimum km for fixed cost, extra km price , 
        $Areas=Areas::where('id', $request->area_id)->first(); //get home visit calculations
        $lab_lat=$Areas->zone_lat;
        $lab_lng=$Areas->zone_lng;
        $fixed_price= $Areas->home_visit_fixed_price;//sdg
        $minimum_km=$Areas->zone_radius_km;//km limit of destance that the order will charge with the fixed price
        $ex_km_price= $Areas->ex_km_price;//sdg per km
        $home_vist_price=0;
        $home_vist_destance=round($this->codexworldGetDistanceOpt($lab_lat, $lab_lng, $visit_lat, $visit_lng)*1000, 0, PHP_ROUND_HALF_UP);

        if($home_vist_destance<=$minimum_km){
            $home_vist_price= $fixed_price;
        }else{
            $home_vist_price= $fixed_price+((($home_vist_destance-$minimum_km)/1000) * $ex_km_price);
        }
        $data=['home_vist_price'=>$home_vist_price,'home_vist_destance'=>$home_vist_destance,'price_at'=>$ex_km_price];

        return response()->json(['msg_en' => "Home visit costs depending on your location will be: ".number_format($home_vist_price, 0).' SDG, Total destance =>'.($home_vist_destance/1000)." KM",'msg_ar' => "ستكون تكاليف الزيارة المنزلية حسب موقعك: ".number_format($home_vist_price, 0).'ج.س، المسافة الكلية=>'.($home_vist_destance/1000)." كم", 'data' => $data, 'success' => true], 200);

        }

    public function codexworldGetDistanceOpt($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
      {
          $rad = M_PI / 180;
          //Calculate distance from latitude and longitude
          $theta = $longitudeFrom - $longitudeTo;
          $dist = sin($latitudeFrom * $rad)
              * sin($latitudeTo * $rad) +  cos($latitudeFrom * $rad)
              * cos($latitudeTo * $rad) * cos($theta * $rad);
      
          return acos($dist) / $rad * 60 *  1.853;
      }

      public function about_us(Request $request)
      { 
        $appBranches=appBranches::with('region')->get() ;
        $app_General_Setting=app_General_Setting::all() ;
        $data1['ios_version_mesg'] = ['msg_ar' => 'التحديث الجديد متاح.', 'msg_en' =>'New update is available.','link'=>'https://alborgdx.com/'];
        $data1['android_version_mesg'] = ['msg_ar' => 'التحديث الجديد متاح انقر هنا', 'msg_en' =>'New update is available click here','link'=>'https://alborgdx.com/'];
        
        $data=['appBranches'=>$appBranches,'app_General_Setting'=>$app_General_Setting];
        return response()->json(['data' => $data, 'data1' => $data1,'success' => true], 200);
      }
/************ call center system setting ******/

/******************  AppUsers ***********************/

public function open_AppUsers(Request $request)
{
    $AppUsers = AppUsers::all();
   
    return view('administration.call_center.AppUsers.appUsers', compact('AppUsers'));
}


public function change_AppUserStatus($id)
    {
        $AppUsers = AppUsers::where('id', $id)->first();
        
        if($AppUsers->status==0){
            $AppUsers->update([
                'status' => 1,     
            ]);
        }else{
            $AppUsers->update([
                'status' => 0,     
            ]);
        }
        

        return redirect()->back();
    }



/******************  LabTechDrivers ***********************/

public function open_LabTechDrivers(Request $request)
{
    $Technicians = lab_tech_users::all();
    $Areas = Areas::all();
    return view('administration.call_center.LabTechDrivers.LabTechDrivers', compact('Technicians',"Areas"));
}

public function add_LabTechDriver(Request $request)
{
    $validatedData = $request->validate([
        'phone' => 'required|unique:lab_tech_users|max:255',
    ], [
        'phone.required' =>'Please enter the technician phone.',
        'phone.unique' =>'This technician phone is already existed.',
    ]);
    
    $reqData = $request->all();
    $reqData['password'] = Hash::make("borg123");//defalt MLT user password
   // $reqData['status'] = Hash::make("borg");
    $data = lab_tech_users::create($reqData);
   
    session()->flash('Add', 'Technician user added successfully!! ');
  
    return redirect()->back();
}

public function update_LabTechDriver(Request $request)
{
    $lab_tech_users = lab_tech_users::findOrFail($request->id);
    
    $lab_tech_users->update([
        'name_en' => $request->name_en,
        'name_ar' => $request->name_ar,
        'area_id' => $request->area_id,
        'phone' => $request->phone,        
    ]);

    session()->flash('Edit', 'Technician user edited successfully!! ');
    return redirect()->back();
}

public function delete_LabTechDriver(Request $request)
{
    $id = $request->id;
    lab_tech_users::find($id)->delete();
    session()->flash('delete', 'Technician user deleted successfully!!');
   
    return redirect()->back();
}

/******************  App_General_Setting ***********************/
public function appBranches()
    {
        $appBranches = appBranches::all();
        return view('administration.call_center.appBranches.appBranches', compact('appBranches'));
    }

    public function add_appBranch()
    {
        $regions = regions::all();
        return view('administration.call_center.appBranches.add_branch', compact('regions'));
    }

    public function store_appBranch(Request $request)
{
    $reqData = $request->all();
    appBranches::create( $reqData);
   
    session()->flash('Add', 'Branch added successfully!! ');
  
    return redirect('/appBranches');
}

    public function edit_appBranch($id)
    {
        $branches = appBranches::where('id', $id)->first();
        $regions = regions::all();
        return view('administration.call_center.appBranches.edit_branch', compact('branches', 'regions'));
    }

    public function update_appBranch(Request $request)
{
    $reqData = $request->all();
    $appBranches=appBranches::findOrFail( $request->branche_id);
    unset($reqData['branche_id']);
    $appBranches->update( $reqData);
   
    session()->flash('Add', 'Branch added successfully!! ');
  
    return redirect('/appBranches');
}

    public function delete_appBranch(Request $request)
    {
        $id = $request->branche_id;
        appBranches::find($id)->delete();
        session()->flash('delete', 'Deleted successfully!!');
        return redirect('/appBranches');
    }



public function App_General_Setting(Request $request)
{
    $app_General_Setting = app_General_Setting::first();
    return view('administration.call_center.app_General_Setting', compact('app_General_Setting'));
}


public function update_App_General_Setting(Request $request)
{
    $app_General_Setting = app_General_Setting::findOrFail(1);
    $reqData = $request->all();

    if (isset($request->booking_is_block)) {
        $reqData['booking_is_block'] = 1;
    }else{
        $reqData['booking_is_block'] =0;
    }

    if (isset($request-> sysytem_is_block)) {
        $reqData['sysytem_is_block'] = 1;
    }else{
        $reqData['sysytem_is_block'] =0;
    }

    if ($request->logo && $request->logo != "undefined") {
       // $reqData['icon'] = $this->saveImage($request);
    }
    $app_General_Setting->update($reqData);
    session()->flash('Edit', 'Area edit successfully!! ');
    return redirect()->back();
}

public function saveImage($request)
    {
        $image = $request->file('logo');
        $input['imagename'] = uniqid() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/upload/logos');
        $image->move($destinationPath, $input['imagename']);

        return $input['imagename'];
    }

/******************  areas ***********************/
public function open_Area(Request $request)
{
    $Areas = Areas::all();
    return view('administration.call_center.areas', compact('Areas'));
}

public function add_Area(Request $request)
{
    $validatedData = $request->validate([
        'name_en' => 'required|unique:Areas|max:255',
        'name_ar' => 'required|unique:Areas|max:255',
    ], [
        'name_en.required' =>'Please enter the area name(en).',
        'name_en.unique' =>'This area is already existed.',
        'name_ar.required' =>'Please enter the area name(ar).',
        'name_ar.unique' =>'This area is already existed.',
    ]);
    $reqData = $request->all();
    Areas::create( $reqData);
   
    session()->flash('Add', 'area add successfully!! ');
  
    return redirect()->back();
}

public function update_Area(Request $request)
{
    $Areas = Areas::findOrFail($request->id);
    $reqData = $request->all();
    $Areas->update($reqData);
    

    session()->flash('Edit', 'Area edit successfully!! ');
    return redirect()->back();
}

public function delete_Area(Request $request)
{
    $id = $request->id;
    Areas::find($id)->delete();
    session()->flash('delete', 'Area deleted successfully!!');
   
    return redirect()->back();
}



/********************** Medical Lab Technition */
public function login_MLT(Request $request)
{
    $user = lab_tech_users::where('phone', $request->phone_no)->first();
    
    if ($user && Hash::check($request->password, $user->password)) {
        /*if ($user['verified'] != 1) {
            return response()->json(['msg' => 'Please Verify your account','msg_ar' => 'يرجى التحقق من حسابك', 'data' => null, 'success' => false, 'verification' => true], 200);
        }*/
        if ($user['status'] == 0) {
            return response()->json(['msg' => 'Sorry, this account is blocked by the administration.','msg_ar' =>"عذرا ، تم حظر هذا الحساب من قبل الإدارة.", 'data' => null, 'success' => false], 200);
        }
        $token = $user->createToken('user_MLT')->accessToken;
        $user['device_token'] = $request->device_token;
        $user->save();
        $user['token'] = $token;
        return response()->json(['msg' => 'Welcome back!','msg_ar' => 'مرحبا بك!', 'data' => $user, 'success' => true], 200);
    } else {
        return response()->json(['msg' => 'The phone or password does not match our records','msg_ar' => 'الهاتف أو كلمة المرور لا تتطابق مع سجلاتنا', 'data' => null, 'success' => false], 200);
    }
}


public function profileUpdate_MLT(Request $request)
    {
        auth()->user()->update($request->all());
        return response()->json(['msg' => 'Profile Updated','msg_ar' => 'تم تحديث الملف الشخصي', 'data' => null, 'success' => true], 200);
    }

    public function profilePictureUpdate_MLT(Request $request)
    {
        $name = $this->saveBase64($request->image);

        auth()->user()->update([
            'image' => $name,
        ]);
        return response()->json(['msg' => 'Profile Updated','msg_ar' => 'تم تحديث الملف الشخصي', 'data' => null, 'success' => true], 200);
    }

    public function password_MLT(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'min:6', new CurrentPasswordCheckRule],
            'password' => ['required', 'min:6', 'confirmed', 'different:old_password'],
            'password_confirmation' => ['required', 'min:6'],
        ], [
        'password.min' =>json_encode(['err'=>'The password must be at least 6 characters.','err_ar'=>'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل.']),
        'password.confirmed' =>json_encode(['err'=>'The password confirmation does not match.','err_ar'=>'تأكيد كلمة المرور غير متطابق.']),
        'password_confirmation.min' =>json_encode(['err'=>'The password must be at least 6 characters.','err_ar'=>'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل.']),
        'password.different'=>json_encode(['err'=>'The new password matches your current password.','err_ar'=>'كلمة المرور الجديدة تطابق كلمة مرورك الحالية.']),
       
        ]);

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);
        $data['token'] = auth()->user()->createToken('user_MLT')->accessToken;
        return response()->json(['msg' => "Password changed",'msg_ar' => "تم تغيير كلمة السر", 'data' => $data['token'], 'success' => true], 200);
    }


    public function forgot_MLT(Request $request)
    {
        $userData = lab_tech_users::where([['phone', $request->phone_no]])->first();
        if ($userData) {
            $res = (new AdminController)->sendOTPUser($request->phone_no);
            if ($res['success'] === true) {
                $reqData['OTP'] = $res['otp'];
                $userData->update($reqData);
                return response()->json(['msg' => 'OTP send to your phone.','msg_ar' => 'تم إرسال OTP إلى هاتفك.', 'data' => null, 'success' => true], 200);
            } else {
                return response()->json(['msg' => 'Something went wrong!','msg_ar' => '!حدث خطأ ما.', 'data' => null, 'success' => false], 200);
            }
        }
        return response()->json(['request'=>$request,'msg' => 'You are not a registered user.','msg_ar' => 'أنت غير مسجل.', 'data' => null, 'success' => false], 200);
    }

    public function forgotValidate_MLT(Request $request)
    {
        $userData = lab_tech_users::where([['phone', $request->phone_no], ['OTP', $request->otp]])->first();
        if ($userData) {
            //$userData->update(['otp' => '']);
            $data['token'] = $userData->createToken('user_MLT')->accessToken;
            return response()->json(['msg' => 'OTP is verified.','msg_ar' => 'تم التحقق من OTP.', 'data' => $data, 'success' => true], 200);
        }
        return response()->json(['msg' => 'Given OTP is invalid.','msg_ar' => 'رمز التحقق غير صالح.', 'data' => null, 'success' => false], 200);
    }

    public function newPassword_MLT(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ], [
            'password.min' =>json_encode(['err'=>'The password must be at least 6 characters.','err_ar'=>'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل.']),
            'password.confirmed' =>json_encode(['err'=>'The password confirmation does not match.','err_ar'=>'تأكيد كلمة المرور غير متطابق.']),
            ]);

        auth()->user()->update(['password' => Hash::make($request->password)]);

        $data['token'] = auth()->user()->createToken('user_MLT')->accessToken;
        return response()->json(['msg' => 'Welcome back...', 'msg_ar' => 'أهلا بكم من جديد ...','data' => $data, 'success' => true], 200);
    }

    public function update_app_lang_MLT(Request $request)
    {
       $userData = lab_tech_users::where('id', $request->user_id)->update(['app_lang'=>$request->selected_lang]);
        return response()->json(['msg' => 'Language Updated successfuly!'], 200);
    }

}
