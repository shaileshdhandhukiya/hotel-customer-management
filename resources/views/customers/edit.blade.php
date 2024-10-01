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
                <label class="block text-gray-700">Vehicle Number</label>
                <input type="text" name="vehicle_number" class="mt-1 block w-full border-gray-300 rounded" value="{{ $customer->vehicle_number }}" required>
            </div>
            <button type="submit" class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto">Update Customer</button>
        </form>
    </div>
</x-app-layout>