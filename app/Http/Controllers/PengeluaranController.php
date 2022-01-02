<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    public function index(){
        return view('pengeluaran.main');
    }
    
    public function getPengeluaran(Request $request)
    {
        $data = Pengeluaran::all();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    return tanggal_indonesia($data->created_at);
                })
                ->addColumn('nominal', function ($data) {
                    return 'Rp. ' . format_uang($data->nominal) ;
                })
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="btn-group">
                        <button type="button" class="btn btn-primary edit" id="' . $data->id_pengeluaran . '"  name ="edit">
                            <i class="fas fa-pen-alt"></i>
                        </button>
                        <button type="button" class="btn btn-danger hapus" id="' . $data->id_pengeluaran . '" name ="delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        </div>';
                    return $button;
                })
                ->rawColumns(['aksi', 'created_at'])
                ->make(true);
        }
    }
    public function addPengeluaran(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'deskripsi' => 'required',
                'nominal' => 'required|integer',
            ],
            [
                'deskripsi.required' => 'Deskripsi tidak boleh kosong',
                'nominal.required' => 'nominal tidak boleh kosong',
                'nominal.integer' => 'nominal harus berisi angka',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 500);
        } else {

            $data = Pengeluaran::create(
                $request->all()
            );
            if ($data) {
                return response()->json([
                    'Message' => 'Data berhasil ditambah',
                ], 200);
            }
        }
    }

    public function editPengeluaran($id)
    {

        $data = Pengeluaran::where('id_pengeluaran', $id)->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function updatePengeluaran(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'deskripsi' => 'required',
                'nominal' => 'required|integer',
            ],
            [
                'deskripsi.required' => 'Deskripsi tidak boleh kosong',
                'nominal.required' => 'nominal tidak boleh kosong',
                'nominal.integer' => 'nominal harus berisi angka',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 500);
        } else {
            $data = Pengeluaran::where('id_pengeluaran', $request->id_pengeluaran)
                ->update([
                    'deskripsi' => $request->deskripsi,
                    'nominal' => $request->nominal,
                ]);

            if ($data) {
                return response()->json([
                    'Message' => 'Update berhasil',
                ],200);
            } else {
                return response()->json([
                    'Message' => 'gagal update'
                ],500);
            }
        }
    }

    public function deletePengeluaran(Request $request)
    {
        $data = Pengeluaran::where('id_Pengeluaran', $request->id);
        $simpan = $data->delete($request->all());
        if ($simpan) {
            return response()->json([
                'Message' => 'Berhasil hapus data'
            ],200);
        } else {
            return response()->json([
                'Message' => 'Gagal hapus data'
            ],500);
        }
    }
}
