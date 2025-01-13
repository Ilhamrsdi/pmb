@extends('layouts.master')
@section('title')
  @lang('Data User ')
@endsection
@section('css')
  <style>
    .drop-container {
      position: relative;
      display: flex;
      gap: 10px;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 200px;
      padding: 20px;
      border-radius: 10px;
      border: 2px dashed #555;
      color: #444;
      cursor: pointer;
      transition: background .2s ease-in-out, border .2s ease-in-out;
    }

    .drop-container:hover {
      background: #eee;
      border-color: #111;
    }

    .drop-container:hover .drop-title {
      color: #222;
    }
  </style>
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Data User
    @endslot
    @slot('title')
      Master Data User
    @endslot
  @endcomponent
  @if (Session::has('success'))
    <div class="alert alert-success">
      <strong>Success: </strong>{{ Session::get('success') }}
    </div>
  @endif
        <div class="row">
          <div class="col-lg-12">
            <div id="#customerList">
              <!-- Tombol untuk membuka modal Create -->
              <a href="javascript:void(0)" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Create New User</a>
              
              <div class="card">
                <div id="customerList">
                <div class="card-header">
                <div class="row g-4">
                    <div class="col-sm-auto">
                        <h4 class="card-title mt-2">Data USER</h4>
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
              </div>
              <!-- end card header -->
              <div class="card-body">
                <div class="table-responsive table-card mt-3 mb-1">
                  <table class="table align-middle table-nowrap" id="customerTable">
                    <thead class="table-light">
                      <tr>
                        <th>ID</th>
                        <th data-sort="customer_name">Nama</th>
                        <th data-sort="date">Email</th>
                        <th data-sort="email">Roles</th>
                        <th data-sort="action">AKSI</th>
                      </tr>
                    </thead>
                    <tbody class="list form-check-all" id="tbodyPendaftarID">
                      @foreach ($users as $row)
                        <tr>
                          <td class="customer_name">{{ $row->id }}</td>
                          <td class="name">{{ $row->username }}</td>
                          <td class="email">{{ $row->email }}</td>
                          <td class="role">{{ $row->role->role }}</td>
                          <td>
                            <div class="d-flex gap-2">
                              <!-- Tombol Edit -->
                              <button type="button" class="btn btn-warning btn-icon waves-effect waves-light rounded-pill" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}"><i class="ri-pencil-line"></i></button>
                              
                              <!-- Tombol Delete -->
                              <button type="button" class="btn btn-danger btn-icon waves-effect waves-light rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteRecordModal{{ $row->id }}"><i class="ri-delete-bin-fill"></i></button>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <div class="noresult" style="display: none">
                    <div class="text-center">
                      <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                      </lord-icon>
                      <h5 class="mt-2">Maaf! Data yang anda cari tidak ada</h5>
                      <p class="text-muted mb-0">Harap Perbaiki kata kunci yang anda cari. </p>
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
              </div><!-- end card -->
            </div>
          </div>
        </div>
      </div>
  </div><!-- end card -->
  <!-- end row -->

  <!-- Modal Create -->
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

  <!-- Modal Edit -->
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

  <!-- Modal Delete -->
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
