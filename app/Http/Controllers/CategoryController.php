<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::orderBy('id', 'desc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    return '
                         <button onclick="editForm(`' . route('category.update', $data->id) . '`)" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>
                         <button onclick="deleteData(`' . route('category.destroy', $data->id) . '`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                        ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('pages.category.category');
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
            'nama_kategori' => 'required|max:50|unique:categories,nama_kategori,',

        ], [
            'nama_kategori.required' => 'nama kategori tidak boleh kosong',
            'nama_kategori.unique' => 'nama kategori sudah ada dalam database'

        ]);

        $kategori = new Category();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Category::find($id);

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
        $validateData = $request->validate([
            'nama_kategori' => 'required|max:50|unique:categories,nama_kategori,',

        ], [
            'nama_kategori.required' => 'nama kategori tidak boleh kosong',
            'nama_kategori.unique' => 'nama kategori sudah ada dalam database'

        ]);

        $kategori = Category::find($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->update();

        return response()->json('Data berhasil diubah', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::find($id)->delete();

        return response()->json('Data berhasil dihapus', 200);
    }
}
