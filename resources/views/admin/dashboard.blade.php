@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Welcome Card -->
    <div class="col-12 mb-4">
        <div class="content-card">
            <h2 class="h4 mb-3">Welcome back, {{ auth()->guard('admin')->user()->name }}!</h2>
            <p class="text-muted mb-0">Here's what's happening with your admin panel today.</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="content-card">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-users fa-2x text-primary"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Total Users</h6>
                    <h3 class="mb-0">{{ \App\Models\User::count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="content-card">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-file-alt fa-2x text-success"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Total Pages</h6>
                    <h3 class="mb-0">0</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="content-card">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-newspaper fa-2x text-warning"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Total Posts</h6>
                    <h3 class="mb-0">{{ \App\Models\Post::count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="content-card">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-chart-line fa-2x text-info"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Page Views</h6>
                    <h3 class="mb-0">0</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-12">
        <div class="content-card">
            <h5 class="mb-4">Recent Activity</h5>
            @php
                $activities = \App\Models\Activity::getRecent(10);
            @endphp
            
            @if($activities->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Details</th>
                                <th>Date/Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $activity)
                                <tr>
                                    <td>
                                        @if($activity->user)
                                            {{ $activity->user->name }}
                                        @else
                                            System
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $activity->action == 'created' ? 'bg-success' : ($activity->action == 'updated' ? 'bg-primary' : 'bg-danger') }}">
                                            {{ ucfirst($activity->action) }}
                                        </span>
                                    </td>
                                    <td>{{ $activity->description }}</td>
                                    <td>{{ $activity->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-clock fa-3x mb-3"></i>
                    <p>No recent activity to display.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 