<table class="table table-hover">
    <thead>
        <tr>
            <td colspan="8" align="center">Laporan Reimburstment</td>
        </tr>
        <tr>
            <td colspan="8" align="center">{{$start}} - {{$end}}</td>
        </tr>
        <tr></tr>
        <tr>
            <td>#</td>
            <td>User</td>
            <td>Tipe pengembalian</td>
            <td>Asal dana</td>
            <td>Tanggal</td>
            <td>Status</td>
            <td class="text-right">Total asal dana</td>
            <td class="text-right">Total</td>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $key => $value)
        <tr>
            <td>{{ $key +1 }}</td>
            <td>{{ $value->user['name'] }}</td>
            <td>{{$value->tipe_pengembalian}}</td>
            <td>{{$value->asal_dana}}</td>
            <td>{{ $value->tanggal }}</td>
            <td>{{$value->status}}</td>
            @if ($value->tipe_pengembalian == 'pengembalian')
                <td class="text-right">{{ $value->total_asal_dana }}</td>
            @else
                <td></td>
            @endif
            <td class="text-right">{{ $value->total }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
