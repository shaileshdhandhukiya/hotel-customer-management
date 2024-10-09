<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Customer') }}
        </h2>
    </x-slot>
    <div class="container mx-auto mt-10">

        <div class="mb-4">
            <a href="{{ route('customers.index') }}" class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto">Back to Customers</a>
        </div>

        <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded" value="{{ $customer->name }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Mobile Number</label>
                <input type="text" name="mobile_number" class="mt-1 block w-full border-gray-300 rounded" value="{{ $customer->mobile_number }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">ID Card Image</label>
                <input type="file" name="ID_card_image" class="mt-1 block w-full border-gray-300 rounded" accept="image/*">
                @if($customer->ID_card_image)
                <img src="{{ Storage::url($customer->ID_card_image) }}" alt="ID Card" class="w-20 h-auto mt-2">
                @endif
            </div>

            <div class="mb-4">
                <label for="additional_ID_cards">Additional ID Cards</label>
                <input type="file" name="additional_ID_cards[]" id="additional_ID_cards" class="form-control" multiple>
                <small class="form-text text-muted">You can upload multiple additional ID card images.</small>
            </div>

            @if($customer->additional_ID_cards_urls)
            <div class="form-group">
                <label>Existing Additional ID Cards:</label>
                <div>
                    @foreach($customer->additional_ID_cards_urls as $index => $url)
                    <div style="display: inline-block; margin-right: 10px; text-align: center;">
                        <img src="{{ $url }}" alt="Additional ID Card" width="100"><br>
                        <!-- Optional: Add a delete button for each additional ID card -->
                        <form action="{{ route('customers.deleteAdditionalIDCard', [$customer->id, $index]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="mb-4">
                <label class="block text-gray-700">Vehicle Number</label>
                <input type="text" name="vehicle_number" class="mt-1 block w-full border-gray-300 rounded" value="{{ $customer->vehicle_number }}" required>
            </div>
            <button type="submit" class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto">Update Customer</button>
        </form>
    </div>
</x-app-layout>