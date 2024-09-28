@extends('layouts.master')
@section('title')
  @lang('Create User ')
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1')
  Data User
@endslot
@slot('title')
  Create
@endslot
@endcomponent
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
        </div>
        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        

        <div class="mb-3">
            <label for="role_id" class="form-label">Role</label>
            <select class="form-select" id="role_id" name="role_id" required>
                <option value="1">Admin</option>
                <option value="2">Peserta</option>
                <option value="3">Panitia</option>
                <!-- Add more roles as needed -->
            </select>
        </div>

        <button type="submit" class="btn btn-success">Create User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
