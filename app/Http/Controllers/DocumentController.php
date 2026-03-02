<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    // List (admin & user bisa lihat)
    public function index(Request $request)
{
    $query = Document::query();

    // Search keyword
    if ($request->filled('q')) {
        $query->where(function ($q) use ($request) {
            $q->where('nomor_dokumen', 'like', '%' . $request->q . '%')
              ->orWhere('judul', 'like', '%' . $request->q . '%');
        });
    }

    // Filter kategori
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    $documents = $query->latest()->paginate(10)->withQueryString();

    $kategoriList = Document::select('kategori')
    ->distinct()
    ->orderBy('kategori')
    ->pluck('kategori');

    return inertia('Documents/Index', [
        'documents' => $documents,
        'filters' => $request->only(['q', 'kategori']),
        'kategoriList' => $kategoriList,
    ]);
}

    // Form create (admin saja)
    public function create()
    {
        return inertia('Documents/Create');
    }

    // Store (admin saja)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_dokumen' => ['required', 'string', 'max:255', 'unique:documents,nomor_dokumen'],
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'file_url' => ['required', 'url', 'max:2000'],
        ]);

        Document::create($validated);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }
    public function edit(Document $document)
    {
        return inertia('Documents/Edit', [
            'document' => $document,
        ]);
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'nomor_dokumen' => ['required', 'string', 'max:255', 'unique:documents,nomor_dokumen,' . $document->id],
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'file_url' => ['required', 'url', 'max:2000'],
        ]);

        $document->update($validated);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    // Redirect open link (admin & user bisa)
    public function open(Document $document)
    {
        return redirect()->away($document->file_url);
    }
}
