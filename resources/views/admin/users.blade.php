@extends('layouts.adminBase')


@section('content')


        <!-- Sidebar Start -->
@include('admin.includes.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('admin.includes.navbar')
            <!-- Navbar End -->

            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">
                            @if(isset($filter) && $filter == 'admins')
                                System Administrators
                            @elseif(isset($filter) && $filter == 'users')
                                Regular Users
                            @else
                                @if(isset($isSuperAdmin) && $isSuperAdmin)
                                    All Users
                                @else
                                    Regular Users
                                @endif
                            @endif
                        </h6>
                        <div class="d-flex gap-2 align-items-center">
                            @if(isset($isSuperAdmin) && $isSuperAdmin)
                                {{-- Only super admin can see admins --}}
                                <a href="{{ route('users', ['filter' => 'admins']) }}" 
                                   class="btn {{ (isset($filter) && $filter == 'admins') ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                    <i class="fas fa-user-shield me-1"></i>View Admins
                                </a>
                                <a href="{{ route('users', ['filter' => 'users']) }}" 
                                   class="btn {{ (isset($filter) && $filter == 'users') ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                    <i class="fas fa-users me-1"></i>View Users
                                </a>
                                <a href="{{ route('users') }}" 
                                   class="btn {{ (!isset($filter) || $filter == 'all') ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                    <i class="fas fa-list me-1"></i>View All
                                </a>
                            @else
                                {{-- Regular admins can only see users filter --}}
                                <a href="{{ route('users', ['filter' => 'users']) }}" 
                                   class="btn {{ (isset($filter) && $filter == 'users') ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                    <i class="fas fa-users me-1"></i>View Users
                                </a>
                                <a href="{{ route('users') }}" 
                                   class="btn {{ (!isset($filter) || $filter == 'all') ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                    <i class="fas fa-list me-1"></i>View All
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Search Box -->
                    <div class="mb-4">
                        <form method="GET" action="{{ route('users') }}" id="searchForm">
                            <input type="hidden" name="filter" value="{{ $filter ?? 'all' }}" id="filterInput">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="userSearch" 
                                       name="search" 
                                       placeholder="Search by name or email..." 
                                       value="{{ $search ?? '' }}"
                                       autocomplete="off">
                                @if(isset($search) && $search)
                                    <a href="{{ route('users', ['filter' => $filter ?? 'all']) }}" class="btn btn-outline-secondary" title="Clear search">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    @if(isset($search) && $search)
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Found {{ $users->count() }} result(s) for "<strong>{{ $search }}</strong>"
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Email Verified</th>
                                    <th scope="col">Properties</th>
                                    <th scope="col">Bookings</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->hasVerifiedEmail())
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Verified
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-exclamation-circle me-1"></i>Not Verified
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $user->properties_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $user->hotel_bookings_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <div class="button-group d-flex gap-1 flex-wrap">
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary btn-sm" title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if(!$user->hasVerifiedEmail())
                                                @if($user->role != 1 || (isset($isSuperAdmin) && $isSuperAdmin))
                                                    <a href="{{ route('admin.users.verify', $user->id) }}" class="btn btn-success btn-sm" 
                                                       title="Verify Email" onclick="return confirm('Are you sure you want to verify this user\'s email?')">
                                                        <i class="fas fa-check-circle"></i>
                                                    </a>
                                                @endif
                                            @endif
                                            @if($user->role != 1 && isset($isSuperAdmin) && $isSuperAdmin)
                                                <a href="{{ route('makeAdmin', ['id' => $user->id]) }}" class="btn btn-info btn-sm" title="Make Admin">
                                                    <i class="fa fa-user-shield"></i>
                                                </a>
                                            @endif
                                            @if(isset($isSuperAdmin) && $isSuperAdmin)
                                                <a href="{{ route('deleteUser', ['id' => $user->id]) }}" class="btn btn-danger btn-sm" 
                                                   title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-user-slash fa-3x mb-3"></i>
                                            <p class="mb-0">No users found</p>
                                            @if(isset($search) && $search)
                                                <small>Try a different search term or <a href="{{ route('users', ['filter' => $filter ?? 'all']) }}">clear search</a></small>
                                            @elseif(isset($filter) && $filter == 'admins')
                                                <small>No administrators found</small>
                                            @else
                                                <small>No users in the system</small>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->



            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Accoomodation Booking Engine</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="https://iremetech.com">Ireme Technologies</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        @include('admin.includes.footer')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('userSearch');
    const searchForm = document.getElementById('searchForm');
    const filterInput = document.getElementById('filterInput');
    let searchTimeout;

    // Auto-search functionality with debounce
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            
            const searchValue = e.target.value.trim();
            
            // Clear timeout and wait 500ms after user stops typing
            searchTimeout = setTimeout(function() {
                if (searchValue.length >= 2 || searchValue.length === 0) {
                    // Only search if at least 2 characters or empty (to clear)
                    searchForm.submit();
                }
            }, 500);
        });

        // Allow Enter key to submit immediately
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout);
                searchForm.submit();
            }
        });
    }

    // Update filter input when filter buttons are clicked
    document.querySelectorAll('a[href*="filter="]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const url = new URL(this.href);
            const filter = url.searchParams.get('filter') || 'all';
            if (filterInput) {
                filterInput.value = filter;
            }
        });
    });
});
</script>
@endsection
