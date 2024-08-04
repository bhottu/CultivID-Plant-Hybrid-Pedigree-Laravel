@extends('admin.layout')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6">Edit API Settings</h2>
            <form action="{{ route('admin.membara-settings.update') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="api_key" class="block text-sm font-medium text-gray-700">API Key</label>
                    <input type="text" id="api_key" name="api_key" value="{{ $settings->api_key }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-s" required>
                </div>
                <div class="mb-4">
                    <label for="api_secret" class="block text-sm font-medium text-gray-700">API Secret</label>
                    <input type="text" id="api_secret" name="api_secret" value="{{ $settings->api_secret }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-s" required>
                </div>
                <div class="mb-4">
                    <label for="redirect_uri" class="block text-sm font-medium text-gray-700">Redirect URI</label>
                    <input type="text" id="redirect_uri" name="redirect_uri" value="{{ $settings->redirect_uri }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-s">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save Settings</button>
            </form>

            @if (session('success'))
                <div class="mt-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="text-2xl font-semibold mt-6 mb-4">Verify License</h2>
            <form id="verify-license-form" action="{{ route('admin.verify-license') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="purchase_code" class="block text-sm font-medium text-gray-700">Purchase Code</label>
                    <input type="text" id="purchase_code" name="purchase_code" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-s" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Verify License</button>
            </form>

            <div id="license-verification-result" class="mt-4"></div>
        </div>
    </div>

    <script>
        document.getElementById('verify-license-form').addEventListener('submit', async function(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const resultDiv = document.getElementById('license-verification-result');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.status === 'success') {
                    resultDiv.innerHTML = `<p class="text-green-700">${data.message}</p>`;
                } else {
                    resultDiv.innerHTML = `<p class="text-red-700">${data.message}</p>`;
                }
            } catch (error) {
                resultDiv.innerHTML = `<p class="text-red-700">An error occurred while verifying the license.</p>`;
            }
        });
    </script>
@endsection
