@extends('layouts.app')

{{-- UI Enhancement for Story #3 - Design by Ola --}}
@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark"><i class="bi bi-geo-alt me-2"></i>Locations</h2>
        <a href="{{ route('locations.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius: 8px;">
             + Add Location
        </a>
    </div>

    {{-- قسم البحث بتنسيق عُلا --}}
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body bg-light" style="border-radius: 12px;">
            <form action="{{ url()->current() }}" method="GET" class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-control border-0 shadow-sm" placeholder="Search by location name..." style="border-radius: 8px;">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100 fw-bold" style="border-radius: 8px;">Search</button>
                </div>
                @if(request('search'))
                    <div class="col-md-2">
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary w-100 fw-bold" style="border-radius: 8px;">Clear</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- الجدول بتنسيق عُلا الاحترافي --}}
    <div class="table-responsive shadow-sm" style="border-radius: 12px;">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="table-primary text-white">
                <tr>
                    <th class="ps-4 py-3">Location Name</th>
                    <th class="text-end pe-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $location)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $location->name }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-sm btn-outline-warning px-3 me-1" style="border-radius: 6px;">Edit</a>
                            <form action="{{ route('locations.destroy', $location->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger px-3" style="border-radius: 6px;" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-5 text-muted">No locations found matching your search.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4 text-primary">
        {{ $locations->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection