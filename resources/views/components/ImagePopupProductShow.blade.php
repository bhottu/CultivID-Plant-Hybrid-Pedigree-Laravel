<!-- ImagePopup.blade.php -->
<div id="image-popup" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-75">
    
    <div id="popup-content" class="relative max-w-screen-lg mx-auto">

        <div class="relative flex items-center justify-center">
            
            <!-- IMAGE -->
            <img id="image-popup-img"
                 src=""
                 alt="Gambar Produk"
                 class="max-w-xs md:max-w-lg max-h-[80vh] rounded shadow-lg border-4 border-white">

            <!-- CLOSE BUTTON (sekarang nempel ke image) -->
            <button id="close-popup-button"
                class="absolute top-4 right-4 text-white bg-black bg-opacity-50 p-2 rounded-full hover:bg-opacity-70">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            

        </div>

    </div>
</div>
<!-- End Popup -->
