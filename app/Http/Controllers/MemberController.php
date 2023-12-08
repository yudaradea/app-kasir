<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Yajra\DataTables\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Member::orderBy('id', 'asc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode_member', function ($data) {
                    return '<span class="label label-success" style="font-size: 13px;">' . $data->kode_member . '</span>';
                })
                ->addColumn('aksi', function ($data) {
                    return '
                         <button type="button" onclick="editForm(`' . route('member.update', $data->id) . '`)" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button>
                         <button type="button" onclick="cetakBarcode(`' . route('member.cetak.barcode', $data->id) . '`)" class="btn btn-info btn-xs"><i class="fa fa-id-card"></i></button>
                         <button type="button" onclick="deleteData(`' . route('member.destroy', $data->id) . '`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                        ';
                })
                ->rawColumns(['aksi', 'kode_member'])
                ->make(true);
        }
        return view('pages.member.index');
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
            'nama' => 'required|max:50|unique:products,nama_produk,',
            'alamat' => 'required',
            'telepon' => 'required',

        ], [
            'nama.required' => 'nama produk tidak boleh kosong',
            'nama.unique' => 'nama produk sudah ada dalam database'

        ]);

        $kode_member = IdGenerator::generate(['table' => 'members', 'field' => 'kode_member', 'length' => 7, 'prefix' => date('dmy'), 'reset_on_prefix_change' => true]);

        $request['kode_member'] = $kode_member;

        Member::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Member::find($id);

        return response()->json($kategori);
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
        $member = Member::find($id);
        $validateData = $request->validate([
            'nama' => 'required|max:50|unique:products,nama_produk,' . $member->id,
            'alamat' => 'required',
            'telepon' => 'required',

        ], [
            'nama.required' => 'nama produk tidak boleh kosong',
            'nama.unique' => 'nama produk sudah ada dalam database'

        ]);


        $member->update($request->all());

        return response()->json('Data berhasil diubah', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Member::find($id)->delete();

        return response()->json('Data berhasil dihapus', 200);
    }

    public function cetakBarcode(Request $request, $id)
    {

        $member= Member::find($id);
        
        $customPaper = array(0,0,153.071,243.78);

         $pdf = Pdf::loadView('pages.member.cetak', compact('member'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('Member '.$member->nama.'.pdf', array("Attachment" => false));
        
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
