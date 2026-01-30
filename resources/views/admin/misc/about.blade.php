@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8 max-w-lg text-sm dark:text-gray-400">
    <div class="bg-white shadow-md rounded p-6">
        <h1 class="text-3xl font-bold mb-4">About Us</h1>
        <!-- <p style="margin-bottom: 15px; line-height: 1.6;">{!! $settings->about_us ?? 'No about us available.' !!}</p> -->


    <div class="bg-white space-y-6">

    <!-- Translate Button -->
    <div class="flex justify-start">
        <button
            id="translateBtn"
            class="text-sm px-4 py-2 border rounded-lg text-green-600 border-green-600 hover:bg-green-600 hover:text-white transition">
            Translate to English
        </button>
    </div>

    <!-- Indonesian -->
    <div id="content-id" class="space-y-6">
        <p class="text-gray-700 leading-relaxed dark:text-gray-400">
            <strong>Cultiv</strong> adalah sebuah komunitas pecinta tanaman yang berfokus pada
            pengumpulan, dokumentasi, dan berbagi informasi seputar tanaman hias, tanaman langka,
            serta berbagai hasil persilangan (hybrid).
        </p>

        <p class="text-gray-700 leading-relaxed dark:text-gray-400">
            Platform ini dibangun untuk menjadi ruang kolaboratif bagi para penghobi, kolektor,
            dan peneliti tanaman agar dapat saling berbagi pengetahuan, pengalaman, dan referensi
            secara terbuka dan bertanggung jawab.
        </p>

        <p class="text-gray-700 leading-relaxed dark:text-gray-400">
            Cultiv tidak hanya berfungsi sebagai katalog tanaman, tetapi juga sebagai wadah komunitas
            yang mendorong edukasi, transparansi data, dan pengembangan pengetahuan di bidang
            hortikultura.
        </p>
    </div>

    <!-- English -->
    <div id="content-en" class="space-y-6 hidden">
        <p class="text-gray-700 leading-relaxed dark:text-gray-400">
            <strong>Cultiv</strong> is a community of plant enthusiasts focused on collecting,
            documenting, and sharing information about ornamental plants, rare plants, and
            various hybrid cultivars.
        </p>

        <p class="text-gray-700 leading-relaxed dark:text-gray-400">
            This platform was created as a collaborative space for hobbyists, collectors,
            and plant researchers to openly and responsibly exchange knowledge, experiences,
            and references.
        </p>

        <p class="text-gray-700 leading-relaxed dark:text-gray-400">
            Cultiv serves not only as a plant catalog, but also as a community hub that promotes
            education, data transparency, and the continuous development of knowledge in the
            field of horticulture.
        </p>
    </div>

    <hr class="my-6">

    <h2 class="text-xl font-semibold text-gray-800">
        Contact Information
    </h2>

    <ul class="text-gray-700 space-y-2 dark:text-gray-400">
        <li>
            <strong>Email:</strong>
            <a href="mailto:support@cultiv.id" class="text-green-600 hover:underline">
                support@cultiv.id
            </a>
        </li>
        <li>
            <strong>Phone / WhatsApp:</strong>
            <a href="tel:+6288901309732" class="text-green-600 hover:underline">
                +62 889 0130 9732
            </a>
        </li>
        <li>
            <strong>Address:</strong><br>
            Jl Cagak No. 5, Tajur Halang, Bojong Gede, Bogor, West Java, Indonesia
        </li>
    </ul>

    <p class="text-sm text-gray-500 pt-4 dark:text-gray-400">
        We are committed to maintaining a positive, informative, and beneficial community
        environment for all plant enthusiasts.
    </p>

</div>

<script>
    const btn = document.getElementById('translateBtn');
    const idContent = document.getElementById('content-id');
    const enContent = document.getElementById('content-en');

    btn.addEventListener('click', () => {
        const isEnglish = !enContent.classList.contains('hidden');

        idContent.classList.toggle('hidden', !isEnglish);
        enContent.classList.toggle('hidden', isEnglish);

        btn.textContent = isEnglish
            ? 'Translate to English'
            : 'Bahasa Indonesia';
    });
</script>





    </div>
    
</div>
@endsection
