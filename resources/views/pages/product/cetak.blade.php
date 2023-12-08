<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak barcode</title>

    <style>
        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h3 class="text-center" style="padding-bottom: 10px">Barcode {{ $produk->nama_produk }}</h3>
    <table width="100%">
        <tr>
            @for ($no = 1; $no <= 72; $no++)
                <td class="text-center" style="border: 1px solid #333;">
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($produk->kode_produk, 'C39') }}"
                        alt="barcode" width="90" height="30" style="padding-top: 20px">
                    <br>
                    <small style="font-size: 11px">{{ $produk->kode_produk }}</small>
                </td>
                @if ($no % 6 == 0)
        </tr>
        <tr>
            @endif
            @endfor

        </tr>
    </table>
</body>

</html>
