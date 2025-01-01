<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Tanda Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        .kartu {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .page_kartu {
            width: 210mm; /* A4 width */
            min-height: 297mm; /* A4 height */
            padding: 20mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .foto_kartu {
            width: 40mm;  /* 4 cm width */
            height: 60mm; /* 6 cm height */
            object-fit: cover;
            border: 1px solid #ccc;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #ddd;
        }

        .kop-image {
            width: 40px;  /* Sesuaikan lebar gambar sesuai keinginan */
            height: auto;  /* Biarkan tinggi menyesuaikan proporsi */
            margin-bottom: 10px; /* Ruang di bawah gambar */
        }

    </style>

</head>
<body>
    <div class="kartu">
        <div class="text-center mt-4">
            <button class="btn btn-primary btn-download" id="downloadPdf">Download PDF</button>
        </div>
        <div class="page_kartu" id="pdfContent">
            <!-- Kop image at the top -->
            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Logo Poliwangi" class="kop-image">

            <div style="margin-top: -50px">
                <h2 class="text-center fw-bold">KARTU TANDA PESERTA</h2>
                <h5 class="text-center fw-bold">{{$pendaftar->gelombangPendaftaran->nama_gelombang}} {{$pendaftar->gelombangPendaftaran->tahun_ajaran}}</h5>
            </div>

            <div class="row mt-4">
                <div class="col-md-3 text-center">
                    <img src="{{ asset('assets/file/foto/' . $pendaftar->id . '.jpg') }}" alt="Foto Peserta" class="foto_kartu">
                </div>
                <div class="col-md-9 mb">
                    <p style="margin-bottom: 5px;">Nomor Pendaftaran:<br>
                        <span class="fw-bold">{{$pendaftar->detailPendaftar->kode_pendaftaran}}</span></p>
                    <p style="margin-bottom: 5px;">Nama Siswa:<br>
                        <span class="fw-bold">{{$pendaftar->nama}}</span></p>
                    <p style="margin-bottom: 5px;">NISN:<br>
                        <span class="fw-bold">{{$pendaftar->nisn}}</span></p>
                    <p style="margin-bottom: 5px;">Sekolah:<br>
                        <span class="fw-bold">{{$pendaftar->sekolah}}</span></p>
                    <p style="margin-bottom: 5px;">Tanggal Ujian:<br>
                    <span class="fw-bold">{{$pendaftar->gelombangPendaftaran->tanggal_ujian}}</span></p>
                    <p style="margin-bottom: 5px;">Lokasi Ujian:<br>
                    <span class="fw-bold">{{$pendaftar->gelombangPendaftaran->tempat_ujian}}</span></p>
                </div>
            </div>
            <h5 class="mt-4">PILIHAN PTN & PROGRAM STUDI</h5>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Pilihan Jurusan Ke-1</th>
                        <td>{{$pendaftar->programStudi->name}}</td>
                    </tr>
                    <tr>
                        <th>Pilihan Jurusan Ke-2</th>
                        <td>{{$pendaftar->programStudi2->name ?? 'Tidak Ada Pilihan'}}</td>
                    </tr>
                    <tr>
                        <th>Pilihan Jurusan Ke-3</th>
                        <td>{{$pendaftar->prodiLain->name ?? 'Tidak Ada Pilihan'}} - {{$pendaftar->prodiLain->kampus}}</td>
                    </tr>
                </tbody>
            </table>
            <h6 class="mt-4"><strong>PERNYATAAN</strong></h6>
            <p>
                Saya menyatakan bahwa data yang saya isikan dalam formulir pendaftaran MANDIRI UTBK POLITEKNIK NEGERI SE-INDONESIA (KONSORSIUM) {{$pendaftar->gelombangPendaftaran->tahun_ajaran}} adalah benar dan saya bersedia menerima ketentuan yang berlaku di Perguruan Tinggi dan Program Studi yang saya pilih. Saya bersedia menerima sanksi pembatalan penerimaan di PTN yang saya pilih apabila melanggar pernyataan ini.
            </p>
            <p class="text-end" style="margin-right: 120px;">Tanda Tangan </p>
            <br>
            <div class="d-flex justify-content-between align-items-center w-100">
                <p>*Gunakan Nama Lengkap</p>
                <p class="text-end"><em>*(__________________________)</em></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('downloadPdf').addEventListener('click', async () => {
            const { jsPDF } = window.jspdf; // Load jsPDF from namespace
            const pdfContent = document.getElementById('pdfContent');

            // Use html2canvas to convert HTML to canvas
            const canvas = await html2canvas(pdfContent, { scale: 2 });
            const imgData = canvas.toDataURL('image/png'); // Convert canvas to image
            const pdf = new jsPDF('p', 'mm', 'a4'); // Initialize jsPDF

            // Add image to PDF with A4 page size
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save('kartu_tanda_peserta.pdf'); // Save PDF
        });
    </script>
</body>
</html>