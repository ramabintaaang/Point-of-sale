<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PDF;

class MemberController extends Controller
{
    public function index()
    {
        // $data = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        return view('member.main');
    }
    public function getMember(Request $request)
    {
        $data = Member::all();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('select_all', function ($data) {
                    return '<input type="checkbox" name="id_member[]" value="' . $data->id_member . '">';
                })
                ->addColumn('kode_member', function ($data) {
                    return '<h5><span class="badge badge-info">' . $data->kode_member . ' </span></h5>';
                })
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="btn-group">
                        <button type="button" class="btn btn-primary edit" id="' . $data->id_member . '"  name ="edit">
                            <i class="fas fa-pen-alt"></i>
                        </button>
                        <button type="button" class="btn btn-danger hapus" id="' . $data->id_member . '" name ="delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        </div>';
                    return $button;
                })
                ->rawColumns(['aksi', 'kode_member', 'select_all'])
                ->make(true);
        }
    }
    public function addMember(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|min:3',
                'alamat' => 'required',
                'telepon' => 'required|integer',
                // 'alamat' => 'required', 'min:3',
                // 'telepon' => 'required', 'min:3',
                // 'nama' => 'required', 'min:3'
            ],
            [
                'nama.required' => 'Nama tidak boleh kosong',
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
            $req = Str::upper(Str::substr($request->nama, 0, 3));
            $a = generateMember($request->nama, $request->creted_at);
            $tgl = Str::substr(date('d-m-Y'), 0, 2);
            $bln = Str::substr(date('d-m-Y'), 3, 2);
            $thn = Str::substr(date('d-m-Y'), 8, 2);
            $itungbaris = DB::select("SELECT COUNT(kode_member) AS kode FROM member WHERE kode_member LIKE '%$req%' ");
            // dd($date2, $tgl);
            if ($itungbaris[0]->kode == 0) {
                $request['kode_member'] = $a . $tgl . $bln . $thn . '-' . '1';

                // dd($req, $itungbaris[0]->kode, $h);
            } else {
                $itungmax = DB::select("SELECT MAX(kode_member) AS kode FROM member WHERE kode_member LIKE '%$req%' ");
                $hasil = $itungmax[0]->kode;
                $akhir = Str::substr($hasil, 11, 3);
                $value = $a . $tgl . $bln . $thn . '-' . ($akhir + 1);
                $request['kode_member'] =  $value;
            }

            $data = Member::create(
                $request->all()
            );
            if ($data) {
                return response()->json([
                    'Message' => 'Data berhasil ditambah',
                ], 200);
            }
        }
    }

    public function editMember($id)
    {

        $data = Member::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function updateMember(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|min:3|max:40',
                'alamat' => 'required',
                'telepon' => 'required|integer',
                // 'alamat' => 'required', 'min:3',
                // 'telepon' => 'required', 'min:3',
                // 'nama' => 'required', 'min:3'
            ],
            [
                'nama.required' => 'Nama tidak boleh kosong',
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
            $data = Member::where('id_member', $request->id_member)
                ->update([
                    'nama' => $request->nama,
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

    public function deleteMember($id, Request $request)
    {
        $data = Member::find($id);
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

    public function deleteSelectMember(Request $request)
    {
        foreach ($request->id_member as $id) {
            $data = Member::find($id);
            $simpan = $data->delete();
        }
        if ($simpan) {
            return response()->json([
                'Message' => 'Berhasil dihapus'
            ]);
        }
    }


    public function cetakMember(Request $request)
    {
        $datamember = collect(array());
        foreach ($request->id_member as $id) {
            $data = Member::find($id);
            $datamember[] = $data;
        }
        $datamember =  $datamember->chunk(2);

        $index = 1;
        $pdf = PDF::loadView('member.barcode', compact('datamember', 'index'));
        $pdf->setPaper(array(0, 0, 566.93, 850.39), 'portrait');
        return $pdf->stream('member.pdf');
    }
}
