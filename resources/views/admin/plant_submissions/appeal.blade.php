@extends('admin.layout')

@section('content')
    <div class="container mx-auto px-4">
        <div class="mb-4">
            <h1 class="text-3xl font-semibold">Ajukan Banding</h1>
        </div>
        <div class="bg-white rounded shadow p-4 border border-gray-200 max-w-2xl">
            <div class="text-sm text-gray-600 mb-3">Kesalahan nama tanaman, Nama Penyilang, Induk atau Kesengajaan klaim palsu sepihak pada tanaman <b>{{ $submission->plant_id }}</b> dapat dilakukan banding dengan cara mengisi data dibawah ini.</div>
            <form action="{{ route('plant-submissions.appeal.store', $submission->plant_id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-800 font-semibold">ID Tanaman</label>
            <input type="text" class="w-full border border-gray-300 rounded p-2 bg-gray-100" value="{{ $submission->plant_id }}" readonly>
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Keterangan</label>
            <textarea
    name="keterangan"
    rows="5"
    required
    class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200"
>{{ old('keterangan', 
"Isi keterangan di sini.
Jelaskan asal-usul hybrid.
Sebutkan induk betina & jantan.
Tambahkan ciri khusus (mis. variegated).") }}</textarea>

            <div class="text-xs text-gray-500 mt-1">Berikan keterangan selengkap-lengkapnya kenapa ini adalah hybrid anda.</div>
            @error('keterangan') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Bukti Foto</label>
            <input type="file" name="bukti[]" multiple accept="image/*" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">
            <div class="text-xs text-gray-500 mt-1">Tambahkan Foto berupa Foto hasil hybrid, kedua induk, terdapat tanggal lebih direkomendasikan. (maksimal 5 foto, ukuran maksimal 500kb per foto)</div>
            @error('bukti') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
                <button type="submit" class="bg-gray-800 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold shadow">Kirim Banding</button>
            </form>
        </div>
    </div>
@endsection
