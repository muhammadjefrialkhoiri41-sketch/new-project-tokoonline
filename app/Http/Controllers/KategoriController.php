<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Backend - daftar kategori
     */
    public function index()
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('backend.v_kategori.index', [
            'judul' => 'Kategori',
            'index' => $kategori
        ]);
    }

    /**
     * Frontend - beranda kategori aktif
     */
    public function beranda()
    {
        $kategori = Kategori::where('status', 1)->get();

        return view('frontend.beranda', compact('kategori'));
    }

    /**
     * Frontend - produk per kategori
     */
    public function produk($id)
    {
        $kategori = Kategori::with('produk')->findOrFail($id);

        return view('frontend.produk', compact('kategori'));
    }

    /**
     * Backend - form tambah kategori
     */
    public function create()
    {
        return view('backend.v_kategori.create', [
            'judul' => 'Tambah Kategori'
        ]);
    }

    /**
     * Backend - simpan kategori
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'status' => 'required'
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'status' => $request->status,
        ];

        // Upload foto kategori
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('storage/img-kategori'), $filename);

            $data['foto'] = $filename;
        }

        Kategori::create($data);

        return redirect()->route('backend.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Backend - form edit kategori
     */
    public function edit(Kategori $kategori)
    {
        return view('backend.v_kategori.edit', [
            'judul' => 'Edit Kategori',
            'edit'  => $kategori
        ]);
    }

    /**
     * Backend - update kategori
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'status' => 'required'
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'status' => $request->status,
        ];

        // Jika upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($kategori->foto && file_exists(public_path('storage/img-kategori/' . $kategori->foto))) {
                unlink(public_path('storage/img-kategori/' . $kategori->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('storage/img-kategori'), $filename);

            $data['foto'] = $filename;
        }

        $kategori->update($data);

        return redirect()->route('backend.kategori.index')
            ->with('success', 'Kategori berhasil diubah');
    }

    /**
     * Backend - hapus kategori
     */
    public function destroy(Kategori $kategori)
    {
        // Hapus foto jika ada
        if ($kategori->foto && file_exists(public_path('storage/img-kategori/' . $kategori->foto))) {
            unlink(public_path('storage/img-kategori/' . $kategori->foto));
        }

        $kategori->delete();

        return redirect()->route('backend.kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}