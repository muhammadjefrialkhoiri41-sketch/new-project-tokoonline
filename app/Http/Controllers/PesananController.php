<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Produk;

class PesananController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BACKEND: LIST PESANAN (ADMIN)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $pesanan = Pesanan::with('produk')->latest()->get();
        return view('backend.v_pesanan.index', compact('pesanan'));
    }

    /*
    |--------------------------------------------------------------------------
    | FRONTEND: SIMPAN PESANAN
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        // 🔥 WAJIB LOGIN
        if (!auth('customer')->check()) {
            return redirect('/')->with('error', 'Harus login dulu!');
        }

        $request->validate([
            'produk_id'    => 'required',
            'jumlah'       => 'required|integer|min:1',
            'metode_bayar' => 'required|string',
        ]);

        $customer = auth('customer')->user();

        // 🔥 CEK PROFIL
        if (!$customer->phone || !$customer->address) {
            return redirect('/profile')->with('error', 'Lengkapi profil dulu!');
        }

        $produk = Produk::findOrFail($request->produk_id);

        // 🔥 CEK STOK
        if ($request->jumlah > $produk->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia');
        }

        $totalHarga = $produk->harga * $request->jumlah;

        // 🔥 SIMPAN PESANAN
        Pesanan::create([
            'customer_id'  => $customer->id,
            'produk_id'    => $request->produk_id,

            'nama_pembeli' => $customer->name,
            'email'        => $customer->email,
            'no_hp'        => $customer->phone,
            'alamat'       => $customer->address,

            'jumlah'       => $request->jumlah,
            'total_harga'  => $totalHarga,
            'metode_bayar' => $request->metode_bayar,
            'status'       => 'menunggu',
        ]);


        // 🔥 KURANGI STOK
        $produk->decrement('stok', $request->jumlah);

        return redirect()->route('cek.pesanan')
            ->with('success', 'Pesanan berhasil dibuat');
    }

    /*
    |--------------------------------------------------------------------------
    | FRONTEND: CEK PESANAN (HANYA MILIK USER)
    |--------------------------------------------------------------------------
    */
    public function cekPesanan()
    {
        
        if (!auth('customer')->check()) {
            return redirect('/')->with('error', 'Harus login dulu!');
        }

        $customer = auth('customer')->user();

        $pesanan = Pesanan::with('produk')
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('frontend.cek_pesanan', compact('pesanan'));
      
    }


    /*
    |--------------------------------------------------------------------------
    | FRONTEND: DETAIL PESANAN
    |--------------------------------------------------------------------------
    */
       public function detail($id)
    {
        $customer = auth('customer')->user();

        $pesanan = Pesanan::with('produk')
            ->where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        return view('frontend.detail_pesanan', [
            'pesanan' => $pesanan,
            'customer' => $customer
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FRONTEND: UPDATE PESANAN
    |--------------------------------------------------------------------------
    */
    public function updatePesanan(Request $request, $id)
    {
        $customer = auth('customer')->user();

        $pesanan = Pesanan::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        if ($pesanan->status !== 'menunggu') {
            return back()->with('error', 'Pesanan tidak bisa diubah');
        }

        $pesanan->update([
            'nama_pembeli' => $customer->name,
            'alamat'       => $customer->address,
        ]);

        return back()->with('success', 'Pesanan berhasil diupdate');
    }

    /*
    |--------------------------------------------------------------------------
    | FRONTEND: BATALKAN PESANAN
    |--------------------------------------------------------------------------
    */
    public function batal($id)
    {
        $customer = auth('customer')->user();

        $pesanan = Pesanan::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        if ($pesanan->status === 'menunggu') {
            $pesanan->delete();
        }

        return redirect()->route('cek.pesanan')
            ->with('success', 'Pesanan dibatalkan');
    }

    /*
    |--------------------------------------------------------------------------
    | BACKEND: UBAH STATUS
    |--------------------------------------------------------------------------
    */
    public function proses($id)
    {
        return $this->updateStatus($id, 'diproses', 'Pesanan sedang diproses');
    }

    public function tolak($id)
    {
        return $this->updateStatus($id, 'ditolak', 'Pesanan ditolak');
    }

    private function updateStatus($id, $status, $message)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => $status]);

        return redirect()->route('backend.pesanan.index')
            ->with('success', $message);
    }

    /*
    |--------------------------------------------------------------------------
    | BACKEND: HAPUS PESANAN
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        Pesanan::findOrFail($id)->delete();

        return redirect()->route('backend.pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus');
    }
}