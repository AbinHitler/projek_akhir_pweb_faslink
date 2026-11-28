@if($f['jenis'] === 'gedung')Lokasi: {{ $f['lokasi'] }}@elseif($f['jenis'] === 'ruangan')Kapasitas: {{ $f['jumlah'] }} orang @else Stok: {{ $f['jumlah'] }} unit @endif
