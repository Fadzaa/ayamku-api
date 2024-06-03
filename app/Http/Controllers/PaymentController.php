<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\XenditSdkException;

class PaymentController extends Controller
{
    public function __construct()
    {
        Configuration::setXenditKey('xnd_development_rW6HoGP6uPX4vvoUC31NbAa9r0zjRAKtJSX9UxJlNGCTXx1aIInVBzWraSsIXPo');
    }

    public function create(Request $request)
    {
        $apiInstance = new InvoiceApi();

        $invoice_request = new CreateInvoiceRequest([
            'external_id' => (string) Str::uuid(),
            'amount' => $request->amount,

            'payer_email'=> $request->payer_email,

        ]);


        try {
            $createInvoice = $apiInstance->createInvoice($invoice_request);

            $payment = new Payment();
            $payment->checkout_link = $createInvoice['invoice_url'];
            $payment->external_id = $createInvoice['external_id'];
            $payment->status = $createInvoice['status'];
            $payment->save();

            return response()->json($payment);

        }catch (XenditSdkException $e){
            return response()->json($e->getMessage());
        }
    }
}
