<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mailer;


use App\model\Order;
use App\model\Meta;
use App\model\Invoice;
use App\model\OrderInvoice;

use App\User;
use Auth;
use App;
use PDF;
use App\model\LogsModel;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {

        // $this->middleware('auth');
    }


    public function index()
    {
        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        return view( _admin('invoice.index'), ['title' => 'Invoices'] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( $id )
    {
        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        $order = Order::find($id);

        if( !$order )
            return redirect()->back()->withErrors(['order_not_found' => 'Order not found!']);

        $invoice_id = Invoice::where('order_id', $id)->value('id');
        if( $invoice_id )
            return redirect()->route('admin.invoice.view', $invoice_id);

        if( $invoice_no = Invoice::orderBy('id', 'DESC')->value('invoice_no') )
            $invoice_no = $invoice_no + 1;
        else
            $invoice_no = Meta::where('meta_name', 'init_invoice_no')->value('meta_value');

        $array = ['order_id' => $order->id, 'order_no' => $order->order_id, 'invoice_no' => $invoice_no];
        $invoice_id = Invoice::create($array)->id;
        OrderInvoice::create(['order_id' => $order->id, 'invoice_id' => $invoice_id]);

        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Create Invoice','status'=>'invoice', 'working_id' => $invoice_id]);

        return redirect()->route('admin.invoice.view', $invoice_id);

        //return view(_admin('invoice.create'), ['title' => 'Create Invoice', 'order' => $order]);
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
        $invoice = Invoice::where('id', $id)->first();
        if( $invoice ) {
            $order = Order::with(['order_products', 'order_customer', 'payment'])->find($invoice->order_id);
            return view(_admin('invoice.create'), ['title' => 'Create Invoice', 'invoice' => $invoice, 'order' => $order]);

            //$pdf = App::make('dompdf.wrapper');
            //$pdf->loadHTML( $html );
            //return $pdf->stream();
        }
    }

    public function download($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        if( $invoice ) {
            $order = Order::with(['order_products', 'order_customer'])->find($invoice->order_id);
            $html = view(_admin('invoice.create'), ['title' => 'Create Invoice', 'invoice' => $invoice, 'order' => $order])->render();

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML( $html );
            return $pdf->stream();
        }
    }


    public function send( Request $request )
    {
        if( !$request->invoice_id )
            return redirect()->back()->withErrors(['invoice_not_found' => 'Invoice not found!']);

        $invoice = Invoice::where('id', $request->invoice_id)->first();
        if( !$invoice )
            return redirect()->back()->withErrors(['invoice_not_found' => 'Invoice not found!']);

        $order = Order::with(['order_products', 'order_customer'])->find($invoice->order_id);
        if( !$order )
            return redirect()->back()->withErrors(['invoice_not_found' => 'Invoice not found!']);

        if( !$order->order_customer || count($order->order_customer) < 1 ) {

            return redirect()->back()->withErrors(['invoice_not_found' => 'Customer details not found!']);
        }

        $html = view(_admin('invoice.create'), ['title' => 'Create Invoice', 'invoice' => $invoice, 'order' => $order])->render();

        $pdf = App::make('dompdf.wrapper');
        $path = 'storage/app/public/invoice/bm-'.$invoice->invoice_no.'-'.$invoice->order_no.'.pdf';
        PDF::loadHTML($html)->setPaper('a4', 'portrait')->setWarnings(false)->save( $path );

        $array = [
                    'first_name' => $order->order_customer[0]->first_name,
                    'last_name' => $order->order_customer[0]->last_name,
                    'invoice' => $invoice,
                    'email' => $order->order_customer[0]->email,
                    'file' => $path
                ];

        $this->sendMail( $array );

        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Send Invoice','status'=>'invoice', 'working_id' => $request->invoice_id]);

        return redirect()->back()->withErrors(['invoice_msg' => 'Invoice successfully sent!']);
        
    }


    public function sendMail( $array ) {

        $mailer = new Mailer();

        $data['to'] = $array['email'];
        $data['name'] = ucwords($array['first_name'].' '.$array['last_name']);
        $data['subject'] = 'Invoice';
        $data['message'] = View('emails.invoice', $array)->render();
        $data['files'] = $array['file'];

        $mailer->sendMail( $data );
    }


    public function print( Request $request, $id )
    {

        $invoice = Invoice::where('id', $id)->first();
        if( !$invoice )
            return redirect()->back()->withErrors(['invoice_not_found' => 'Invoice not found!']);

        $order = Order::with(['order_products', 'order_customer'])->find($invoice->order_id);
        if( !$order )
            return redirect()->back()->withErrors(['invoice_not_found' => 'Invoice not found!']);

        if( !$order->order_customer || count($order->order_customer) < 1 ) {

            return redirect()->back()->withErrors(['invoice_not_found' => 'Customer details not found!']);
        }

        $html = view(_admin('invoice.print'), ['title' => 'Print Invoice', 'invoice' => $invoice, 'order' => $order])->render();

        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Print Invoice','status'=>'invoice', 'working_id' => $id]);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->stream();
        
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
}
