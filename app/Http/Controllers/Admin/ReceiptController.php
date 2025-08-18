<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\ProductMrp;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
  public function printReceipts(Request $request)
    {
        // Example: fetch multiple receipts (you can filter by IDs or date)
        $receipts = ProductMrp::whereIn('id', $request->ids ?? [])->get();

        return view('gift.admin.receipts.print', compact('receipts'));
    }

    // Print single receipt
    public function printReceipt($id)
    {
        $receipt = ProductMrp::findOrFail($id);

        return view('gift.admin.receipts.print', ['receipts' => collect([$receipt])]);
    }
}
