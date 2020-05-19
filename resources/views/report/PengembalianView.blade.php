<table>
    <thead align="center">
        <tr>
            <td colspan="9" >Laporan Pengembalian Dana</td>
        </tr>
        <tr>
            <td colspan="9" >{{$start}} - {{$end}}</td>
        </tr>
        <tr></tr>
        <tr>
            <td>No</td>
            <td>User</td>
            <td>Tanggal</td>
            <td>Asal dana</td>
            <td>Status</td>
            <td>Tipe pengembalian</td>
            <td align="right">Total asal dana</td>
            <td align="right">Digunakan</td>
            <td align="right">Dikembalikan</td>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $key => $value)
        <tr>
            <td>{{ $key +1 }}</td>
            <td>{{ $value->user['name'] }}</td>
            <td>{{ $value->tanggal }}</td>
            <td>{{$value->asal_dana}}</td>
            <td>{{$value->status}}</td>
            <td>{{$value->tipe_pengembalian}}</td>
            <td align="right">{{ number_format($value->total_asal_dana,0,",",".") }}</td>
            <td align="right">{{ number_format($value->total_digunakan,0,",",".") }}</td>
            <td align="right">{{ number_format($value->total_dikembalikan,0,",",".") }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
