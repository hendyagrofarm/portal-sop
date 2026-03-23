<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | List dokumen aktif
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Document::query()->where('status', 'active');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_dokumen', 'like', '%' . $request->q . '%')
                  ->orWhere('judul', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        $kategoriList = Document::query()
            ->where('status', 'active')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return inertia('Documents/Index', [
            'documents' => $documents,
            'filters' => $request->only(['q', 'kategori']),
            'kategoriList' => $kategoriList,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Histori dokumen dicabut
    |--------------------------------------------------------------------------
    */
    public function history(Request $request)
    {
        $query = Document::query()->where('status', 'revoked');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_dokumen', 'like', '%' . $request->q . '%')
                  ->orWhere('judul', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $documents = $query->latest('revoked_at')->paginate(10)->withQueryString();

        $kategoriList = Document::query()
            ->where('status', 'revoked')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return inertia('Documents/History', [
            'documents' => $documents,
            'filters' => $request->only(['q', 'kategori']),
            'kategoriList' => $kategoriList,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Form create
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return inertia('Documents/Create');
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan dokumen baru
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_dokumen' => ['required', 'string', 'max:255', 'unique:documents,nomor_dokumen'],
            'judul'         => ['required', 'string', 'max:255'],
            'kategori'      => ['nullable', 'string', 'max:255'],
            'deskripsi'     => ['nullable', 'string'],
            'file_url'      => ['required', 'url', 'max:2000'],
        ]);

        $validated['status'] = 'active';

        Document::create($validated);

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | Form edit
    |--------------------------------------------------------------------------
    */
    public function edit(Document $document)
    {
        return inertia('Documents/Edit', [
            'document' => $document,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Update dokumen
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'nomor_dokumen' => ['required', 'string', 'max:255', 'unique:documents,nomor_dokumen,' . $document->id],
            'judul'         => ['required', 'string', 'max:255'],
            'kategori'      => ['nullable', 'string', 'max:255'],
            'deskripsi'     => ['nullable', 'string'],
            'file_url'      => ['required', 'url', 'max:2000'],
        ]);

        $document->update($validated);

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus permanen dokumen
    |--------------------------------------------------------------------------
    */
    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | Buka link dokumen
    |--------------------------------------------------------------------------
    */
    public function open(Document $document)
    {
        return redirect()->away($document->file_url);
    }

    /*
    |--------------------------------------------------------------------------
    | Cabut dokumen (masuk histori)
    |--------------------------------------------------------------------------
    */
    public function revoke(Request $request, Document $document)
    {
        $request->validate([
            'revoked_reason' => ['required', 'string'],
        ]);

        $document->update([
            'status'         => 'revoked',
            'revoked_at'     => now(),
            'revoked_reason' => $request->input('revoked_reason'),
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil dipindahkan ke histori SOP dicabut.');
    }

    /*
    |--------------------------------------------------------------------------
    | Pulihkan dokumen
    |--------------------------------------------------------------------------
    */
    public function restore(Document $document)
    {
        $document->update([
            'status' => 'active',
            'revoked_at' => null,
            'revoked_reason' => null,
        ]);

        return redirect()->route('documents.history')
            ->with('success', 'Dokumen berhasil dipulihkan ke dokumen aktif.');
    }
}