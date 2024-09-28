<!-- resources/views/users/show.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Master User</h1>
    
    <div class="card">
        <div class="card-header">
            Informasi User
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Name:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role->role }}</p>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
