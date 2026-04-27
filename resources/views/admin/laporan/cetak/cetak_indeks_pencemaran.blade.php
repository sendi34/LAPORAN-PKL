<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Lokasi</th>
            <th>Alamat</th>
            <th>Peruntukan</th>
            <th>Tahun</th>
            <th>Periode</th>
            <th>Jml Param</th>
            <th>(Ci/Lij) Rata</th>
            <th>(Ci/Lij) Maks</th>
            <th>Nilai IP</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $i => $row)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->kode_lokasi }}</td>
            <td>{{ $row->alamat_lokasi }}</td>
            <td>{{ $row->peruntukan }}</td>
            <td>{{ $row->tahun }}</td>
            <td>{{ $row->periode == 1 ? 'I' : 'II' }}</td>
            <td>{{ $row->jumlah_param }}</td>
            <td>{{ $row->rata_rasio }}</td>
            <td>{{ $row->maks_rasio }}</td>
            <td><strong>{{ $row->nilai_ip }}</strong></td>
            <td>
                @if ($row->status == 'Memenuhi Baku Mutu')
                    <span class="badge bg-success">Memenuhi</span>
                @elseif ($row->status == 'Tercemar Ringan')
                    <span class="badge bg-warning">Tercemar Ringan</span>
                @elseif ($row->status == 'Tercemar Sedang')
                    <span class="badge bg-orange" style="background:#fd7e14">Tercemar Sedang</span>
                @else
                    <span class="badge bg-danger">Tercemar Berat</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>