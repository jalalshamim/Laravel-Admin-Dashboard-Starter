@extends('admin.layouts.app')

@section('title', 'Edit User Role')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit User Role</h1>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Name:</strong> {{ $user->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                    <div class="mb-3">
                        <strong>Current Role:</strong>
                        @if($user->roles->count() > 0)
                            @foreach($user->roles as $userRole)
                                <span class="badge bg-{{ $userRole->name == 'admin' ? 'primary' : 'secondary' }}">
                                    {{ ucfirst($userRole->name) }}
                                </span>
                            @endforeach
                        @else
                            <span class="badge bg-light text-dark">No Role</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Change Role</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.roles.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Select Role</label>
                            @foreach($roles as $role)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="role" id="role-{{ $role->name }}" 
                                       value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                <label class="form-check-label" for="role-{{ $role->name }}">
                                    {{ ucfirst($role->name) }} - {{ $role->name == 'admin' ? 'Full access to admin panel and all features' : 'Access to frontend only' }}
                                </label>
                            </div>
                            @endforeach
                            @error('role')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 