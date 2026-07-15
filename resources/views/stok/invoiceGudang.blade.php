<table class="table table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice</th>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($dt_invoice as $d)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $d->no_invoice }}</td>
                <td>{{ date('d/m/Y', strtotime($d->tgl)) }}</td>
                <td>
                    @if ($d->jenis == 1)
                        Masuk
                    @else
                        Keluar
                    @endif
                </td>
                <td>{{ number_format($d->ttl_harga, 0) }}</td>
                <td><button type="button" data-bs-toggle="modal" data-bs-target="#modal_detail_invoice"
                        no_invoice="{{ $d->no_invoice }}" class="btn btn-info btn-sm detail_invoice"><i
                            class="fas fa-search"></i></button> <a href="{{ route('deleteInvoice', $d->no_invoice) }}"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Apakah anda yakin ingin menghapus data?')"><i
                            class="fas fa-trash"></i></a></td>
            </tr>
        @endforeach
    </tbody>
</table>
