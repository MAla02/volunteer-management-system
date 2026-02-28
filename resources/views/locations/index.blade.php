@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Locations</h2>
        <a href="{{ route('locations.create') }}" class="btn btn-primary">Add Location</a>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET" class="row g-2">
                <div class="col-md-5">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-control" placeholder="Search by location name...">
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
    <table class="table table-striped border mt-3">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($locations as $location)
            <tr>
                <td>{{ $location->name }}</td>
                <td>
                    <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    
                    {{-- التعديل هنا: استخدام ID فريد للفورم وتغيير نوع الزر --}}
                    <form action="{{ route('locations.destroy', $location->id) }}" method="POST" class="d-inline" id="delete-location-{{ $location->id }}">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $location->id }})">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center text-muted">No locations found matching your search.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $locations->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection

{{-- السكريبت الخاص بالنافذة الجمالية --}}
@section('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This location will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // إرسال الفورم المخصص لهذا الموقع فقط
            document.getElementById('delete-location-' + id).submit();
        }
    })
}
</script>
@endsection