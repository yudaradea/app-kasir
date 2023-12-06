<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         
        if ($request->ajax()) {
            $data = Product::orderBy('id', 'desc');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('aksi', function($data){
                        return '
                         <button onclick="editForm(`'. route('product.update', $data->id) .'`)" class="btn btn-info"><i class="fa fa-edit"></i></button>
                         <button onclick="deleteData(`'. route('product.destroy', $data->id) .'`)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        ';
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);
        }

        $kategori = Category::all()->pluck('nama_kategori', 'id');
        return view('pages.product.index', compact('kategori'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_produk' => 'required|max:50|unique:products,nama_produk,',
            'id_kategory' => 'required',
            'merk' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',


        ], [
            'nama_produk.required' => 'nama produk tidak boleh kosong',
            'nama_produk.unique' => 'nama produk sudah ada dalam database'

        ]);

       
        Product::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
