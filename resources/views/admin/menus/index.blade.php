@extends('admin.layouts.app')

@section('title', 'Menu Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Menus</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Menu
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Items</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($menus as $menu)
                                    <tr>
                                        <td>{{ $menu->id }}</td>
                                        <td>{{ $menu->name }}</td>
                                        <td>{{ $menu->location ?? 'N/A' }}</td>
                                        <td>{{ $menu->all_items_count }}</td>
                                        <td>
                                            <span class="badge badge-{{ $menu->status ? 'success' : 'danger' }}">
                                                {{ $menu->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.menus.builder', $menu) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-list"></i> Builder
                                            </a>
                                            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No menus found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $menus->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 