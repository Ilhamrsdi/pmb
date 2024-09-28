<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Attribut Maba</title>
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <div class="row">
        <h3>
            <center>Bukti Pengambilan Attribut Mahasiswa Baru Poliwangi</center>
        </h3><br>
        <div class="col-md-12">
            <table>
                <tr>
                    <th width="130px">NIK</th>
                    <th width="30px">:</th>
                    <th style="font-weight: normal">{{ $data['nik'] }}</th>
                </tr>
                <tr>
                    <th width="130px">Nama Mahasiswa</th>
                    <th width="30px">:</th>
                    <th style="font-weight: normal">{{ $data['nama'] }}</th>
                </tr>
                <tr>
                    <th width="130px">Gelombang Pendaftaran</th>
                    <th width="30px">:</th>
                    <th style="font-weight: normal">
                        {{ $data['gelombang'] }} -
                        {{ $data['tahun_ajaran'] }}
                    </th>
                </tr>
            </table>
            <table class="table align-middle table-bordered" id="customerTable">
                <thead class="table table-bordered table-nowrap">
                    <tr>
                        <th class="text-center" rowspan="1" colspan="5" data-sort="status">
                            ATTRIBUT</th>
                        <th rowspan="2" colspan="1" data-sort="email">TANDA TANGAN
                        </th>
                    </tr>
                    <tr role="row">
                        <th rowspan="1" colspan="1" data-sort="date">KAOS</th>
                        <th rowspan="1" colspan="1" data-sort="date">TOPI</th>
                        <th rowspan="1" colspan="1" data-sort="email">ALMAMATER</th>
                        <th rowspan="1" colspan="1" data-sort="email">JAS LAB</th>
                        <th rowspan="1" colspan="1" data-sort="email">BAJU LAPANGAN
                        </th>
                    </tr>
                </thead>
                <tbody class="list form-check-all" id="tbodyPendaftarID">
                    <tr role="row">
                        <td class="date text-center">{{ $data['kaos'] }}</td>
                        <td class="date text-center">{{ $data['topi'] }}</td>
                        <td class="email text-center">{{ $data['almamater'] }}</td>
                        <td class="email text-center">{{ $data['jas_lab'] }}</td>
                        <td class="email text-center">{{ $data['baju_lapangan'] }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
