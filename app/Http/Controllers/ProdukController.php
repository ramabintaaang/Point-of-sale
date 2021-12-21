<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PDF;


class ProdukController extends Controller
{
    public function index()
    {
        $data = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        return view('produk.main', compact('data'));
    }

    // public function optionKategori(Request $request)
    // {
    //     $data = [];

    //     if ($request->has('option_kategori')) {
    //         $search = $request->option_kategori;
    //         $data = Kategori::select("id_kategori", "nama_kategori")
    //             ->where('nama_kategori', 'LIKE', "%$search%")
    //             ->get();
    //     }
    //     return response()->json($data);
    // }


    public function getProduk(Request $request)
    {
        $data = DB::select('SELECT a.* , b.nama_kategori FROM produk a LEFT JOIN kategori b on a.id_kategori = b.id_kategori 
        ORDER BY a.id_produk DESC');

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('select_all', function ($data) {
                    return '<input type="checkbox" name="id_produk[]" value="' . $data->id_produk . '">';
                })
                ->addColumn('kode_produk', function ($data) {
                    return '<h5><span class="badge badge-info">' . $data->kode_produk . ' </span></h5>';
                })
                ->addColumn('harga_beli', function ($data) {
                    return 'Rp. ' . format_uang($data->harga_beli);
                })
                ->addColumn('harga_jual', function ($data) {
                    return 'Rp. ' . format_uang($data->harga_jual);
                })
                ->addColumn('stok', function ($data) {
                    if ($data->stok <= 10) {
                        return '<span class="badge badge-danger">' . $data->stok . '</span>';
                    } else {
                        return '<span class="badge badge-success">' . $data->stok . '</span>';
                    }
                })
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="btn-group">
                        <button type="button" class="btn btn-primary edit" id="' . $data->id_produk . '"  name ="edit">
                            <i class="fas fa-pen-alt"></i>
                        </button>
                        <button type="button" class="btn btn-danger hapus" id="' . $data->id_produk . '" name ="delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        </div>';
                    return $button;
                })
                ->rawColumns(['aksi', 'kode_produk', 'stok', 'select_all'])
                ->make(true);
        }
    }



    public function addProduk(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 500);
        } else {
            $a = generateProduk($request->merk);
            // $produk = Produk::latest()->first();
            $itungbaris = DB::select("SELECT COUNT(kode_produk) AS kode FROM produk WHERE kode_produk LIKE '%$a%' ");

            if ($itungbaris[0]->kode == 0) {
                $h = $request['kode_produk'] = generateProduk($request->merk) . 1;
                // dd($h, $itungbaris[0]->kode);
                $request['kode_produk'] =  $h;
            } else {
                // $itungmax = DB::table('produk')->select('kode_produk')->max('kode_produk')
                //     ->where('kode_produk', 'LIKE', '%' . $a . '%')
                //     ->get();
                $itungmax = DB::select("SELECT MAX(kode_produk) AS kode FROM produk WHERE kode_produk LIKE '%$a%' ");
                // $hasil = $itungmax->kode;
                $hasil = $itungmax[0];
                // $oke = $a;
                $hasil2 = substr($hasil->kode, 5, 10) + 1;
                // dd($a, substr($hasil->kode, 5, 10) + 1, $hasil->kode . 1, $a . $hasil2);
                // dd($itungmax, $a, substr($hasil->kode, 5, 1));
                $request['kode_produk'] =  $a . $hasil2;
            }

            $data = Produk::create(
                $request->all()
                // 'kode_produk' => $hh,
                // 'nama_produk' => $request->nama_produk,
                // 'id_kategori' => $request->id_kategori,
                // 'merk' => $request->merk,
                // 'harga_beli' => $request->harga_beli,
                // 'harga_jual' => $request->harga_jual,
                // 'diskon' => $request->diskon,
                // 'stok' => $request->stok,
            );
            if ($data) {
                return response()->json([
                    'Message' => 'Data berhasil ditambah',
                ]);
            }
        }
    }

    public function editProduk($id)
    {
        // $data = DB::table('produk')
        //     ->leftJoin('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
        //     ->select('produk.*', 'kategori.nama_kategori')
        //     ->find('id_produk', $id)
        //     ->get();
        // $data = Produk::find($id);
        $data = DB::select('SELECT a.*, b.nama_kategori FROM produk a LEFT JOIN kategori b ON a.id_kategori = b.id_kategori where id_produk = ' . $id . ' ');
        return response()->json([
            'data' => $data,
        ]);
    }

    public function updateProduk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'nama_kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'Pesan error' => $validator->errors()
            ]);
        } else {
            $data = Produk::where('id_produk', $request->id_produk)
                ->update([
                    'id_kategori' => $request->id_kategori,
                    'nama_produk' => $request->nama_produk,
                    'merk' => $request->merk,
                    'harga_beli' => $request->harga_beli,
                    'harga_jual' => $request->harga_jual,
                    'diskon' => $request->diskon,
                    'stok' => $request->stok,
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

    public function deleteProduk($id, Request $request)
    {
        $data = Produk::find($id);
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

    public function deleteSelectProduk(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $data = Produk::find($id);
            $simpan = $data->delete();
        }
        if ($simpan) {
            return response()->json([
                'Message' => 'Berhasil dihapus'
            ]);
        }
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $data = Produk::find($id);
            $dataproduk[] = $data;
        }

        $index = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'index'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('produk.pdf');
    }
}
