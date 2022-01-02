<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Pembelian;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PembelianController extends Controller
{
    public function index(){
        // $supplier = Supplier::orderBy('nama_supplier')->get();
        $tes = "woi";
        return view('pembelian.main',compact('tes'));
    }

    public function dataSupplier($id){
        $data = Supplier::where('id_supplier',$id)->get();
        return response()->json($data);
    }

    public function getDataSupplier(Request $request){
        $supplier = Supplier::orderBy('nama_supplier')->get();
        if ($request->ajax()) {
            return Datatables::of($supplier)
                ->addIndexColumn()
                ->addColumn('aksi', function ($supplier) {
                    $button = '<div class="btn-group">
                        <button type="button" class="btn btn-primary pilih" id="' . $supplier->id_supplier . '"  name ="edit">
                            <i class="fa fa-mouse-pointer"></i>
                        </button>
                        </div>';
                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function getDataProdukDetail($id){
        $data = Produk::where('id_produk',$id)->get();
        return response()->json($data);
    }
    public function getDataProduk(Request $request){
        $data = Produk::orderBy('nama_produk')->get();
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode_produk', function ($data) {
                    return '<h5><span class="badge badge-info">' . $data->kode_produk . ' </span></h5>';
                })
                ->addColumn('harga_beli', function ($data) {
                    return 'Rp. ' . format_uang($data->harga_beli);
                })
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="btn-group">
                        <button type="button" class="btn btn-primary pilihProduk" id="' . $data->id_produk . '"  name ="edit">
                            <i class="fa fa-mouse-pointer"></i>
                        </button>
                        </div>';
                    return $button;
                })
                ->rawColumns(['aksi','kode_produk','harga_beli'])
                ->make(true);
        }
    }

    public function getPembelian(Request $request){
        // $pembelian = DB::select('SELECT a.*,b.nama_supplier FROM pembelian a JOIN supplier b 
        // ON a.id_supplier = b.id_supplier ORDER BY created_at ASC');
        $pembelian = DB::select('SELECT a.*,b.nama_supplier FROM pembelian a JOIN supplier b 
        ON a.id_supplier = b.id_supplier ORDER BY created_at ASC');
        if($request->ajax()){
            return Datatables::of($pembelian)
            ->addIndexColumn()
            ->addColumn('created_at' , function ($pembelian){
                return tanggal_indonesia($pembelian->created_at);
            })
            ->addColumn('kode_pembelian' , function ($pembelian){
                $oke = '<div class="badge badge-info">'.$pembelian->kode_pembelian.'</div>';
                return $oke;
            })
            ->addColumn('aksi' , function ($pembelian){
                $button = '<div class="btn-group">
                        <button type="button" class="btn btn-primary detail" id="' . $pembelian->id_pembelian . '"  name ="edit">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-danger hapus" id="' . $pembelian->id_pembelian . '" name ="delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        </div>';
                    return $button;
            })
            ->rawColumns(['aksi','created_at','kode_pembelian'])
            ->make(true);
        };
    }

    public function addPembelian(Request $request){
        // $pembelian = new Pembelian();
        // $pembelian->id_supplier = $request->id_supplier;
        // $pembelian->total_item = 0;
        // $pembelian->total_harga = 0;
        // $pembelian->diskon = 0;
        // $pembelian->bayar = 0;
        // $pembelian->save();
        
        $data = Pembelian::create([
            'id_supplier' => $request->id_supplier,
            'kode_pembelian' => $request->kode_pembelian,
            'total_item' => 0,
            'total_harga' => 0,
            'diskon' => 0,
            'bayar' => 0,
        ]);

        if($data){
            return response()->json([
                'Message'=>'Berhasil tambah pembelian',
            ],200);
        }
    }

    public function getPembelianDetail($id){
        $data = DB::select('SELECT * FROM pembelian_detail WHERE id_pembelian = '.$id.' ');
        return response()->json($data);
    }

    public function dataPembelian(Request $request,$kode_pembelian){
        $data = DB::select('SELECT a.*,b.* FROM pembelian a JOIN supplier b on a.id_supplier = b.id_supplier
        WHERE kode_pembelian = '.$kode_pembelian.'');
        // $data = Pembelian::find($id);
        // dd($id);
        if($data){
            return response()->json([
                'Message' => 'Data pembelian didapat',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'GAGAL DAPAT DATA',
            ]);
        }
    }

    public function deletePembelian(Request $request)
    {
        $data = Pembelian::where('id_pembelian', $request->id_pembelian);
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
    public function deletePembelianFromBatal(Request $request)
    {
        $data = Pembelian::where('kode_pembelian', $request->kode_pembelian);
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
