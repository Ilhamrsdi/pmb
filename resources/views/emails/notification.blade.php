<!DOCTYPE html>
<html>

<head>
  <title>PMB Poliwangi</title>
</head>

<body>
  <h1>{{ $mailData['title'] }}</h1>
  <p>Selamat Anda Berhasil Mendaftar di PMB Poliwangi</p>
  <p>
    {{ $mailData['body'] }}
  </p>
  <hr>
  <table style="border:none;">
    <tr>
      <td>Email</td>
      <td>:</td>
      <td>{{ $mailData['email'] }}</td>
    </tr>
    <tr>
      <td>Password</td>
      <td>:</td>
      <td>{{ $mailData['password'] }}</td>
    </tr>
    <tr>
      <td>Gelombang</td>
      <td>:</td>
      <td>{{ $mailData['gelombang'] }}</td>
    </tr>
    <tr>
      <td>Program Studi</td>
      <td>:</td>
      <td>{{ $mailData['program_studi'] }}</td>
    </tr>
    <tr>
      <td>Program Studi Lain</td>
      <td>:</td>
      <td>{{ $mailData['prodi_lain'] }}</td>
    </tr>
  </table>

</body>

</html>
