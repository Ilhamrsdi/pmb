@extends('layouts.master')
@section('title', 'Hasil Ujian')

@section('content')
<div class="container">
    <div class="text-center my-4">
        <h1>Ujian Selesai</h1>
        <p class="lead">Anda telah menyelesaikan ujian. Klik tombol di bawah untuk melihat detail jawaban Anda.</p>
    </div>

    <div class="text-center mb-4">
        <button class="btn btn-primary" id="viewDetailsButton">Lihat Detail Jawaban</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Beranda</a>
    </div>

    <!-- Detail jawaban akan ditampilkan setelah tombol diklik -->
    <div id="detailsContainer" class="mt-4 d-none">
        <div class="card">
            <div class="card-header">
                <h5>Detail Jawaban</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban Anda</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="detailsTableBody">
                        {{-- @foreach ($examResults as $index => $result)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $result->question }}</td>
                                <td>{{ $result->userAnswer }}</td>
                                <td>{{ $result->correct ? 'Benar' : 'Salah' }}</td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    @isset($examResults)
        // Ambil data dari server jika $examResults didefinisikan
        const examResults = @json($examResults);
    @else
        // Jika tidak ada, inisialisasi examResults sebagai array kosong
        const examResults = [];
    @endisset

    // Menangani tampilan detail jawaban
    document.getElementById('viewDetailsButton').addEventListener('click', function() {
        const detailsContainer = document.getElementById('detailsContainer');
        detailsContainer.classList.toggle('d-none'); // Menampilkan/menyembunyikan detail
    });
</script>
@endsection


