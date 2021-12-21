<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $data = Kategori::all();
        return view('Kategori.main', compact($data));
    }
    public function getKategori(Request $request)
    {
        $data = Kategori::orderBy('id_kategori', 'desc')->get();
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="btn-group">
                        <button type="button" class="btn btn-primary edit" id="' . $data->id_kategori . '"  name ="edit">
                            <i class="fas fa-pen-alt"></i>
                        </button>
                        <button type="button" class="btn btn-danger hapus" id="' . $data->id_kategori . '" name ="delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        </div>';
                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }



    public function addKategori2(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 500);
        } else {
            $data = Kategori::create([
                'nama_kategori' => $request->nama_kategori,
            ]);
            if ($data) {
                return response()->json([
                    'Message' => 'Data berhasil ditambah',
                ]);
            }
        }
    }

    public function editKategori2($id)
    {
        $data = Kategori::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function updateKategori2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'Pesan error' => $validator->errors()
            ]);
        } else {
            $data = Kategori::where('id_kategori', $request->id_kategori)
                ->update([
                    'nama_kategori' => $request->nama_kategori,
                ]);

            if ($data) {
                return response()->json([
                    'Message' => 'Update berhasil',
                ]);
            } else {
                return response()->json([
                    'Message' => 'gagal update'
                ]);
            }
        }
    }

    public function deleteKategori2($id, Request $request)
    {
        $data = Kategori::find($id);
        $simpan = $data->delete($request->all());
        if ($simpan) {
            return response()->json([
                'Message' => 'Berhasil hapus data'
            ]);
        } else {
            return response()->json([
                'Message' => 'Gagal hapus data'
            ]);
        }
    }
}
