<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // TAMPILIN KERANJANG
    public function index()
    {
        $customerId = Auth::guard('customer')->id();

        $keranjang = Keranjang::where('customer_id', $customerId)->first();

        $items = $keranjang
            ? $keranjang->items()->with('produk')->get()
            : collect();

        return view('frontend.v_keranjang.index', compact('items'));
    }

    // TAMBAH KE KERANJANG
    public function tambah(Request $request, $id)
    {
        $customerId = Auth::guard('customer')->id();

        // VALIDASI QTY
        $qty = $request->qty ?? 1;

        $produk = Produk::findOrFail($id);

        // AMBIL / BUAT KERANJANG
        $keranjang = Keranjang::firstOrCreate([
            'customer_id' => $customerId
        ]);

        // CEK APAKAH PRODUK SUDAH ADA
        $item = KeranjangItem::where('keranjang_id', $keranjang->id)
            ->where('produk_id', $id)
            ->first();

        if ($item) {

            // TAMBAH QTY
            $item->qty += $qty;
            $item->save();

        } else {

            // BUAT ITEM BARU
            KeranjangItem::create([
                'keranjang_id' => $keranjang->id,
                'produk_id' => $id,
                'qty' => $qty
            ]);
        }

        return back()->with('success', 'Produk masuk keranjang');
    }

    // HAPUS ITEM
    public function hapus($id)
    {
        $item = KeranjangItem::findOrFail($id);

        $item->delete();

        return back()->with('success', 'Item dihapus');
    }

    // HALAMAN CHECKOUT
    public function checkoutForm()
    {
        return view('frontend.v_keranjang.checkout');
    }

    // CHECKOUT / PESAN
    public function checkout(Request $request)
    {
        $customerId = Auth::guard('customer')->id();

        $keranjang = Keranjang::where('customer_id', $customerId)->first();

        // CEK KERANJANG
        if (!$keranjang) {
            return back()->with('error', 'Keranjang kosong');
        }

        $items = $keranjang->items()->with('produk')->get();

        // CEK ITEM
        if ($items->count() == 0) {
            return back()->with('error', 'Keranjang kosong');
        }

        // SIMPAN KE PESANAN
        foreach ($items as $item) {

            Pesanan::create([
                'customer_id'  => $customerId,
                'produk_id'    => $item->produk_id,
                'jumlah'       => $item->qty,
                'total_harga'  => $item->produk->harga * $item->qty,
                'metode_bayar' => $request->metode_bayar,
                'status'       => 'diproses'
            ]);
        }

        // HAPUS ITEM KERANJANG
        KeranjangItem::where('keranjang_id', $keranjang->id)->delete();

        return redirect()->route('cek.pesanan')
            ->with('success', 'Pesanan berhasil dibuat');
    }
}