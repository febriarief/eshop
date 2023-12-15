<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.products.product-list', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.product-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->only([
            'image',
            'name',
            'description',
            'price'
        ]);

        $rules = [
            'image'         => 'required|image',
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required'
        ];

        $errorMessages = [
            'image.required'        => 'Upload gambar terlebih dahulu.',
            'image.image'           => 'Format gambar yang diupload tidak didukung.',
            'name.required'         => 'Kolom isian nama tidak boleh kosong',
            'description.required'  => 'Kolom isian deskripsi boleh kosong',
            'price.required'        => 'Kolom isian harga tidak boleh kosong'
        ];

        $validator = Validator::make($input, $rules, $errorMessages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['msg' => $validator->errors()->first()])->withInput($request->input());
        }

        try {
            DB::beginTransaction();

            $file = $request->file('image');
            $filename = $file->getClientOriginalName();

            $input['image'] = $filename;
            Product::create($input);
            $file->move(storage_path('app/public'), $filename);

            DB::commit();
            return redirect()->route('admin-products-index')->with('message', 'Data produk berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => $e->getMessage()])->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        return view('admin.products.product-form', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->only([
            'image',
            'name',
            'description',
            'price'
        ]);

        $rules = [
            'image'         => 'nullable|image',
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required'
        ];

        $errorMessages = [
            'image.required'        => 'Upload gambar terlebih dahulu.',
            'image.image'           => 'Format gambar yang diupload tidak didukung.',
            'name.required'         => 'Kolom isian nama tidak boleh kosong',
            'description.required'  => 'Kolom isian deskripsi boleh kosong',
            'price.required'        => 'Kolom isian harga tidak boleh kosong'
        ];

        $validator = Validator::make($input, $rules, $errorMessages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['msg' => $validator->errors()->first()])->withInput($request->input());
        }

        try {
            DB::beginTransaction();
            $product = Product::where('id', $id)->first();

            if ($request->filled('gambar')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $file->move(storage_path('app/public'), $filename);

                $input['image'] = $filename;
            } else {
                $input['image'] = $product->image;
            }

            $product->update($input);


            DB::commit();
            return redirect()->route('admin-products-index')->with('message', 'Data produk berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => $e->getMessage()])->withInput($request->input());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin-products-index')->with('message', 'Data produk berhasil dihapus');
    }
}
