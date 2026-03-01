@extends('layouts.app')

@section('content')
<div class="container">

    {{-- تنبيه النجاح التقليدي قمنا بتحسينه في الملف الرئيسي، لكن سأتركه هنا لضمان عدم ضياع أي رسالة --}}
    {{-- تنبيه النجاح التقليدي قمنا بتحسينه في الملف الرئيسي، لكن سأتركه هنا لضمان عدم ضياع أي رسالة --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Volunteers List</h2>
        <a href="{{ route('volunteers.create') }}" class="btn btn-primary">Add New Volunteer</a>
    </div>

<<<<<<< Updated upstream
=======
    {{-- قسم البحث --}}
>>>>>>> Stashed changes
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-control" placeholder="Search by name or email...">
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
<<<<<<< Updated upstream
=======

    {{-- جدول المتطوعين --}}
>>>>>>> Stashed changes
    <table class="table table-striped border">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($volunteers as $volunteer)
                <tr>
                    <td>{{ $volunteer->name }}</td>
                    <td>{{ $volunteer->email }}</td>
                    <td>{{ $volunteer->phone }}</td>
                    <td>
                        <a href="{{ route('volunteers.edit', $volunteer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        
                        {{-- التعديل الاحترافي لزر الحذف --}}
                        <form action="{{ route('volunteers.destroy', $volunteer->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $volunteer->id }}">
                        
                        {{-- التعديل الاحترافي لزر الحذف --}}
                        <form action="{{ route('volunteers.destroy', $volunteer->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $volunteer->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $volunteer->id }})">
                                Delete
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $volunteer->id }})">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No volunteers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $volunteers->appends(['search' => request('search')])->links() }}
    </div>
</div>
<<<<<<< Updated upstream
=======
@endsection

{{-- السكريبت الخاص بالنافذة الجمالية --}}
@section('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this volunteer data!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // إرسال الفورم المخصص لهذا المتطوع فقط
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
>>>>>>> Stashed changes
@endsection