<?php

namespace App\Http\Controllers;
use App\Http\Services\FatoorahServices;
use Illuminate\Http\Request;

class FatoorahController extends Controller
{
    private $fatoorahServices;

    public function __construct(FatoorahServices $fatoorahServices)
    {
        $this->fatoorahServices = $fatoorahServices;
    }

    public function payOrder(){
        $data = [
            'NotificationOption' => 'Lnk',
            'InvoiceValue'       => 100,
            'CustomerName'       => 'Mohamed Adel',
            'DisplayCurrencyIso' => 'SAR',
            'CustomerEmail'      => 'mohamedadel31038@gmail.com',
            'CallBackUrl'        => env('CallBackUrl'),
            'ErrorUrl'           => env('ErrorUrl'),
            'Language'           => 'en', //or 'ar'
        ];

        return $this->fatoorahServices->sendPayment($data);

        // transaction_table
//            $invoice_id = 123456
//            $userid     = auth()->user()->id;

    } //End of payOrder function


    public function paymentCallBack(Request $request){
        $data = [];
        $data['Key'] =  $request->paymentId;
        $data['KeyType'] = 'paymentId';
        $paymentData   =  $this->fatoorahServices->getPaymentStatus($data);

        // Search in transaction_table where invoice_id == $paymentData['Data']['InvoiceId'] and change status to paid
    }

} //End of FatoorahController Class
