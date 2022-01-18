<?php

namespace App\Http\Controllers;

use App\Models\PembelianDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PembelianDetailController extends Controller
{

    public function dt_pembelianDetail(Request $request){
        //  $data = PembelianDetail::orderBy('id_produk')->get();
        $id = $request->id_pembelian;
        $data = DB::select('SELECT 
        a.id_pembelian_detail,a.id_pembelian,a.id_produk,c.kode_produk,c.nama_produk,a.harga_beli,a.jumlah,a.subtotal
        FROM pembelian_detail a join pembelian b on a.id_pembelian = b.id_pembelian JOIN
        produk c on a.id_produk = c.id_produk WHERE a.id_pembelian = '.$id.' ');
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
                        <button type="button" class="btn btn-primary deletePembelianDetail" id="' . $data->id_pembelian . '"  name ="edit">
                            <i class="fa fa-mouse-pointer"></i>
                        </button>
                        </div>';
                    return $button;
                })
                ->rawColumns(['aksi','kode_produk','harga_beli'])
                ->make(true);
        }
    }

    public function addDetailProdukPembelian(Request $request){
        $produk = Produk::where('id_produk',$request->id_produk)->first();
        if($produk){
            $data = new PembelianDetail;
            $data->id_pembelian = $request->id_pembelian;
            $data->id_produk = $produk->id_produk;
            $data->harga_beli = $produk->harga_beli;
            $data->jumlah = 1;
            $data->subtotal = $produk->harga_beli;
            $data->save();

            return response()->json([
                'message' => 'Berhasil menyimpan'],200);
        } else {
            return response()->json(['Message' => 'Gagal Menyimpan'],404);
        }
    }
}
