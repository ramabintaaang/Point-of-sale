<?php

namespace App\Http\Controllers;

use App\Models\PembelianDetail;
use App\Models\Produk;
use Illuminate\Http\Request;

class PembelianDetailController extends Controller
{
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
