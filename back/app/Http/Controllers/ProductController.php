<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Imports\ProductImport;
use App\Models\Product;
use \GuzzleHttp\Psr7\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use mysql_xdevapi\Table;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return Inertia::render('Products', [
            'products' => $products,
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileImportExport()
    {
        return view('file-import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileImport(Request $request)
    {
        Excel::import(new ProductImport, $request->file('file'));
        return back();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileExport()
    {
        return Excel::download(new ProductExport, 'users-collection.xlsx');
    }

    /**
     * @throws MpdfException
     */
    public function exportToPdf(Request $request)
    {
//        $request->validate([
//            'items' => 'required'
//        ]);

        //        return env('APP_URL');

        require_once __DIR__ . '/../../../vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();

        $mpdf->Bookmark('Start of the document');
        $mpdf->WriteHTML('<div>Section 1 text</div>');

        return $mpdf->Output();
    }

    public function exportToXml(Request $request)
    {
        $request->validate([
            'items' => 'required'
        ]);

        $xml = new \DOMDocument();
        $products = $xml->createElement('Products_Table');
        $xml->appendChild($products);

        foreach ($request->items as $item) {
            $product = $xml->createElement('Product');
            $products->appendChild($product);

            $name = $xml->createElement('Name', $item['name']);
            $product->appendChild($name);
            $price = $xml->createElement('Price', $item['price']);
            $product->appendChild($price);
            $description = $xml->createElement('Description', $item['description']);
            $product->appendChild($description);
//            $created_at = $xml->createElement('Created_at', $item['created_at']);
//            $product->appendChild($created_at);
//            $updated_at = $xml->createElement('Updated_at', $item['updated_at']);
//            $product->appendChild($updated_at);
        }

        return $xml->saveXML();
    }

    public function exportToJson(Request $request)
    {
        $request->validate([
            'items' => 'required'
        ]);

        return json_encode($request->items);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return Inertia::render('Product/Show', [
            'product' => $product->only('id', 'name', 'price', 'description', 'is_active'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $quantity = '';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
