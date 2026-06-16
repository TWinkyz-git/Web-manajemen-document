<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('user', 'category')
            ->where('user_id', auth()->id())
            ->paginate(10);
        
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'file' => 'required|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $document = Document::create([
                'user_id' => auth()->id(),
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'status' => 'published',
            ]);

            AuditLogService::log(
                action: 'upload_document',
                documentId: $document->id,
                metadata: ['file_name' => $fileName]
            );

            return redirect()->route('documents.index')->with('success', 'Document uploaded successfully!');
        }

        return back()->with('error', 'File upload failed!');
    }

    public function show(Document $document)
    {
        $this->authorize('view', $document);
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $this->authorize('update', $document);
        $categories = Category::all();
        return view('documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorize('update', $document);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $document->update($validated);

        AuditLogService::log(
            action: 'update_document',
            documentId: $document->id
        );

        return redirect()->route('documents.index')->with('success', 'Document updated successfully!');
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);
        
        $document->delete();

        AuditLogService::log(
            action: 'delete_document',
            documentId: $document->id
        );

        return redirect()->route('documents.index')->with('success', 'Document deleted successfully!');
    }

    public function download(Document $document)
    {
        $this->authorize('download', $document);

        AuditLogService::log(
            action: 'download_document',
            documentId: $document->id
        );

        return response()->download(storage_path('app/public/' . $document->file_path), $document->file_name);
    }
}