@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-white-50">Welcome</h6>
                            <h5 class="card-title mb-0">{{ auth()->user()->name }}</h5>
                        </div>
                        <i class="fas fa-user fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">No recent activity to display.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 