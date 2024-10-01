<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Customer') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-10">

    @include('layouts.alert')
    
    <div class="mb-4">
            <a href="{{ route('customers.index') }}" class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto">Back to Customers</a>
        </div>

        <div class="rounded-lg bg-white p-8 shadow-lg lg:p-12">

            <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="sr-only" for="name">Name</label>
                    <input
                        class="w-full rounded-lg border-gray-200 p-3 text-sm"
                        placeholder="Name"
                        type="text"
                        name="name"
                        id="name"
                        required
                    />
                </div>

                <div>
                    <label class="sr-only" for="mobile_number">Mobile Number</label>
                    <input
                        class="w-full rounded-lg border-gray-200 p-3 text-sm"
                        placeholder="Mobile Number"
                        type="text"
                        name="mobile_number"
                        id="mobile_number"
                        required
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700" for="ID_card_image">ID Card</label>
                    <input
                        class="w-full rounded-lg border-gray-200 p-3 text-sm"
                        type="file"
                        name="ID_card_image"
                        id="ID_card_image"
                        required
                    />
                </div>

                <div>
                    <label class="sr-only" for="vehicle_number">Vehicle Number</label>
                    <input
                        class="w-full rounded-lg border-gray-200 p-3 text-sm"
                        placeholder="Vehicle Number"
                        type="text"
                        name="vehicle_number"
                        id="vehicle_number"
                        required
                    />
                </div>

                <div class="mt-4">
                    <button type="submit"
                        class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto">
                        Add Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
