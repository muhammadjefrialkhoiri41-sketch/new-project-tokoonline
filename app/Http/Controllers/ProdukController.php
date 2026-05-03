<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Helpers\ImageHelper;

class ProdukController extends Controller
{
    // ===============================
    // BACKEND - LIST PRODUK
    // ===============================
    public function index()
    {
        $produk = Produk::with('kategori')->orderBy('id', 'desc')->get();

        return view('backend.v_produk.index', [
            'judul' => 'Produk',
            'index' => $produk
        ]);
    }

    // ===============================
    // FRONTEND - BERANDA
    // ===============================
    public function beranda()
    {
        $produk = Produk::orderBy('id', 'desc')->get();

        return view('frontend.beranda', compact('produk'));
    }

    // ===============================
    // FRONTEND - HALAMAN BELI
    // ===============================
    public function beli($id)
    {
        $produk = Produk::findOrFail($id);

        return view('frontend.beli', compact('produk'));
    }

    // ===============================
    // BACKEND - FORM TAMBAH PRODUK
    // ===============================
    public function create()
    {
        return view('backend.v_produk.create', [
            'judul' => 'Tambah Produk',
            'kategori' => Kategori::orderBy('nama_kategori')->get()
        ]);
    }

    // ===============================
    // BACKEND - SIMPAN PRODUK
    // ===============================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_produk' => 'required|max:255|unique:produk,nama_produk',
            'detail' => 'nullable',
            'harga' => 'required|numeric',
            'berat' => 'required|numeric',
            'stok' => 'required|integer',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        // Upload foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dir = 'storage/img-produk/';

            ImageHelper::uploadAndResize($file, $dir, $filename);
            ImageHelper::uploadAndResize($file, $dir, 'thumb_lg_' . $filename, 800);
            ImageHelper::uploadAndResize($file, $dir, 'thumb_md_' . $filename, 500, 519);
            ImageHelper::uploadAndResize($file, $dir, 'thumb_sm_' . $filename, 100, 110);

            $validated['foto'] = $filename;
        }

        Produk::create($validated);

        return redirect()->route('backend.produk.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // ===============================
    // BACKEND - DETAIL PRODUK
    // ===============================
    public function show(string $id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);

        return view('backend.v_produk.show', [
            'judul' => 'Detail Produk',
            'show' => $produk
        ]);
    }

    // ===============================
    // BACKEND - FORM EDIT PRODUK
    // ===============================
    public function edit(string $id)
    {
        return view('backend.v_produk.edit', [
            'judul' => 'Ubah Produk',
            'edit' => Produk::findOrFail($id),
            'kategori' => Kategori::orderBy('nama_kategori')->get()
        ]);
    }

    // ===============================
    // BACKEND - UPDATE PRODUK
    // ===============================
    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|max:255|unique:produk,nama_produk,' . $id,
            'kategori_id' => 'required',
            'status' => 'required',
            'detail' => 'required',
            'harga' => 'required|numeric',
            'berat' => 'required|numeric',
            'stok' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
        ]);

        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($produk->foto) {
                @unlink(public_path('storage/img-produk/' . $produk->foto));
                @unlink(public_path('storage/img-produk/thumb_lg_' . $produk->foto));
                @unlink(public_path('storage/img-produk/thumb_md_' . $produk->foto));
                @unlink(public_path('storage/img-produk/thumb_sm_' . $produk->foto));
            }

            // Upload foto baru
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dir = 'storage/img-produk/';

            ImageHelper::uploadAndResize($file, $dir, $filename);
            ImageHelper::uploadAndResize($file, $dir, 'thumb_lg_' . $filename, 800);
            ImageHelper::uploadAndResize($file, $dir, 'thumb_md_' . $filename, 500, 519);
            ImageHelper::uploadAndResize($file, $dir, 'thumb_sm_' . $filename, 100, 110);

            $validated['foto'] = $filename;
        }

        $produk->update($validated);

        return redirect()->route('backend.produk.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    // ===============================
    // BACKEND - HAPUS PRODUK
    // ===============================
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->foto) {
            @unlink(public_path('storage/img-produk/' . $produk->foto));
            @unlink(public_path('storage/img-produk/thumb_lg_' . $produk->foto));
            @unlink(public_path('storage/img-produk/thumb_md_' . $produk->foto));
            @unlink(public_path('storage/img-produk/thumb_sm_' . $produk->foto));
        }

        $produk->delete();

        return redirect()->route('backend.produk.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}