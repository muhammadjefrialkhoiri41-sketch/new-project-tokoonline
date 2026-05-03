<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    //  TAMPILIN KERANJANG
    public function index()
    {
        $customerId = Auth::guard('customer')->id();

        $keranjang = Keranjang::where('customer_id', $customerId)->first();

        $items = $keranjang 
            ? $keranjang->items()->with('produk')->get() 
            : collect();

        return view('frontend.v_keranjang.index', compact('items'));
    }

    //  TAMBAH KE KERANJANG
    public function tambah(Request $request, $id)
    {
        $customerId = Auth::guard('customer')->id();

        // validasi qty
        $qty = $request->qty ?? 1;

        $produk = Produk::findOrFail($id);

        // ambil / buat keranjang
        $keranjang = Keranjang::firstOrCreate([
            'customer_id' => $customerId
        ]);

        // cek apakah produk sudah ada di keranjang
        $item = KeranjangItem::where('keranjang_id', $keranjang->id)
            ->where('produk_id', $id)
            ->first();

        if ($item) {
            // kalau sudah ada → tambah qty
            $item->qty += $qty;
            $item->save();
        } else {
            // kalau belum → buat baru
            KeranjangItem::create([
                'keranjang_id' => $keranjang->id,
                'produk_id' => $id,
                'qty' => $qty
            ]);
        }

        return back()->with('success', 'Produk masuk keranjang');
    }

    //  HAPUS ITEM
    public function hapus($id)
    {
        $item = KeranjangItem::findOrFail($id);

        $item->delete();

        return back()->with('success', 'Item dihapus');
    }
}