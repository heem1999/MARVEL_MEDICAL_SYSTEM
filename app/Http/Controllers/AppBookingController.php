<?php

namespace App\Http\Controllers;

use App\AppBooking;
use App\MedicalAttachments;
use App\AppBookingSerPrices;
use App\Review;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AppBookingController extends Controller
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
        $Attachments=$request->Attachments; //medical attachmets 
        $patient_info=$request->patient_info;
        $selectedPayerData=$request->selectedPayerData;
        $selectedServices=$request->selectedServices;
        
        $reqData['appuser_id'] = Auth::id();
        $reqData['booking_acc'] = $this->generateACCNumber();
        //$reqData['offer_id']=0;
        $reqData['area_id']= $patient_info['area_id'];
        $reqData['payer_id']=$selectedPayerData['id'];
        $reqData['contract_id']=$selectedPayerData['contracts'][0]['id'] ;
        $reqData['status_en']= 'UNDER REVIEWING';
        $reqData['status_ar']= 'قيد المراجعة';
        $reqData['p_name']=$patient_info['name'] ;
        $reqData['p_phone1']=$patient_info['Phone1'] ;
        $reqData['p_phone2']=$patient_info['Phone2'] ;
        $reqData['p_age']=$patient_info['age'] ;
        $reqData['p_sex']=$patient_info['sex'] ;
        $reqData['visit_date']=$patient_info['visit_date'] ;
        $reqData['visit_loc_lat']=$patient_info['visit_location']['lat'] ;
        $reqData['visit_loc_lng']=$patient_info['visit_location']['lng'] ;
        $reqData['visit_loc_address_en']=$patient_info['visit_location']['address_en'] ;
        $reqData['visit_loc_address_ar']=$patient_info['visit_location']['address_ar'] ;
        $reqData['order_destanceKm']=$patient_info['price_calc']['home_vist_destance'] ;
        $reqData['ex_km_price_at']=$patient_info['price_calc']['price_at'];
        $reqData['home_vist_price']=$patient_info['price_calc']['home_vist_price'] ;
        $reqData['note']= $patient_info['notes'];
       
     $bookin_data = AppBooking::create($reqData);
       
       //add services if user selected once
        foreach ($selectedServices as $key => $value) {
            $BookingChild=[];
            $BookingChild['booking_id']=$bookin_data['id'];
            $BookingChild['service_id']=$value['service']['id'];
            $BookingChild['service_price']=$value['current_price'];
            AppBookingSerPrices::create($BookingChild);
        }

        //add MedicalAttachments
        foreach ($Attachments as $key => $image) {
            $BookingChild=[];
            //$name = $this->saveMedicalAttachments($image);// upload files
            $BookingChild['booking_id']=$bookin_data['id'];
            $BookingChild['attachment']=$image;
            MedicalAttachments::create($BookingChild);
        }
        //get branch users to send the notification to them
        //$booking_data=BookingMaster::where('id', $data['id'])->first();
        //$Branch_data = Branch::findOrFail($booking_data->branch_id);
        //$users = User::whereIn('id', $Branch_data->manager)->get();
        //Notification::send($users, new \App\Notifications\new_booking($data['id']));

        return response()->json(['msg' => 'Your request has been received, please await confirmation from the laboratory.', 'msg_ar' => 'طلبك قد وصل، يرجاء انتظار التأكيد من المعمل.','success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AppBooking  $appBooking
     * @return \Illuminate\Http\Response
     */
    public function show(AppBooking $appBooking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AppBooking  $appBooking
     * @return \Illuminate\Http\Response
     */
    public function edit(AppBooking $appBooking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AppBooking  $appBooking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AppBooking $appBooking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AppBooking  $appBooking
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppBooking $appBooking)
    {
        //
    }

    public function saveMedicalAttachments($baseString)
    {
        $img = $baseString;
        $img = str_replace('data:image/jpg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);

        $data = base64_decode($img);
        $Iname = uniqid();
        $file = public_path('/upload/MedicalAttachments/') . $Iname . ".jpg";
        $success = file_put_contents($file, $data);
        return $Iname . ".jpg";
    }

    public function userBooking(Request $request)
    {
        $data['upcoming'] = AppBooking::with(['review'])->where('appuser_id', Auth::id())->whereIn('status', [0,1,2,3,4])->orderBy('id', 'DESC')->get();

        $data['past'] = AppBooking::with(['review'])->where('appuser_id', Auth::id())->whereIn('status', [5])->orderBy('id', 'DESC')->get();

        $data['cancel'] = AppBooking::with(['review'])->where('appuser_id', Auth::id())->whereIn('status', [6,7])->orderBy('id', 'DESC')->get();

        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function singleBooking($id)
    {
        $AppBooking = AppBooking::with('LabTechUser')->find($id);
        $AppBooking->load(['review']);

        $BookingServices=AppBookingSerPrices::with('service')->where('booking_id', $id)->get();
        $MedicalAttachments=MedicalAttachments::where('booking_id', $id)->get();
        
        //message acourdign to the order status for App. user
        $message_en='';
        $message_ar='';
        //status 2 => App user will make approve form app
        if($AppBooking->status==0){//pending 
            $message_en="We are reviewing your request, and the total calculation of your selected services will be available soon as possible.";
            $message_ar="نحن نراجع طلبك ، وسيتوفر الحساب الإجمالي للخدمات التي اخترتها في أقرب وقت ممكن.";
        }else if($AppBooking->status==1){
            $message_en="Your request is confirmed, please review and approve the request.";
            $message_ar="تم تأكيد طلبك ، يرجى مراجعة الطلب والموافقة عليه.";
        }else if($AppBooking->status==3){
            $message_en="Your request is under processing, our lab technician will contact you for a home visit.";
            $message_ar="طلبك قيد المعالجة ، سيقوم فني المختبر لدينا بالاتصال بك من أجل زيارة منزلية.";
        }else if($AppBooking->status==4){
            $message_en="Our lab technician has collected your requested services successfully and he is on his way to the lab for processing.";
            $message_ar="جمع فني المختبر لدينا الخدمات المطلوبة بنجاح وهو في طريقه إلى المختبر للمعالجة.";
        }else if($AppBooking->status==5){
            $message_en="Your requested services have been started processing at the lab, result will be available as soon as possible.";
            $message_ar="تم بدء معالجة خدماتك المطلوبة في المختبر ، وستكون النتيجة متاحة في أقرب وقت ممكن.";
        }else if($AppBooking->status==6){
            $message_en="The request has been canceled by you.";
            $message_ar="تم إلغاء الطلب بواسطتك.";
        }else if($AppBooking->status==7){
            $message_en="The request has been canceled by the lab.";
            $message_ar="تم إلغاء الطلب من قبل المختبر.";
        }
        return response()->json(['message_en' => $message_en,'message_ar' => $message_ar, 'data' => $AppBooking,'BookingServices'=>$BookingServices,'MedicalAttachments'=>$MedicalAttachments, 'success' => true], 200);
    }
    
    public function cancelOrder(Request $request){
        $order_id = $request->order_id;
        $comment = $request->comment;
        $AppBooking = AppBooking::where('id', $order_id)->first();
        $AppBooking->update([
            'status' => 6, //canceled by app user
            'canceled_reason' => $comment,
            'status_en' => "CANCELED",
            'status_ar' => "ملغي",
        ]);
        return ['success' => true];
    }

    public function approveOrder(Request $request){
        $order_id = $request->order_id;
      
        $AppBooking = AppBooking::where('id', $order_id)->first();
        $AppBooking->update([
            'status' => 2, //Approved by app user
            'status_en' => "Approved",
            'status_ar' => "معتمد",// موافق عليه
        ]);
        return ['success' => true];
    }

    
    public function updateBookingAttachments(Request $request){
        $booking_id = $request->booking_id;
        $attachment_image_url = $request->image;
        $attachment_status = $request->attachment_status; // 0 => add attach, 1 => delete
        $attachment_id = $request->attachment_id; 
        $message_en='';
        $message_ar='';
        if($attachment_status==0){//add Attachments
            //$name = $this->saveMedicalAttachments($attachment_image_url);// upload files
            $BookingChild['booking_id']=$booking_id;
            $BookingChild['attachment']=$attachment_image_url;
            MedicalAttachments::create($BookingChild);
            $message_en='The attachment was uploaded successfully.';
            $message_ar='تم تحميل المرفق بنجاح.';
        }
        if($attachment_status==1){//delete Attachments
            $AppBooking = MedicalAttachments::where('id', $attachment_id)->delete();
            $message_en='The attachment was deleted successfully.';
            $message_ar='تم حذف المرفق بنجاح.';
        }
        
        $MedicalAttachments=MedicalAttachments::where('booking_id', $booking_id)->get();

        return ['msg' => $message_en,'msg_ar' => $message_ar, 'MedicalAttachments'=>$MedicalAttachments,'success' => true];
    }
    
    public function generateACCNumber()
    {
        $last_sample_id= AppBooking::orderBy('created_at', 'DESC')->first();
        if ($last_sample_id) {
            $new_sample_id= $last_sample_id->id+1;
        } else {
            $new_sample_id= 1;
        }
        $number =90000+$new_sample_id;
        return $number;
    }


    public function store_review(Request $request){
        $request->validate([
            'booking_id' => 'bail|required',
            'star' => 'required|numeric|min:1|max:5',
        ]);
        $reqData = $request->all();
        $reqData['user_id'] = Auth::user()->id;
        Review::create($reqData);
        return response()->json(['msg' => 'Thanks for review', 'data' => null, 'success' => true], 200);
}



    /************ MLT  *******/

    public function MLT_Requests(Request $request)
    {
        $data['upcoming'] = AppBooking::with(['review'])->where(function($query){
            $query->where('LabTech_id', Auth::id())->orwhere('area_id', auth()->user()->area->id);
        })->whereIn('status', [2,3,4])->orderBy('id', 'DESC')->get();//approved, processing, collected
        
        $data['past'] = AppBooking::with(['review'])->where(function($query){
            $query->where('LabTech_id', Auth::id())->orwhere('area_id', auth()->user()->area->id);
        })->whereIn('status', [5])->orderBy('id', 'DESC')->get();

        $data['cancel'] = AppBooking::with(['review'])->where(function($query){
            $query->where('LabTech_id', Auth::id())->orwhere('area_id', auth()->user()->area->id);
        })->whereIn('status', [6,7])->orderBy('id', 'DESC')->get();

        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function single_MLT_Requests($id)
    {
        $AppBooking = AppBooking::find($id);
        $AppBooking->load(['review']);

        $BookingServices=AppBookingSerPrices::with('service')->where('booking_id', $id)->get();
        $MedicalAttachments=MedicalAttachments::where('booking_id', $id)->get();
        
        return response()->json(['data' => $AppBooking,'BookingServices'=>$BookingServices,'MedicalAttachments'=>$MedicalAttachments, 'success' => true], 200);
    }

    
    public function start_processing_MLT(Request $request){
        $order_id = $request->order_id;
        $AppBooking = AppBooking::where('id', $order_id)->first();
        $AppBooking->update([
            'LabTech_id' => auth()->user()->id, 
            'status' => 3, 
            'status_en' => "Under Processing",
            'status_ar' => "قيد المعالجة ",
        ]);
        return ['success' => true];
    }

    public function smaple_collected_MLT(Request $request){
        $order_id = $request->order_id;
        $AppBooking = AppBooking::where('id', $order_id)->first();
        $AppBooking->update([
            'LabTech_id' => auth()->user()->id, 
            'status' => 4, 
            'status_en' => "Sample Collected",
            'status_ar' => "جمعت العينة",
        ]);
        return ['success' => true];
    }

    
}
