# WebGIS Nugal - Pratinjau

Seluruh titik pada `draft-data.csv` adalah **simulasi** dan tidak mewakili kasus, individu, perusahaan, atau lokasi nyata. Halaman bukan situs resmi dan belum disetujui lembaga.

## Pratinjau lengkap (desain terakhir)

`DEMO_HOME = true`: tampilan sama dengan `index.html` sumber, termasuk kartu profil WebGIS Nugal, cerita pilihan, titik terbaru, dan gambar placeholder. **Semua bagian berlabel "Contoh" adalah konten fiktif** (teks profil karangan, belum resmi). Bila halaman ini dipublikasikan, spanduk pratinjau dan seluruh label "Contoh" harus tetap terlihat. Versi tanpa konten fiktif: `python tools/make-preview-package.py --publish-safe` (keluaran `release/laman-preview-publish/`).

## Isi paket

- `index.html` (halaman pratinjau WebGIS Nugal)
- `draft-data.csv` (data simulasi)
- `.nojekyll`

Dokumen kerja, PRD, memori kolaborasi, pengujian, data awal, dan data Google Sheets tidak termasuk.

## Perbedaan dari sumber (dibuat oleh `tools/make-preview-package.py`)

1. `CSV_URL` menunjuk `./draft-data.csv` (simulasi) dan jalur relatif yang aman diizinkan.
2. `noindex,nofollow`, judul "PRATINJAU", dan spanduk pratinjau.
3. Keterangan jumlah di Beranda menyebut "data simulasi pratinjau".

`noindex` mengurangi pengindeksan tetapi tidak membuat URL privat: siapa pun yang menerima URL dapat membukanya.
