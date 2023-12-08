<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Kartu Member</title>

    <style>
        .box {
            position: relative;
        }

        .card {
            width: 86.0001667mm;
            height: 54mm;
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
            top: 100pt;
            right: 16pt;
            font-size: 12pt;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            color: #fff !important;
        }

        .telepon {
            position: absolute;
            margin-top: -25pt;
            right: 16pt;
            color: #fff;
        }

        .barcode {
            position: absolute;
            top: 90pt;
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

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body class="card">
    <section style="border: 1px solid #fff">
        <table width="100%">

            <tr>
                <td class="text-center">
                    <div class="box">
                        <img src="{{ asset('images/member.png') }}" class="card">
                        <div class="logo">
                            <p style="margin-bottom: 30px; margin-top: 10px;">{{ config('app.name') }}</p>
                            <img src="{{ asset('images/logo.png') }}" alt="logo">
                        </div>
                        <div class="nama">{{ $member->nama }}</div>
                        <div class="telepon">{{ $member->telepon }}</div>
                        <div class="barcode text-left">
                            <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($member->kode_member, 'QRCODE') }}"
                                alt="barcode" width="45" height="45" style="padding-top: 20px">
                        </div>
                    </div>
                </td>
            </tr>

        </table>
    </section>
</body>

</html>
