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
            <div id="optionsContainer"></div>
            <button class="btn btn-success mt-3" id="nextQuestionButton">Selanjutnya</button>
        </div>
    </div>
</div>
@endsection

@section('script')
{{-- <script>
    let currentQuestion = 0;
    const questions = @json($soals); // Mengambil soal dari database
    const answers = {}; // Menyimpan jawaban sementara

    document.getElementById('startExamButton').addEventListener('click', function(event) {
        event.preventDefault();

        // Mengaktifkan mode fullscreen
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        }

        // Menyembunyikan instruksi dan tombol mulai
        document.getElementById('instructionsCard').classList.add('d-none');
        this.classList.add('d-none');

        // Menampilkan kontainer ujian
        document.getElementById('examContainer').classList.remove('d-none');
        loadQuestion(currentQuestion); // Memuat pertanyaan pertama
    });

    function loadQuestion(index) {
        if (index >= questions.length) return;

        const question = questions[index];
        document.getElementById('questionTitle').innerText = `Pertanyaan ${index + 1}`;
        document.getElementById('questionText').innerText = question.soal;

        const optionsContainer = document.getElementById('optionsContainer');
        optionsContainer.innerHTML = '';
        
        // Load options dynamically
        optionsContainer.innerHTML += `
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" value="A" id="optionA">
                <label class="form-check-label" for="optionA">${question.jawaban}</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" value="B" id="optionB">
                <label class="form-check-label" for="optionB">${question.jawaban1}</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" value="C" id="optionC">
                <label class="form-check-label" for="optionC">${question.jawaban2}</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" value="D" id="optionD">
                <label class="form-check-label" for="optionD">${question.jawaban3}</label>
            </div>
        `;

        // Load saved answer if exists
        if (answers[question.id]) {
            document.querySelector(`input[name="options"][value="${answers[question.id]}"]`).checked = true;
        }
    }

    document.getElementById('nextQuestionButton').addEventListener('click', function() {
        const selectedOption = document.querySelector('input[name="options"]:checked');
        
        if (selectedOption) {
            answers[questions[currentQuestion].id] = selectedOption.value;
        } else {
            alert("Silakan pilih jawaban terlebih dahulu.");
            return;
        }

        currentQuestion++;
        if (currentQuestion < questions.length) {
            loadQuestion(currentQuestion);
        } else {
            alert("Ujian telah selesai!");
            submitAnswers();
        }
    });

    function submitAnswers() {
        // Mengirim jawaban ke server menggunakan AJAX
        $.ajax({
            url: "{{ route('storeAnswers') }}", // Pastikan route sesuai dengan controller penyimpanan
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                answers: answers,
                pendaftar_id: "{{ $pendaftar_id }}" // Pastikan pendaftar_id tersedia
            },
            success: function(response) {
                alert("Jawaban berhasil disimpan.");
                window.location.href = "{{ route('pendaftar.ujian.result', ['pendaftar_id' => $pendaftar_id]) }}";
            },
            error: function(xhr) {
                console.error(xhr.responseText); // Log error response
                alert("Terjadi kesalahan saat menyimpan jawaban: " + xhr.responseText);
            }
        });
    }
</script> --}}
@endsection
