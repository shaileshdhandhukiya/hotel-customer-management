<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer') }}
        </h2>
    </x-slot>

    @include('layouts.alert')

    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Customers</h1>

        <!-- Search Form -->
        <div class="mb-4" style="
            display: flex;
            justify-content: space-between;
            align-items: center;
        ">

            <a href="{{ route('customers.create') }}" class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto">Add Customer</a>
        </div>        

        <div class="overflow-x-auto mt-5">
            <table id="customersTable" class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">SR No.</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Mobile Number</th>
                        <th class="py-2 px-4 border-b">ID Card</th>
                        <th class="py-2 px-4 border-b">Vehicle Number</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($customers as $customer)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ $i }}</td>
                        <td class="py-2 px-4 border-b">{{ $customer->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $customer->mobile_number }}</td>
                        <td class="py-2 px-4 border-b">
                            <img src="{{ Storage::url($customer->ID_card_image) }}" alt="ID Card" class="inline-block h-6 w-6 rounded-full ring-2 ring-white"
                            onclick="openImageModal('{{ Storage::url($customer->ID_card_image) }}')" 
                            >
                        </td>
                        <td class="py-2 px-4 border-b">{{ $customer->vehicle_number }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('customers.show', $customer) }}" class="bg-green-500 text-white px-2 py-1 rounded">View</a>
                            <a href="{{ route('customers.edit', $customer) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                            <button class="bg-red-500 text-white px-2 py-1 rounded" type="button" onclick="openDeleteModal('{{ route('customers.destroy', $customer) }}')">Delete</button>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-500 bg-opacity-75">
        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
            <h3 class="text-lg font-semibold mb-4">Confirm Delete</h3>
            <p>Are you sure you want to delete this customer?</p>
            <div class="mt-4 flex justify-end">
                <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2" onclick="closeModal()">Cancel</button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script>
         // Auto-hide the success message after 5 seconds
        setTimeout(function() {
            const alertBox = document.querySelector('.alert-success');
            if (alertBox) {
                alertBox.style.display = 'none';
            }
        }, 5000); // 5 seconds
        
        $(document).ready(function() {
            $('#customersTable').DataTable({
                pagingType: "full_numbers", // Use full numbers for pagination
                lengthMenu: [5, 10, 25, 50], // Options for records per page
                pageLength: 10, // Default records per page
                order: [
                    [0, 'asc']
                ], // Default ordering
                language: {
                    paginate: {
                        first: '<span class="px-2 py-2 rounded bg-gray-200 hover:bg-gray-300">First</span>',
                        last: '<span class="px-2 py-2 rounded bg-gray-200 hover:bg-gray-300">Last</span>',
                        next: '<span class="px-2 py-2 rounded bg-gray-200 hover:bg-gray-300">Next</span>',
                        previous: '<span class="px-2 py-2 rounded bg-gray-200 hover:bg-gray-300">Previous</span>'
                    }
                },
                drawCallback: function() {
                    // Add Tailwind CSS classes to pagination number buttons
                    $('.dataTables_paginate .paginate_button').addClass('inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-200 transition ease-in-out duration-150');
                    $('.dataTables_paginate .paginate_button.current').addClass('bg-blue-500 text-white border-blue-500');
                    $('.dataTables_paginate .paginate_button.disabled').addClass('text-gray-400 cursor-not-allowed');
                }
            });

            // Override the default pagination styles
            $('#customersTable_paginate').addClass('flex justify-between items-center mt-4');
            $('#customersTable_length').addClass('flex items-center mb-4');
            $('#customersTable_length select').addClass('border border-gray-300 rounded p-1 mr-2'); // Dropdown styling
        });

        function openDeleteModal(actionUrl) {
            document.getElementById('deleteForm').action = actionUrl; // Set the form action
            document.getElementById('deleteConfirmationModal').classList.remove('hidden'); // Show the modal
        }

        function closeModal() {
            document.getElementById('deleteConfirmationModal').classList.add('hidden'); // Hide the modal
        }
    </script>


    <style>
        .dataTables_paginate a {
            @apply inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-200 transition ease-in-out duration-150;
        }

        .dataTables_paginate a.current {
            @apply bg-blue-500 text-white border-blue-500;
        }

        .dataTables_paginate .disabled {
            @apply text-gray-400 cursor-not-allowed;
        }

        .dataTables_wrapper .dataTables_length select{
            padding: 3px 30px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.last,
        .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
        .dataTables_wrapper .dataTables_paginate .paginate_button.next{
            border:unset !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:active,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
            background: transparent !important;
            color: black !important;
            /* border:unset !important; */
        }
    </style>
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