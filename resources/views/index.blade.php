<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div>
                    <h2><a href="https://www.malasngoding.com">www.malasngoding.com</a></h2>
                    <h3>Data Pegawai</h3>
                
                
                    <p>Cari Data Pegawai :</p>
                    <form action="/pegawai/cari" method="GET">
                        <input type="text" name="cari" placeholder="Cari Pegawai .." value="{{ old('cari') }}">
                        <input type="submit" value="CARI">
                    </form>
                        
                    <br/>
                    <table border="1">
                        <thead>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Umur</th>
                            <th>Alamat</th>
                        </thead>
                        <tbody>
                            @foreach($pegawai)
                            <tr>
                                <td>{{ $pegawai->nama }}</td>
                                <td>{{ $pegawai->jabatan }}</td>
                                <td>{{ $pegawai->umur }}</td>
                                <td>{{ $pegawai->alamat }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    Halaman : {{ $pegawai->currentPage() }} <br>
                    Jumlah data : {{ $pegawai->total() }} <br>
                    data per halaman : {{ $pegawai->perPage() }} <br>

                    {{ $pegawai->links() }}
                </div>
            </div>
        </div>
    </body>
</html>
