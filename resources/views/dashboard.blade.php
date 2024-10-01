<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-700">{{ $greeting }}, {{ $user->name }}!</h2>
                <p class="mt-2 text-sm text-gray-600">Welcome to Somnath Hotel</p>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <dt class="text-base leading-7 text-gray-600">Total Customers</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">{{ $totalCustomers }}</dd>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>