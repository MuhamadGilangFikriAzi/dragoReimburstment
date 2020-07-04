<style>
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
</style>
<table border="1">
    <thead>
        <tr>
            <td colspan="9" style="text-align:center">Laporan Pengembalian Dana</td>
        </tr>
        <tr>
            <td colspan="9" style="text-align:center">{{$start}} - {{$end}}</td>
        </tr>
        <tr></tr>
        <tr>
            <td>No</td>
            <td>Nama</td>
            <td>Tanggal</td>
            <td>Asal dana</td>
            <td>Status</td>
            <td>Tipe pengembalian</td>
            <td style="text-align:right">Total asal dana</td>
            <td style="text-align:right">Digunakan</td>
            <td style="text-align:right">Dikembalikan</td>
        </tr>
    </thead>

    <tbody>
        @php
            $t_asal = 0;
            $t_digunakan = 0;
            $t_dikembalikan = 0;
        @endphp
        @foreach($data as $key => $value)
        @php
            $t_asal += $value->total_asal_dana;
            $t_digunakan += $value->total_digunakan;
            $t_dikembalikan += $value->total_digunakan;
        @endphp
        <tr>
            <td>{{ $key +1 }}</td>
            <td>{{ $value->user['name'] }}</td>
            <td>{{ date('d-m-Y',strtotime($value->tanggal)) }}</td>
            <td>{{$value->asal_dana}}</td>
            <td>{{$value->status}}</td>
            <td>{{$value->tipe_pengembalian}}</td>
            <td style="text-align:right">{{ $value->total_asal_dana }}</td>
            <td style="text-align:right">{{ $value->total_digunakan }}</td>
            <td style="text-align:right">{{ $value->total_dikembalikan }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="6" style="text-align:right">Jumlah : </td>
            <td>{{ $t_asal }}</td>
            <td>{{ $t_digunakan }}</td>
            <td>{{ $t_dikembalikan }}</td>
        </tr>
    </tbody>
</table>
