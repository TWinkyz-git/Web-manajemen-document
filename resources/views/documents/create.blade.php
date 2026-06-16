@extends('layouts.app')

@section('title', 'Upload Document')

@section('content')
<div style="max-width: 600px;">
    <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 3px solid #fff;">Upload Document</h2>

    <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 32px;">
            <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-bottom: 8px;">Title *</label>
            <input type="text" name="title" required style="width: 100%; padding: 12px; border: 3px solid #fff; background: transparent; color: #fff; font-size: 16px;" placeholder="Document title" value="{{ old('title') }}">
            @error('title')
                <span style="color: #ff0000; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 32px;">
            <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-bottom: 8px;">Description</label>
            <textarea name="description" style="width: 100%; padding: 12px; border: 3px solid #fff; background: transparent; color: #fff; font-size: 16px; font-family: inherit;" placeholder="Optional description" rows="4">{{ old('description') }}</textarea>
            @error('description')
                <span style="color: #ff0000; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 32px;">
            <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-bottom: 8px;">Category *</label>
            <select name="category_id" required style="width: 100%; padding: 12px; border: 3px solid #fff; background: #000; color: #fff; font-size: 16px; cursor: pointer;">
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span style="color: #ff0000; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 40px;">
            <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-bottom: 12px;">File (max 10MB) *</label>
            <div style="border: 3px dashed #666; padding: 40px; text-align: center; cursor: pointer; transition: all 0.2s;" id="dropZone">
                <input type="file" name="file" required id="fileInput" style="display: none;" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip">
                <p style="font-size: 14px; color: #888; margin-bottom: 8px;">Drag file here or click to select</p>
                <p style="font-size: 12px; color: #666;">PDF, Word, Excel, PowerPoint, Text, ZIP</p>
                <p style="margin-top: 12px; font-weight: 700; color: #fff;" id="fileName"></p>
            </div>
            @error('file')
                <span style="color: #ff0000; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn" style="flex: 1;">Upload</button>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary" style="flex: 1; text-align: center;">Cancel</a>
        </div>
    </form>
</div>

<script>
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');

    dropZone.addEventListener('click', () => fileInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#fff';
        dropZone.style.background = '#111';
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.style.borderColor = '#666';
        dropZone.style.background = 'transparent';
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        fileInput.files = e.dataTransfer.files;
        updateFileName();
        dropZone.style.borderColor = '#666';
        dropZone.style.background = 'transparent';
    });

    fileInput.addEventListener('change', updateFileName);

    function updateFileName() {
        if (fileInput.files.length > 0) {
            fileName.textContent = '✓ ' + fileInput.files[0].name;
            fileName.style.color = '#00ff00';
        }
    }
</script>
@endsection