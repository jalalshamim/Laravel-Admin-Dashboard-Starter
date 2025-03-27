@extends('admin.layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h1 class="auth-title">Welcome Back!</h1>
        <p class="auth-subtitle">Please sign in to continue to Admin Panel</p>
    </div>

    <div class="alert alert-info mb-4" role="alert">
        <strong>Demo Mode:</strong> User profile editing is disabled in this demo.
        <br>
        <strong>Login information:</strong> admin@admin.com / password
    </div>

    <form method="POST" action="{{ route('admin.login') }}" class="needs-validation" novalidate>
        @csrf
        
        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   id="password" 
                   name="password" 
                   required>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input type="checkbox" 
                       class="form-check-input" 
                       id="remember" 
                       name="remember" 
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                Sign In
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endpush
@endsection 