<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $query = Document::with('user', 'category', 'team');
        
        // Jika user punya team preference, filter by team
        if (request('team_id')) {
            $teamId = request('team_id');
            $query->where(function ($q) use ($teamId) {
                $q->where('user_id', auth()->id())
                  ->orWhere('team_id', $teamId);
            });
        } else {
            // Default: show user's own documents + team documents
            $query->where(function ($q) {
                $q->where('user_id', auth()->id());
                // or where user is team member
                $q->orWhereIn('team_id', auth()->user()->teams()->pluck('id'));
            });
        }
        
        $documents = $query->paginate(10);
        
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
            
            // Read file content
            $fileContent = file_get_contents($file->getRealPath());
            
            // Encrypt file content
            $encryptedContent = Crypt::encryptString($fileContent);
            
            // Save encrypted file
            $filePath = 'documents/' . $fileName . '.encrypted';
            Storage::disk('public')->put($filePath, $encryptedContent);

            $document = Document::create([
                'user_id' => auth()->id(),
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'encryption_key' => 'aes-256-gcm',
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

        // Read encrypted file
        $encryptedContent = Storage::disk('public')->get($document->file_path);
        
        // Decrypt file content
        $decryptedContent = Crypt::decryptString($encryptedContent);
        
        // Return decrypted file as download
        return response()->streamDownload(function () use ($decryptedContent) {
            echo $decryptedContent;
        }, $document->file_name);
    }

    public function preview(Document $document)
    {
        $this->authorize('view', $document);

        AuditLogService::log(
            action: 'preview_document',
            documentId: $document->id
        );

        try {
            // Read encrypted file
            $encryptedContent = Storage::disk('public')->get($document->file_path);
            
            // Decrypt file content
            $decryptedContent = Crypt::decryptString($encryptedContent);
        } catch (\Exception $e) {
            // File lama tidak ter-encrypt, langsung return raw file
            $decryptedContent = Storage::disk('public')->get($document->file_path);
        }
        
        // Return file dengan content-type yang sesuai
        $mimeType = 'application/octet-stream';
        if (strtolower($document->file_type) === 'pdf') {
            $mimeType = 'application/pdf';
        } elseif (in_array(strtolower($document->file_type), ['jpg', 'jpeg', 'png', 'gif'])) {
            $mimeType = 'image/' . strtolower($document->file_type);
        }
        
        return response($decryptedContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $document->file_name . '"');
    }
}