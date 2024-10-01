<!-- resources/views/customers/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-10">
        <div class="bg-white p-6 rounded shadow">
            <div class="mb-4">
                <strong>Name:</strong> {{ $customer->name }}
            </div>
            <div class="mb-4">
                <strong>Mobile Number:</strong> {{ $customer->mobile_number }}
            </div>
            <div class="mb-4">
                <strong>ID Card:</strong>
                <img src="{{ $customer->ID_card_image_url }}" alt="ID Card" class="w-20 h-auto">
            </div>
            <div class="mb-4">
                <strong>Vehicle Number:</strong> {{ $customer->vehicle_number }}
            </div>
            <div class="mb-4">
                <a href="{{ route('customers.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Back to Customers</a>
            </div>
        </div>
    </div>
</x-app-layout>
