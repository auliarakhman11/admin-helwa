<table class="table table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Barang</th>
            <th>Qty</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($dt_invoice as $d)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
                    @if ($d->jenis_bahan == 1)
                        {{ $d->produk->nm_produk }}
                    @else
                        {{ $d->bahan->bahan }}
                    @endif
                </td>
                <td>{{ $d->qty }}</td>
                <td>{{ number_format($d->harga, 0) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
