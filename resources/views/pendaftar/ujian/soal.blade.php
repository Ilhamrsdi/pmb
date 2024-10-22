@extends('layouts.master')
@section('title', 'Ujian CBT')

@section('content')
<div class="container">
    <div class="text-center my-4">
        <h1>Ujian CBT</h1>
        <p class="lead">Selamat datang di ujian CBT. Silakan baca instruksi di bawah ini.</p>
    </div>

    <div class="card mb-4" id="instructionsCard">
        <div class="card-header">
            <h5>Instruksi</h5>
        </div>
        <div class="card-body">
            <p>1. Pastikan Anda berada di tempat yang tenang dan tidak terganggu.</p>
            <p>2. Ujian ini memiliki total <strong>{{ count($soals) }} pertanyaan</strong>.</p>
            <p>3. Waktu ujian adalah <strong>60 menit</strong>.</p>
            <p>4. Klik "Mulai Ujian" untuk memulai.</p>
        </div>
    </div>

    <button class="btn btn-primary" id="startExamButton">Mulai Ujian</button>
    
    <div id="examContainer" class="mt-4 d-none">
        <div class="question-container">
            <h5 id="questionTitle"></h5>
            <p id="questionText"></p>
            <div id="optionsContainer"></div> <!-- Tambahkan div ini untuk menampung pilihan -->
            <button class="btn btn-success mt-3" id="nextQuestionButton">Selanjutnya</button>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let currentQuestion = 0;
    const questions = @json($soals); // Mengambil soal dari database yang sudah di-pass dari controller

    document.getElementById('startExamButton').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah aksi default link
        
        // Mengaktifkan fullscreen
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) { // Firefox
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari, and Opera
            document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
            document.documentElement.msRequestFullscreen();
        }

        // Menonaktifkan elemen lain
        document.getElementById('instructionsCard').classList.add('d-none'); // Menyembunyikan instruksi
        this.classList.add('d-none'); // Menyembunyikan tombol mulai ujian

        document.getElementById('examContainer').classList.remove('d-none'); // Menampilkan kontainer ujian
        loadQuestion(currentQuestion); // Memuat pertanyaan pertama

        // Menangani event keydown untuk menyelesaikan ujian jika tombol Esc ditekan
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                event.preventDefault(); // Mencegah aksi default tombol Esc
                alert("Ujian dinyatakan selesai!");
                // Logic untuk menyelesaikan ujian
                finishExam();
            }
        });
    });

    function loadQuestion(index) {
        if (index >= questions.length) return; // Jika melebihi jumlah soal, hentikan

        const question = questions[index];
        document.getElementById('questionTitle').innerText = `Pertanyaan ${index + 1}`;
        document.getElementById('questionText').innerText = question.soal;

        // Clear previous options
        const optionsContainer = document.getElementById('optionsContainer');
        optionsContainer.innerHTML = '';
        
        // Load options dynamically
        optionsContainer.innerHTML += `
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" id="option1" value="${question.jawaban}">
                <label class="form-check-label" for="option1">${question.jawaban}</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" id="option2" value="${question.jawaban1}">
                <label class="form-check-label" for="option2">${question.jawaban1}</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" id="option3" value="${question.jawaban2}">
                <label class="form-check-label" for="option3">${question.jawaban2}</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" id="option4" value="${question.jawaban3}">
                <label class="form-check-label" for="option4">${question.jawaban3}</label>
            </div>
        `;
    }

    document.getElementById('nextQuestionButton').addEventListener('click', function() {
        // Logic untuk menyimpan jawaban bisa ditambahkan di sini
        currentQuestion++;
        if (currentQuestion < questions.length) {
            loadQuestion(currentQuestion);
        } else {
            alert("Ujian telah selesai!");
            finishExam();
        }
    });

    function finishExam() {
        // Logika untuk menyelesaikan ujian dan menyimpan hasil
        // Redirect atau tampilkan hasil ujian
        window.location.href = "/pendaftar.ujian.result"; // Ganti dengan rute hasil ujian
    }
</script>
@endsection
