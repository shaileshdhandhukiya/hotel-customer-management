<!-- resources/views/customers/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-10">
        <div class="mb-4">
            <a href="{{ route('customers.index') }}" class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto">Back to Customers</a>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <div class="mb-4">
                <strong>Name:</strong> {{ $customer->name }}
            </div>
            <div class="mb-4">
                <strong>Mobile Number:</strong> {{ $customer->mobile_number }}
            </div>
            <div class="mb-4">
                <strong>ID Card:</strong>
                <img src="{{ $customer->ID_card_image_url }}" alt="ID Card" class="w-20 h-auto" onclick="openImageModal('{{ Storage::url($customer->ID_card_image) }}')">
            </div>

            <div class="mb-4">
                <h3>Additional ID Cards:</h3>
                @if($customer->additional_ID_cards_urls && count($customer->additional_ID_cards_urls) > 0)
                @foreach($customer->additional_ID_cards_urls as $url)
                <img src="{{ $url }}" alt="Additional ID Card" width="200" onclick="openImageModal('{{ $url }}')">
                @endforeach
                @else
                <p>No additional ID cards uploaded.</p>
                @endif

            </div>
            <div class="mb-4">
                <strong>Vehicle Number:</strong> {{ $customer->vehicle_number }}
            </div>

        </div>
    </div>
</x-app-layout>


<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
    <div class="relative">
        <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white text-xl close-image-btn">&times;</button>
        <img id="modalImage" src="" class="max-w-full max-h-screen rounded-lg shadow-lg" alt="Full Image">
    </div>
</div>

<!-- JavaScript -->
<script>
    function openImageModal(imageUrl) {
        // Set the src attribute of the modal image
        document.getElementById('modalImage').src = imageUrl;
        // Show the modal
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeImageModal() {
        // Hide the modal
        document.getElementById('imageModal').classList.add('hidden');
    }
</script>