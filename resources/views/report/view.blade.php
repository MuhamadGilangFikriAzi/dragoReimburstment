<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        table {
            border: 1px solid #000;
        }
    </style>
    </head>
    <body>
        <table style="border:1px solid black">
            <thead>
                <tr>
                    <td colspan="7" style="text-align:center"> <strong>Laporan Reimburstment</strong></td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align:center"><strong>{{$start}} - {{$end}}</strong></td>
                </tr>
                <tr></tr>
                <tr>
                    <td>No</td>
                    <td>Nama</td>
                    <td>Tipe pengembalian</td>
                    <td>Asal dana</td>
                    <td>Tanggal</td>
                    <td>Status</td>
                    <td>Total</td>
                </tr>
            </thead>

            <tbody style="border:1px solid black">
                @php
                    $total = 0;
                @endphp
                @foreach($data as $key => $value)
                @php
                    $total += $value->total;
                @endphp
                <tr>
                    <td>{{ $key +1 }}</td>
                    <td>{{ $value->user['name'] }}</td>
                    <td>{{$value->tipe_pengembalian}}</td>
                    <td>{{$value->asal_dana}}</td>
                    <td>{{date('d-m-Y',strtotime($value->tanggal))}}</td>
                    <td>{{$value->status}}</td>
                    <td style="text-align:right">{{ $value->total }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="6" style="text-align:right"><b> Jumlah : </b></td>
                    <td style="text-align:right"><b> {{ $total }}</b></td>
                </tr>
            </tbody>
        </table>

    </body>
</html>
