@extends('layouts.master')
@section('title', 'Hasil Ujian')

@section('content')
<div class="container">
    <div class="text-center my-4">
        <h1>Hasil Ujian</h1>
        <p class="lead">Berikut adalah hasil ujian Anda.</p>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Ringkasan Hasil</h5>
        </div>
        <div class="card-body">
            <h4 class="text-success">Skor Anda: <span id="finalScore">0</span>%</h4>
            <p>Total Pertanyaan: <strong id="totalQuestions">0</strong></p>
            <p>Jawaban Benar: <strong id="correctAnswers">0</strong></p>
            <p>Jawaban Salah: <strong id="incorrectAnswers">0</strong></p>
        </div>
    </div>

    <div class="text-center">
        <button class="btn btn-primary" id="viewDetailsButton">Lihat Detail Jawaban</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Beranda</a>
    </div>

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
                        @foreach ($examResults as $index => $result)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $result->question }}</td>
                                <td>{{ $result->userAnswer }}</td>
                                <td>{{ $result->correct ? 'Benar' : 'Salah' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Ambil data dari tabel detail jawaban
    const examResults = @json($examResults); // Mengambil data dari server ke JavaScript

    // Fungsi untuk menghitung skor
    function calculateScore(results) {
        const correctCount = results.filter(result => result.correct).length;
        const totalCount = results.length;
        const score = totalCount > 0 ? (correctCount / totalCount) * 100 : 0; // Menghindari pembagian dengan nol
        return {
            score,
            correctCount,
            incorrectCount: totalCount - correctCount
        };
    }

    // Menghitung skor dan memperbarui tampilan
    const { score, correctCount, incorrectCount } = calculateScore(examResults);
    document.getElementById('finalScore').innerText = score.toFixed(2); // Membatasi dua desimal
    document.getElementById('totalQuestions').innerText = examResults.length;
    document.getElementById('correctAnswers').innerText = correctCount;
    document.getElementById('incorrectAnswers').innerText = incorrectCount;

    // Menangani tampilan detail jawaban
    document.getElementById('viewDetailsButton').addEventListener('click', function() {
        const detailsContainer = document.getElementById('detailsContainer');
        detailsContainer.classList.toggle('d-none'); // Menampilkan/menyembunyikan detail
    });
</script>
@endsection
