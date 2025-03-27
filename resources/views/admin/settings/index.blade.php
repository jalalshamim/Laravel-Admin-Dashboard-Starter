@extends('admin.layouts.app')

@section('title', 'Application Settings')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Application Settings</h1>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <!-- Application Name -->
                <div class="mb-4">
                    <label for="app_name" class="form-label">Application Name</label>
                    <input type="text" 
                           class="form-control @error('app_name') is-invalid @enderror" 
                           id="app_name" 
                           name="app_name" 
                           value="{{ old('app_name', $settings['app_name']) }}" 
                           required>
                    @error('app_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <!-- Application Logo -->
                <div class="mb-4">
                    <label for="app_logo" class="form-label">Application Logo</label>
                    @if($settings['app_logo'])
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $settings['app_logo']) }}" 
                                 alt="Current Logo" 
                                 class="img-thumbnail" 
                                 style="max-height: 100px;">
                        </div>
                    @endif
                    <input type="file" 
                           class="form-control @error('app_logo') is-invalid @enderror" 
                           id="app_logo" 
                           name="app_logo" 
                           accept="image/*">
                    @error('app_logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Recommended size: 200x50 pixels. Maximum file size: 1MB.</div>
                </div>
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection 