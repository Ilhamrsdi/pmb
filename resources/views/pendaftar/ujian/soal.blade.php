@extends('layouts.master')

@section('content')
    <h1>Ujian Soal Tes Maba</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h2>Soal Ujian untuk Tes: {{ $tesMaba->name }}</h2>

    <form action="{{ route('pendaftar.storeAnswers') }}" method="POST">
        @csrf

        @foreach($soals as $soal)
            <div class="form-group">
                <label for="jawaban_{{ $soal->id }}">{{ $soal->question_text }}</label>
                <input type="text" name="jawaban[{{ $soal->id }}]" id="jawaban_{{ $soal->id }}" class="form-control" required>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
    </form>
@endsection
