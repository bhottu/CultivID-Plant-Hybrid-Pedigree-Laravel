@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4 max-w-lg text-xs">
    <h1 class="text-2xl font-bold mb-4">Become a Partner</h1>

    <div class="card mt-6 shadow-sm rounded-lg border border-gray-200 p-4">
            <div class="flex items-center gap-4">
                <i class="fas fa-ad text-2xl text-yellow-600"></i>
                <h2 class="text-lg font-bold text-gray-700">Advertise with Cultiv</h2>
             </div>
            <div class="mt-2">
                <h3 class="text-lg font-semibold">Why Advertise with Us?</h3>
                <ul class="list-disc list-inside text-gray-600 mt-2">
                    <li>Reach a highly engaged audience of plant enthusiasts.</li>
                    <li>Boost your brand visibility within the gardening community and plant breeder.</li>
                    <li>Drive traffic to your website or store.</li>
                    <li>Affordable advertising options for all business sizes.</li>
                </ul>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold">Other Ways to Partner</h3>
                <p class="text-gray-600 mt-2">If you are interested in other types of collaboration, please email us at <a href="mailto:support@cultiv.id" class="text-blue-600 hover:underline">support@cultiv.id</a></p>     
            </div>
        </div>

    <form id="partnerForm">
        <div class="card mt-6 shadow-sm rounded-lg border border-gray-200 p-4">
            <label class="block bg-red-100 text-xl font-semibold border-b border-gray-300 w-full mb-3"> Step 1 <label class="text-xs">(Select Ad slot)</label></label>

            <div class="mb-4">
                <label for="adSlot" class="block text-sm font-semibold mb-1">Select Ad Slot (30 Days)</label>
                <select id="adSlot" class="w-full border rounded px-3 py-2">
                    <option value="" disabled selected>Select a slot</option>
                    <option value="top-plant-detail" data-price="150000" data-slot="plant-detail-top" data-image="/partner/1.jpg">Top Banner - Plant Detail (250x100px)</option>
                    <option value="bottom-plant-detail" data-price="200000" data-slot="plant-detail-bottom" data-image="/partner/2.jpg">Bottom Banner - Plant Detail (250x250px)</option>
                    <option value="top-product-detail" data-price="250000" data-slot="product-detail-top" data-image="/partner/3.jpg">Top Banner - Product Detail (250x100px)</option>
                    <option value="bottom-product-detail" data-price="350000" data-slot="product-detail-bottom" data-image="/partner/3.jpg" disabled>Bottom Banner - Product Detail (250x250px)</option>
                    <option value="sidebar-middle-desktop" data-price="350000" data-slot="sidebar-desktop-middle" data-image="/partner/4.jpg">Sidebar middle (250x250px) Desktop Only (2 pages)</option>
                </select>
            </div>

            <div id="adPreview" class="hidden">
                <img id="adImage" src="" alt="Ad Preview" class="w-full h-auto mb-4 border border-red-500 rounded">
                <p class="text-lg font-bold">Price: Rp <span id="adPrice"></span></p>
                <p class="text-sm text-gray-600">Selected Slot: <span id="adSlotxe"></span></p>

                 <label class="block bg-red-100 text-xl font-semibold border-b border-gray-300 w-full mb-3 mt-3">Step 2 <label class="text-xs">(Scan the QRIS code below)</label></label> 
                
                 <!-- Copy Harga -->
                 <div class="mt-4">
                    <div id="priceBox"
                        onclick="copyPrice()"
                        class="cursor-pointer flex items-center justify-center gap-2 text-xl font-bold text-blue-600 bg-blue-50 p-3 rounded-lg transition hover:bg-blue-100">
                        
                        <span id="priceCopyText">Rp 0</span>

                        <!-- Copy Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-blue-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                    </div>


                    <div id="copyAlert"
                        class="text-sm text-green-600 text-center mt-2 hidden">
                        ✅ Copied to clipboard!
                    </div>
                </div>

                 <span class="text-gray-600 mt-4 block text-center">Scan the QR code below to complete your payment. input Rp <span id="adPrice2"></span></span>

                <img src="/qris-1000036271y.png" alt="QR Code" class="w-full h-auto mx-auto mt-4">

                <label class="block bg-red-100 text-xl font-semibold border-b border-gray-300 w-full mb-3 mt-3">Step 3 <label class="text-xs">(Confirm your payment)</label></label> 
                    <a id="waLink" href="#" class="block w-full text-center py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg">
                    <i class="fab fa-whatsapp text-lg"></i> Confirm Payment
                    </a>
                   

            </div>

            <button type="button" id="payButton" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mt-4 hidden">
                Pay with QRIS
            </button>

           
        </div>

                    <a href="javascript:history.back()"
                        class="block w-full text-center py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg mt-4">
                        <i class="fas fa-arrow-left mr-2"></i> 
                        Back
                    </a>
       
        
    </form>
</div>

<script>
  
document.getElementById('adSlot').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    const image = selectedOption.getAttribute('data-image');
    const slot = selectedOption.getAttribute('data-slot');

    if (price && image && slot) {

        rawPriceValue = parseInt(price); // simpan harga asli

        const formattedPrice = rawPriceValue.toLocaleString('id-ID');

        // Tampilan tetap pakai format Indonesia
        document.getElementById('adPrice').textContent = formattedPrice;
        document.getElementById('adPrice2').textContent = formattedPrice;
        document.getElementById('priceCopyText').textContent = "Rp " + formattedPrice;

        document.getElementById('adImage').src = image;
        document.getElementById('adSlotxe').textContent = slot;

        const message = `Dear CultivID, I would like to confirm the payment for the *${slot}* banner slot. *(Please do not delete or modify this message.)*`;
        const encodedMessage = encodeURIComponent(message);

        document.getElementById('waLink').href =
            `https://wa.me/6288901309732?text=${encodedMessage}`;

        document.getElementById('adPreview').classList.remove('hidden');
    }
});



function copyPrice() {

    navigator.clipboard.writeText(rawPriceValue).then(function() {

        const alertBox = document.getElementById('copyAlert');
        alertBox.classList.remove('hidden');

        setTimeout(() => {
            alertBox.classList.add('hidden');
        }, 2000);

    });

}

</script>


@endsection