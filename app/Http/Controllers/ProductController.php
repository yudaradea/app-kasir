<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Product::leftJoin('categories', 'categories.id', 'products.id_kategory')
                ->select('products.*', 'nama_kategori')
                ->orderBy('kode_produk', 'asc')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode_produk', function ($data) {
                    return '<span class="label label-success" style="font-size: 13px;">' . $data->kode_produk . '</span>';
                })
                ->addColumn('select_all', function ($data) {
                    return '
                    <input type="checkbox" name="id_produk[]" value="' . $data->id . '" >
                    ';
                })
                ->addColumn('harga_beli', function ($data) {
                    return "Rp" . format_uang($data->harga_beli);
                })
                ->addColumn('harga_jual', function ($data) {
                    return "Rp" . format_uang($data->harga_jual);
                })
                ->addColumn('stok', function ($data) {
                    return format_uang($data->stok);
                })
                ->addColumn('aksi', function ($data) {
                    return '
                         <button type="button" onclick="editForm(`' . route('product.update', $data->id) . '`)" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></button>
                         <button type="button" onclick="cetakBarcode(`' . route('produk.cetak.barcode', $data->id) . '`)" class="btn btn-info btn-xs"><i class="fa fa-barcode"></i></button>
                         <button type="button" onclick="deleteData(`' . route('product.destroy', $data->id) . '`)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                        ';
                })
                ->rawColumns(['aksi', 'kode_produk', 'select_all'])
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

        $kode_produk = IdGenerator::generate(['table' => 'products', 'field' => 'kode_produk', 'length' => 7, 'prefix' => "P", 'reset_on_prefix_change' => true]);

        $request['kode_produk'] = $kode_produk;

        Product::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Product::find($id);

        return response()->json($produk);
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
        $produk = Product::find($id);
        $validateData = $request->validate([
            'nama_produk' => 'required|max:50|unique:products,nama_produk,' . $produk->id,
            'id_kategory' => 'required',
            'merk' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',


        ], [
            'nama_produk.required' => 'nama produk tidak boleh kosong',
            'nama_produk.unique' => 'nama produk sudah ada dalam database'

        ]);


        $produk->update($request->all());

        return response()->json('Data berhasil diubah', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::find($id)->delete();

        return response()->json('Data berhasil dihapus', 200);

        // $notification = array(
        //     'message' => 'kategori berhasil dihapus',
        //     'alert-type' => 'success'
        // );
        // return redirect()->back()->with($notification);
    }

    public function hapusSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            Product::find($id)->delete();
        }

        return response()->json('Data berhasil dihapus', 200);
    }

    public function cetakBarcode(Request $request, $id)
    {

        $produk = Product::find($id);
        

         $pdf = Pdf::loadView('pages.product.cetak', compact('produk'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf', array("Attachment" => false));
        
        // $dataProduk = array();

        // foreach ($request->id_produk as $id) {
        //     $produk = Product::find($id);
        //     $dataProduk[] = $produk;
        // }

        // $pdf = Pdf::loadView('pages.product.cetak', compact('dataProduk'));
        // $pdf->setPaper('a4', 'potrait');
        // return $pdf->stream('produk.pdf', array("Attachment" => false));
    }
}
