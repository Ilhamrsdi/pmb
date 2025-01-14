@extends('layouts.master')
@section('title')
  @lang('DATA USER')
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
     Data Master
    @endslot
    @slot('title')
     Master Data User
    @endslot
  @endcomponent
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Menampilkan error dari validasi --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title mb-0">Add, Edit & Remove</h4>
        </div><!-- end card header -->

        <div class="card-body">
          <div id="gelombangList">
            <div class="row g-4 mb-3">
              <div class="col-sm-auto">
                <div>
                  <a href="javascript:void(0)" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Create New User</a>
                </div>
              </div>
              <div class="col-sm">
                <div class="d-flex justify-content-sm-end">
                  <div class="search-box ms-2">
                    <input type="text" class="form-control search" placeholder="Search...">
                    <i class="ri-search-line search-icon"></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-responsive table-card mt-3 mb-1">
              <table class="table align-middle table-nowrap" id="customerTable">
                <thead class="table-light">
                  <tr>
                    <th>NO</th>
                    <th class="sort text-center" data-sort="nama">USERNAME</th>
                    <th class="text-center" data-sort="tahun">EMAIL</th>
                    <th class="text-center" data-sort="prodi1">ROLES</th>
                    <th class="text-center" data-sort="prodi2">AKSI</th>
                  </tr>
                </thead>
                <tbody class="list form-check-all">

                  @forelse($users as $index => $row)
                    <tr>
                      <td class="nama">{{ ++$index}}</td>
                      <td class="tahun text-center">{{ $row->username }}</td>
                     <td class="email text-center">{{$row->email}}</td>
                     <td class="roles text-center">{{$row->role->role}}</td>                                 
                     <td class="text-center">
                      <div class="d-flex justify-content-center gap-2">
                        <div class="edit">
                          <!-- Tombol Edit -->
                          <button type="button" class="btn btn-warning btn-icon waves-effect waves-light rounded-pill" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}">
                            <i class="ri-pencil-line"></i>
                          </button>
                        </div>
                        
                        <div class="delete">
                          <!-- Tombol Delete -->
                          <button type="button" class="btn btn-danger btn-icon waves-effect waves-light rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteRecordModal{{ $row->id }}">
                            <i class="ri-delete-bin-fill"></i>
                          </button>
                        </div>
                      </div>
                    </td>                    
                    @empty
                      @php
                        echo 'Data Kosong';
                      @endphp
                    </tr>
                  @endforelse
                </tbody>
              </table>
              <div class="noresult" style="display: none">
                <div class="text-center">
                  <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                  </lord-icon>
                  <h5 class="mt-2">Sorry! No Result Found</h5>
                  <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                    orders for you search.</p>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <div class="pagination-wrap hstack gap-2">
                <a class="page-item pagination-prev disabled" href="#">
                  Previous
                </a>
                <ul class="pagination listjs-pagination mb-0"></ul>
                <a class="page-item pagination-next" href="#">
                  Next
                </a>
              </div>
            </div>
          </div>
        </div><!-- end card -->
      </div>
      <!-- end col -->
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->


  <!-- modal add -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success p-3">
                <h5 class="modal-title" id="createModalLabel">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

  <!-- modal edit -->
  @foreach ($users as $row)
  <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning p-3">
                <h5 class="modal-title" id="editModalLabel{{ $row->id }}">Edit User: {{ $row->username }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $row->username }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $row->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="admin" {{ $row->role->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ $row->role->role == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
  @endforeach

  <!-- modal delete -->
  @foreach ($users as $row)
  <div class="modal fade zoomIn" id="deleteRecordModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.destroy', $row->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <h5 class="text-center">Are you sure you want to delete this user?</h5>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
  @endforeach
@endsection
@section('script')
  <script src="{{ URL::asset('assets/libs/prismjs/prism.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
  <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
  <!-- listjs init -->
  {{-- <script src="{{ URL::asset('assets/js/pages/listjs.init.js') }}"></script> --}}  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
