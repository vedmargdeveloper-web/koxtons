<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\model\ProductMrp;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
  public function printReceipts(Request $request)
    {
        $title = 'KOKtons® Receipts';
        $receipts = ProductMrp::whereIn('id', $request->ids ?? [])->get();

        return view('gift.admin.receipts.print', compact('receipts', 'title'));
    }

    // Print single receipt
    public function printReceipt($id)
    { 
        $title = 'KOKtons® Receipts';
        $receipt = ProductMrp::findOrFail($id);

        return view('gift.admin.receipts.print', ['receipts' => collect([$receipt]) , 'title']);
    }
}
