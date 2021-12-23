<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Member</title>

    <style>
        .text-center {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .box {
            position: relative;
        }

        .card {
            width: 85mm;
        }

        .logo {
            position: absolute;
            top: 3pt;
            right: 0pt;
            font-size: 16pt;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            color: #fff !important;
        }

        .logo p {
            text-align: right;
            margin-right: 16pt;
        }

        .logo img {
            position: absolute;
            margin-top: -5pt;
            width: 40px;
            height: 40px;
            right: 16pt;
        }

        .nama {
            position: absolute;
            top: 85pt;
            right: 16pt;
            font-size: 12pt;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            color: #fff !important;
        }

        .telepon {
            position: absolute;
            margin-top: 70pt;
            right: 70pt;
            color: #fff;

        }

        .barcode {
            position: absolute;
            top: 60pt;
            left: .860rem;
            border: 1px solid #fff;
            padding: .5px;
            background: #fff;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

    </style>
</head>

<body>
    <section style="border: 1px solid #fff">
        <table width="100%">
            @foreach ($datamember as $key => $data)
                <tr>
                    @foreach ($data as $d)
                        <td class="text-center" width="50%">
                            <div class="box">
                                <img src="{{ asset('img/member/card.png') }}" alt="card" width="95%">
                                <div class="logo">
                                    <p>{{ config('app.name') }}</p>
                                    <img src="{{ asset('img/logo.png') }}" alt="logo" width="300%" height="300%">
                                </div>
                                <div class="nama">{{ $d->nama }}</div>
                                <div class="telepon">{{ $d->telepon }}</div>
                                <div class="barcode text-left">
                                    <img src="data:image/png;base64,
                                        ,{{ DNS2D::getBarcodePNG("$d->kode_member", 'QRCODE') }}" alt="qrcode"
                                        height="40" width="40">
                                </div>
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>

    </section>

</body>

</html>
