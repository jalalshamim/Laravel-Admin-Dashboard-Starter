@extends('admin.layouts.app')

@section('title', 'Create Page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Page</h3>
                </div>
                <div class="card-body">
                    <form id="createPageForm" action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="content">Content</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" 
                                              id="content" name="content" rows="10">{{ old('content') }}</textarea>
                                    <div class="invalid-feedback" id="content-error"></div>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="featured_image">Featured Image</label>
                                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                           id="featured_image" name="featured_image">
                                    @error('featured_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Recommended size: 1200x630 pixels</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="is_active">Status</label>
                                    <select class="form-control @error('is_active') is-invalid @enderror" 
                                            id="is_active" name="is_active">
                                        <option value="1" {{ old('is_active', true) ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active') === false ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">SEO Settings</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                                   id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
                                            @error('meta_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                                      id="meta_description" name="meta_description" rows="2">{{ old('meta_description') }}</textarea>
                                            @error('meta_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}">
                                            @error('meta_keywords')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Separate keywords with commas</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Create Page</button>
                            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    let editor;

    ClassicEditor
        .create(document.querySelector('#content'))
        .then(newEditor => {
            editor = newEditor;
            console.log('CKEditor initialized successfully');
        })
        .catch(error => {
            console.error('CKEditor initialization error:', error);
            alert('Editor initialization failed: ' + error.message);
        });

    // Update textarea content before form submission
document.getElementById('createPageForm').addEventListener('submit', function(e) {
    const contentField = document.querySelector('#content');
    const errorDiv = document.getElementById('content-error');
    
    if (!editor) {
        errorDiv.textContent = 'Editor not initialized! Please wait or reload the page.';
        contentField.classList.add('is-invalid');
        e.preventDefault();
        return;
    }

    const editorData = editor.getData();
    contentField.value = editorData;

    if (editorData.trim().length < 10) {
        errorDiv.textContent = 'Please enter valid content (minimum 10 characters)';
        contentField.classList.add('is-invalid');
        e.preventDefault();
    } else {
        errorDiv.textContent = '';
        contentField.classList.remove('is-invalid');
        document.getElementById('submitBtn').disabled = true;
    }

    try {
        console.log('Editor content synced:', editorData.substring(0, 20));
    } catch (error) {
        console.error('Form submission error:', error);
        errorDiv.textContent = 'Submission error: ' + error.message;
        contentField.classList.add('is-invalid');
        e.preventDefault();
    }
});
</script>
@endpush