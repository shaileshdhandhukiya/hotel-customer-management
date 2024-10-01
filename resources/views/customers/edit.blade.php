<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Customer') }}
        </h2>
    </x-slot>
    <div class="container mx-auto mt-10">
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
                <label class="block text-gray-700">Vehicle Number</label>
                <input type="text" name="vehicle_number" class="mt-1 block w-full border-gray-300 rounded" value="{{ $customer->vehicle_number }}" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Customer</button>
        </form>
    </div>
</x-app-layout>