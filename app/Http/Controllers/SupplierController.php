<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        // $data = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        return view('supplier.main');
    }
    public function getSupplier(Request $request)
    {
        $data = Supplier::all();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('select_all', function ($data) {
                    return '<input type="checkbox" name="id_supplier[]" value="' . $data->id_supplier . '">';
                })
                // ->addColumn('kode_member', function ($data) {
                //     return '<h5><span class="badge badge-info">' . $data->kode_supplier . ' </span></h5>';
                // })
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="btn-group">
                        <button type="button" class="btn btn-primary edit" id="' . $data->id_supplier . '"  name ="edit">
                            <i class="fas fa-pen-alt"></i>
                        </button>
                        <button type="button" class="btn btn-danger hapus" id="' . $data->id_supplier . '" name ="delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        </div>';
                    return $button;
                })
                ->rawColumns(['aksi', 'select_all'])
                ->make(true);
        }
    }
    public function addSupplier(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'nama_supplier' => 'required|min:3',
                'alamat' => 'required',
                'telepon' => 'required|integer',
                // 'alamat' => 'required', 'min:3',
                // 'telepon' => 'required', 'min:3',
                // 'nama' => 'required', 'min:3'
            ],
            [
                'nama_supplier.required' => 'Nama tidak boleh kosong',
                'alamat.required' => 'alamat tidak boleh kosong',
                'telepon.required' => 'telepon tidak boleh kosong',
                'nama_supplier.min' => 'Nama minimal 3 huruf',
                'telepon.integer' => 'telepon hanya boleh input angka',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 500);
        } else {

            $data = Supplier::create(
                $request->all()
            );
            if ($data) {
                return response()->json([
                    'Message' => 'Data berhasil ditambah',
                ], 200);
            }
        }
    }

    public function editSupplier($id)
    {

        $data = Supplier::where('id_supplier', $id)->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function updateSupplier(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_supplier' => 'required|min:3|max:40',
                'alamat' => 'required',
                'telepon' => 'required|integer',
                // 'alamat' => 'required', 'min:3',
                // 'telepon' => 'required', 'min:3',
                // 'nama' => 'required', 'min:3'
            ],
            [
                'nama_supplier.required' => 'Nama tidak boleh kosong',
                'alamat.required' => 'alamat tidak boleh kosong',
                'telepon.required' => 'telepon tidak boleh kosong',
                'nama.min' => 'Nama minimal 3 huruf',
                'telepon.integer' => 'telepon hanya boleh input angka',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 500);
        } else {
            $data = Supplier::where('id_supplier', $request->id_supplier)
                ->update([
                    'nama_supplier' => $request->nama_supplier,
                    'alamat' => $request->alamat,
                    'telepon' => $request->telepon,
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

    public function deleteSupplier($id, Request $request)
    {
        $data = Supplier::where('id_supplier', $request->id);
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
