
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Fasilitas FASLINK</title>
    <style>
        body { font-family: Arial; background:#f4f6f9; padding:25px; }
        .container { background:white; padding:25px; border-radius:10px; }
        table { width:100%; border-collapse:collapse; margin-top:20px; }
        th,td { padding:12px; border-bottom:1px solid #ddd; text-align:left; }
        th { background:#eaf1ff; }
        a,button { padding:7px 12px; border:0; border-radius:5px; cursor:pointer; text-decoration:none; }
        .add { background:#2563eb; color:white; }
        .edit { background:#f59e0b; color:white; }
        .delete { background:#dc2626; color:white; }
        .success { color:green; }
        .error { color:red; }
    </style>
</head>
<body>
<div class="container">
    <h2>Manajemen Fasilitas</h2>
    <p>Pengelolaan gedung, ruangan, dan barang FASLINK</p>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    <a class="add" href="{{ route('admin.facilities.create') }}">
        + Tambah Fasilitas
    </a>

    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Lokasi / Gedung</th>
            <th>Stok</th>
            <th>Kondisi</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse($facilities as $facility)
            <tr>
                <td>{{ $loop->iteration + ($facilities->currentPage()-1)*10 }}</td>
                <td>{{ $facility->name }}</td>
                <td>{{ ucfirst($facility->type) }}</td>
                <td>
                    {{ $facility->parent?->name ?? $facility->location ?? '-' }}
                </td>
                <td>
                    @if($facility->type === 'barang')
                        {{ $facility->stock_total }}
                        (Rusak: {{ $facility->stock_damaged }})
                    @elseif($facility->type === 'ruangan')
                        {{ $facility->capacity }} orang
                    @else
                        -
                    @endif
                </td>
                <td>{{ ucfirst($facility->condition) }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $facility->status)) }}</td>
                <td>
                    <a class="edit"
                       href="{{ route('admin.facilities.edit', $facility->id) }}">
                        Edit
                    </a>

                    <form action="{{ route('admin.facilities.destroy', $facility->id) }}"
                          method="POST"
                          style="display:inline"
                          onsubmit="return confirm('Yakin ingin menghapus fasilitas ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="delete" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">Belum ada data fasilitas.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $facilities->links() }}
</div>
</body>
</html>
