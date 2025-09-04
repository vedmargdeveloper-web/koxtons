<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\model\ProductMrp;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductMrpImport;

class ProductMrpController extends Controller
{
      public function index()
{
    $title = 'Product-MRP';
    $productMrps = ProductMrp::orderBy('id', 'desc')->paginate(10); 
    return view('gift.admin.product_mrp.index', compact('productMrps','title'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $title = 'Add Product-MRP';
        return view('gift.admin.product_mrp.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            
            'model' => 'nullable|string|max:255',
            'item_name' => 'nullable|string|max:255',
            'qty' => 'nullable|integer',
            'qty_metric' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:100',
            'code' => 'nullable|string|max:100',
            'mfg_date' => 'nullable|date',
            'mrp' => 'nullable|numeric',
            'barcode' => 'nullable|string|max:255',
            'paper_size' => 'nullable|string|max:50',
        ]);

        ProductMrp::create($data);

        return redirect()->route('product-mrps.index')->with('success', 'Product MRP created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductMrp $productMrp)
    {
        return view('gift.admin.product_mrp.show', compact('productMrp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductMrp $productMrp)
    {
         $title = 'Add Product-MRP';
        return view('gift.admin.product_mrp.edit', compact('productMrp','title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductMrp $productMrp)
    {
        $data = $request->validate([
          
            'model' => 'nullable|string|max:255',
            'item_name' => 'nullable|string|max:255',
            'qty' => 'nullable|integer',
            'qty_metric' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:100',
            'code' => 'nullable|string|max:100',
            'mfg_date' => 'nullable|date',
            'mrp' => 'nullable|numeric',
            'barcode' => 'nullable|string|max:255',
            'paper_size' => 'nullable|string|max:50',
        ]);

        $productMrp->update($data);

        return redirect()->route('product-mrps.index')->with('success', 'Product MRP updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductMrp $productMrp)
    {
        $productMrp->delete();

        return redirect()->route('product_mrp.index')->with('success', 'Product MRP deleted successfully.');
    }

    public function import(Request $request)
{
    $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
    Excel::import(new ProductMrpImport, $request->file('file'));
    return redirect()->route('product-mrps.index')->with('success', 'Product MRPs imported successfully!');
}

   public function download()
    {
        $file = public_path('assets/files/product_mrp_sample.xls');

        if (file_exists($file)) {
            // Force download with the same name
            return response()->download($file, 'product_mrp_sample.xls');
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
}
