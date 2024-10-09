<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function __construct()
    {
        // Restrict access to admin users only
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->type === 'admin') {
                return $next($request);
            }

            return redirect()->route('dashboard')->with('error', 'Access denied. Admins only.');
        });
    }

    public function index(Request $request)
    {
        $query = $request->input('search');
        $customers = Customer::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', '%' . $query . '%')
                ->orWhere('mobile_number', 'like', '%' . $query . '%')
                ->orWhere('vehicle_number', 'like', '%' . $query . '%');
        })->get();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function show(Customer $customer)
    {
        $customer->ID_card_image_url = Storage::url($customer->ID_card_image); // Ensure that the image path is correct for display
        // Convert additional_ID_cards paths to URLs
        if ($customer->additional_ID_cards) {
            $customer->additional_ID_cards_urls = array_map(function ($path) {
                return Storage::url($path);
            }, $customer->additional_ID_cards);
        } else {
            $customer->additional_ID_cards_urls = [];
        }

        return view('customers.show', compact('customer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:10',
            'ID_card_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'vehicle_number' => 'required|string|max:50',
            'additional_ID_cards.*' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Validation for each additional ID card
        ]);

        try {
            // Handle the primary ID card image upload
            $idCardPath = $request->file('ID_card_image')->store('id_cards', 'public');

            // Initialize an array to hold additional ID card paths
            $additionalIdCardPaths = [];

            // Check if additional ID cards are uploaded
            if ($request->hasFile('additional_ID_cards')) {
                foreach ($request->file('additional_ID_cards') as $file) {
                    $path = $file->store('additional_id_cards', 'public');
                    $additionalIdCardPaths[] = $path;
                }
            }

            // Create the customer record
            Customer::create([
                'name' => $request->name,
                'mobile_number' => $request->mobile_number,
                'ID_card_image' => $idCardPath,
                'vehicle_number' => $request->vehicle_number,
                'additional_ID_cards' => $additionalIdCardPaths, // Save additional ID cards
            ]);

            return redirect()->route('customers.index')->with('success', 'Customer created successfully.');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error creating customer: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the customer.');
        }
    }

    public function edit(Customer $customer)
    {
        // Optionally, convert additional ID card paths to URLs for the edit view
        if ($customer->additional_ID_cards) {
            $customer->additional_ID_cards_urls = array_map(function ($path) {
                return Storage::url($path);
            }, $customer->additional_ID_cards);
        } else {
            $customer->additional_ID_cards_urls = [];
        }

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:10',
            'ID_card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional for update
            'vehicle_number' => 'required|string|max:50',
            'additional_ID_cards.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for each additional ID card
        ]);

        try {
            // Handle the primary ID card image if a new image is provided
            if ($request->hasFile('ID_card_image')) {
                // Delete the old image if it exists
                if ($customer->ID_card_image) {
                    Storage::disk('public')->delete($customer->ID_card_image);
                }

                $idCardPath = $request->file('ID_card_image')->store('id_cards', 'public');
                $customer->ID_card_image = $idCardPath; // Update the image path
            }

            // Initialize an array to hold additional ID card paths
            $additionalIdCardPaths = $customer->additional_ID_cards ?? [];

            // Handle additional ID cards upload
            if ($request->hasFile('additional_ID_cards')) {
                foreach ($request->file('additional_ID_cards') as $file) {
                    $path = $file->store('additional_id_cards', 'public');
                    $additionalIdCardPaths[] = $path;
                }
            }

            // Update other fields
            $customer->name = $request->name;
            $customer->mobile_number = $request->mobile_number;
            $customer->vehicle_number = $request->vehicle_number;
            $customer->additional_ID_cards = $additionalIdCardPaths; // Update additional ID cards

            $customer->save();

            return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error updating customer: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating the customer.');
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            // Delete the primary ID card image
            if ($customer->ID_card_image) {
                Storage::disk('public')->delete($customer->ID_card_image);
            }

            // Delete additional ID card images
            if ($customer->additional_ID_cards) {
                foreach ($customer->additional_ID_cards as $path) {
                    Storage::disk('public')->delete($path);
                }
            }

            // Delete the customer record
            $customer->delete();

            return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error deleting customer: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while deleting the customer.');
        }
    }

    // Optional: Method to delete individual additional ID cards
    public function deleteAdditionalIDCard(Customer $customer, $index)
    {
        try {
            // Check if the index exists in the additional_ID_cards array
            if (isset($customer->additional_ID_cards[$index])) {
                // Get the file path to be deleted
                $path = $customer->additional_ID_cards[$index];
    
                // Delete the image file from storage
                Storage::disk('public')->delete($path);
    
                // Remove the file path from the additional_ID_cards array
                $additionalIdCards = $customer->additional_ID_cards;
                unset($additionalIdCards[$index]);
    
                // Reindex the array and save the updated list
                $customer->additional_ID_cards = array_values($additionalIdCards);
                $customer->save();
    
                return redirect()->back()->with('success', 'Additional ID card deleted successfully.');
            }
    
            return redirect()->back()->with('error', 'Invalid ID card.');
        } catch (\Exception $e) {
            \Log::error('Error deleting additional ID card: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'An error occurred while deleting the additional ID card.');
        }
    }
    
}
