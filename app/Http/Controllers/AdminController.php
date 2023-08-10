<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(view()->exists($id)){
            return view($id);
        }
        else
        {
            return view('404');
        }

     //   return view($id);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendOTPUser( $phone_no)
    {
            $string = '0123456789';
            $string_shuffled = str_shuffle($string);
            $otp = substr($string_shuffled, 1, 4);
            $message = $otp . ' is your verification code for Alborgdx. /YyQr6oN9SwI';

            $this->textLocal($phone_no, $message);

            return ['otp' => $otp, 'success' => true];
    }

    public function sendPasswordToUser($request)
    {
    $message = 'Hello '.$request->name.', you have been registered on Bonita platform. Please download the application on your phone and use this password '.$request->password;
            $this->textLocal($request->phone_no, $message);
            return ['success' => true];
    }

    private function textLocal($ph, $message)
    {

        try {
            //code...
           $apiKey = 'ZGFyYXNvZnR3YXJlMjAxMkBnbWFpbC5jb206V1okN0dSM0pAbA==';
           $ph = '249' . $ph;
           $message = rawurlencode($message);
           $url = 'https://mazinhost.com/smsv1/sms/api?action=send-sms&api_key=ZGFyYXNvZnR3YXJlMjAxMkBnbWFpbC5jb206V1okN0dSM0pAbA==&to='.$ph.'&from=Bonita&sms='.$message;
           //$url ='https://mazinhost.com/smsv1/sms/api?action=send-sms&api_key='.$apiKey.'&to='.$ph.'&from=Bonita&sms'.$message;
           
           //$contents =file_get_contents($url);
           /*$apiKey = urlencode(env("TEXT_LOCAL_API"));
            $numbers = array(918487013103);
            $sender = urlencode('Bonita');
            $message = rawurlencode($message);
            $numbers = implode(',', $numbers);
            $ph = '249' . $ph;
            $data = array('api_key' => $apiKey, 'to' => $ph, 'from' => $sender, 'sms' => $message);
            $ch = curl_init('https://mazinhost.com/smsv1/sms/api?action=send-sms');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);*/
        } catch (\Throwable $th) {
            //throw $th;

        }
    }

}
