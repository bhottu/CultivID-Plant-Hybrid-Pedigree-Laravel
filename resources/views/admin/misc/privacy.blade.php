@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8 max-w-lg text-sm">
    <div class="bg-white shadow-md rounded p-6">
        <h1 class="text-3xl font-bold mb-4">Privacy Policy</h1>
       <!-- <div class="text-gray-600">{!! $settings->privacy_policy ?? 'No privacy available.' !!}</div>-->

       <div class="bg-white space-y-6">

    <!-- Translate Button -->
    <div class="flex justify-start">
        <button
            id="translateBtn"
            class="text-sm px-4 py-2 border rounded-lg text-green-600 border-green-600 hover:bg-green-600 hover:text-white transition"
        >
            Translate to English
        </button>
    </div>

    <!-- CONTENT -->
    <div id="privacyContent" data-lang="id">

       

        <p class="text-gray-700 leading-relaxed mb-2">
            <strong>Cultiv</strong> menghargai dan melindungi privasi setiap pengguna yang mengakses
            dan menggunakan platform kami. Dokumen Kebijakan Privasi ini menjelaskan bagaimana
            kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi Anda.
        </p>

        <h2 class="text-xl font-semibold text-gray-800">
            Informasi yang Kami Kumpulkan
        </h2>

        <p class="text-gray-700 leading-relaxed  mb-2">
            Kami dapat mengumpulkan informasi pribadi seperti nama, alamat email, nomor telepon,
            serta data lain yang Anda berikan secara sukarela saat mendaftar akun, mengisi formulir,
            atau berinteraksi dengan fitur di platform Cultiv.
        </p>

        <h2 class="text-xl font-semibold text-gray-800">
            Penggunaan Informasi
        </h2>

        <p class="text-gray-700 leading-relaxed">
            Informasi yang dikumpulkan digunakan untuk:
        </p>

        <ul class="list-disc list-inside text-gray-700 space-y-1  mb-2">
            <li>Mengelola akun pengguna</li>
            <li>Menyediakan dan meningkatkan layanan Cultiv</li>
            <li>Menjaga keamanan dan integritas platform</li>
            <li>Komunikasi terkait layanan dan pembaruan</li>
        </ul>

        <h2 class="text-xl font-semibold text-gray-800">
            Keamanan Data
        </h2>

        <p class="text-gray-700 leading-relaxed  mb-2">
            Kami menerapkan langkah-langkah keamanan teknis dan administratif yang wajar untuk
            melindungi data pengguna. Kata sandi pengguna disimpan dalam bentuk yang telah
            diamankan menggunakan metode keamanan sesuai standar industri dan tidak disimpan
            dalam bentuk teks asli (plain text).
        </p>

        <h2 class="text-xl font-semibold text-gray-800">Penggunaan Payment Gateway</h2>
        <p class="text-gray-700 leading-relaxed  mb-2">
            Untuk memproses pembayaran, Cultiv bekerja sama dengan penyedia layanan
            pembayaran pihak ketiga seperti payment gateway. Data pembayaran pengguna
            diproses langsung oleh penyedia layanan tersebut sesuai dengan kebijakan
            privasi dan standar keamanan mereka masing-masing.
        </p>


        <h2 class="text-xl font-semibold text-gray-800">
            Pembagian Informasi
        </h2>

        <p class="text-gray-700 leading-relaxed  mb-2">
            Cultiv tidak menjual, menyewakan, atau membagikan informasi pribadi pengguna kepada
            pihak ketiga tanpa persetujuan, kecuali diwajibkan oleh hukum.
        </p>

        <h2 class="text-xl font-semibold text-gray-800">
            Perubahan Kebijakan
        </h2>

        <p class="text-gray-700 leading-relaxed mb-2">
            Kebijakan Privasi ini dapat diperbarui sewaktu-waktu. Perubahan akan ditampilkan
            pada halaman ini dan berlaku sejak tanggal diperbarui.
        </p>

        <p class="text-sm text-gray-500 pt-4  mb-2">
            Dengan menggunakan platform Cultiv, Anda dianggap telah membaca, memahami,
            dan menyetujui Kebijakan Privasi ini.
        </p>

    </div>
</div>

<script>
    const btn = document.getElementById('translateBtn');
    const content = document.getElementById('privacyContent');

    const englishVersion = `
        

        <p class="text-gray-700 leading-relaxed mb-2">
            <strong>Cultiv</strong> respects and protects the privacy of every user who accesses
            and uses our platform. This Privacy Policy explains how we collect, use, store,
            and protect your personal information.
        </p>

        <h2 class="text-xl font-semibold text-gray-800">Information We Collect</h2>

        <p class="text-gray-700 leading-relaxed mb-2">
            We may collect personal information such as name, email address, phone number,
            and other data voluntarily provided when you register, submit forms,
            or interact with Cultiv features.
        </p>

        <h2 class="text-xl font-semibold text-gray-800">Use of Information</h2>

        <ul class="list-disc list-inside text-gray-700 space-y-1 mb-2">
            <li>Managing user accounts</li>
            <li>Providing and improving Cultiv services</li>
            <li>Maintaining platform security</li>
            <li>Service-related communications</li>
        </ul>

        <h2 class="text-xl font-semibold text-gray-800">Data Security</h2>

        <p class="text-gray-700 leading-relaxed mb-2">
            We apply reasonable technical and administrative measures to protect
            user data from unauthorized access, alteration, or disclosure.
        </p>

        <h2 class="text-xl font-semibold text-gray-800">Use of Payment Gateway</h2>
        <p class="text-gray-700 leading-relaxed mb-2">
            To process payments, Cultiv cooperates with third-party payment service
            providers such as payment gateways. Users’ payment data is processed
            directly by these service providers in accordance with their respective
            privacy policies and security standards.
        </p>


        <h2 class="text-xl font-semibold text-gray-800">Information Sharing</h2>

        <p class="text-gray-700 leading-relaxed mb-2">
            Cultiv does not sell, rent, or share personal information with third parties
            without consent, except as required by law.
        </p>

        <h2 class="text-xl font-semibold text-gray-800">Policy Changes</h2>

        <p class="text-gray-700 leading-relaxed mb-2">
            This Privacy Policy may be updated from time to time. Changes will be posted
            on this page and take effect immediately.
        </p>

        <p class="text-sm text-gray-500 pt-4">
            By using Cultiv, you agree to this Privacy Policy.
        </p>
    `;

    const indonesiaVersion = content.innerHTML;

    btn.addEventListener('click', () => {
        if (content.dataset.lang === 'id') {
            content.innerHTML = englishVersion;
            content.dataset.lang = 'en';
            btn.textContent = 'Translate to Indonesian';
        } else {
            content.innerHTML = indonesiaVersion;
            content.dataset.lang = 'id';
            btn.textContent = 'Translate to English';
        }
    });
</script>


    </div>
</div>
@endsection
