<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    // menampilkan data
    public function index()
    {
        // Mengambil semua data dari tabel `beritas`
        $beritas = Berita::all();

        // Cek apakah data ada
        if ($beritas->isNotEmpty()) {
            return response()->json([
                'message' => 'Get All Resource',
                'data' => $beritas,
            ], 200);
            
        } else {
            return response()->json([
                'message' => 'Data is empty',
            ], 200);
        }
    }

    // Menambahkan resource
    public function store(Request $request)
{
    try {
        // Validasi input dengan pesan kustom
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'content' => 'required|string',
            'url' => 'required|url',
            'url_image' => 'nullable|url',
            'published_at' => 'required|date',
            'category' => 'required|string|max:100',
        ], [
            'title.required' => 'Title harus diisi.',
            'title.string' => 'Title harus berupa teks.',
            'title.max' => 'Title maksimal 255 karakter.',
            'author.required' => 'Author harus diisi.',
            'author.string' => 'Author harus berupa teks.',
            'author.max' => 'Author maksimal 255 karakter.',
            'description.required' => 'Description harus diisi.',
            'description.string' => 'Description harus berupa teks.',
            'description.max' => 'Description maksimal 500 karakter.',
            'content.required' => 'Content harus diisi.',
            'content.string' => 'Content harus berupa teks.',
            'url.required' => 'URL harus diisi.',
            'url.url' => 'URL harus berupa link yang valid.',
            'url_image.url' => 'URL Image harus berupa link yang valid.',
            'published_at.required' => 'Tanggal publikasi harus diisi.',
            'published_at.date' => 'Tanggal publikasi harus berupa tanggal yang valid.',
            'category.required' => 'Category harus diisi.',
            'category.string' => 'Category harus berupa teks.',
            'category.max' => 'Category maksimal 100 karakter.',
        ]);

        // Jika validasi berhasil, buat data berita baru
        $berita = Berita::create($validated);

        // Respons sukses
        $data = [
            'message' => 'Berita created successfully!',
            'data' => $berita,
        ];

        return response()->json($data, 201);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Respons jika validasi gagal
        return response()->json([
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);
    }
}


    // Mendapatkan single resource
    public function show($id)
    {
        // mencari berita berdasarkan ID
        $beritas = Berita::find($id);

        // cek apakah berita ditemukan
        if ($beritas) {
            return response()->json([
                // respons resource ada
                'message' => 'Get Detail Resource',
                'data' => $beritas,
            ], 200);
        } else {
            // respons resource tidak ada
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }
    }

    // Memperbarui single resource
    public function update(Request $request, $id)
    {
        // mencari berita berdasarkan ID
        $beritas = Berita::find($id);

        // cek apakah berita ditemukan
        if ($beritas) {
            // validasi input
            $validatedData = $request->validate([
                'title' => 'sometimes|string|max:255',
                'author' => 'sometimes|string|max:255',
                'description' => 'sometimes|string|max:500',
                'content' => 'sometimes|string',
                'url' => 'sometimes|url',
                'url_image' => 'sometimes|url|nullable',
                'published_at' => 'sometimes|date',
                'category' => 'sometimes|string|max:100',
            ]);

            // update data berita
            $beritas->update($validatedData);

            // respons jika berhasil
            return response()->json([
                'message' => 'Resource is updated successfully',
                'data' => $beritas,
            ], 200);
        } else {
            // respons jika data tidak ditemukan
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }
    }

    // Menghapus single resource
    public function destroy($id)
    {
        // cari berita berdasarkan ID
        $beritas = Berita::find($id);

        // cek apakah berita ditemukan
        if ($beritas) {
            // hapus data berita
            $beritas->delete();

            // respons jika berhasil dihapus
            return response()->json([
                'message' => 'Resource is deleted successfully',
            ], 200);
        } else {
            // respons jika data tidak ditemukan
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }
    }

    // Mencari resource by title
    public function search(Request $request)
    {
        // validasi input
        $request->validate([
            'title' => 'required|string',
        ]);

        // cari berita berdasarkan title, like : cocok sebagian, % : karakter apapun
        $beritas = Berita::where('title', 'like', '%' . $request->title . '%')->get();

        if ($beritas->isNotEmpty()) {
            // respons jika berhasil ditemukan
            return response()->json([
                'message' => 'Get searched resource',
                'data' => $beritas,
            ], 200);

            // respons jika tidak berhasil ditemukan
        } else {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }
    }

    // Mendapatkan resource sport
    public function sport()
    {
        // cari berita berdasarkan categori:sport
        $beritas = Berita::where('category', 'sport')->get();

        // respons jika berhasil
        return response()->json([
            'message' => 'Get sport resource',
            'total' => $beritas->count(),
            'data' => $beritas,
        ], 200);
    }

    // Mendapatkan resource finance
    public function finance()
    {
        // cari berita berdasarkan categori:finance
        $beritas = Berita::where('category', 'finance')->get();

        // respons jika berhasil
        return response()->json([
            'message' => 'Get finance resource',
            'total' => $beritas->count(),
            'data' => $beritas,
        ], 200);
    }

    // Mendapatkan resource automotive
    public function automotive()
    {
        // cari berita berdasarkan categori:automative
        $beritas = Berita::where('category', 'automotive')->get();

        // respons jika berhasil
        return response()->json([
            'message' => 'Get automotive resource',
            'total' => $beritas->count(),
            'data' => $beritas,
        ], 200);
    }
}
