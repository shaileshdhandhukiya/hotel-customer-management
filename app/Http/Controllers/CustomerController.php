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
        return view('customers.show', compact('customer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:10',
            'ID_card_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicle_number' => 'required|string|max:50',
        ]);

        try {
            // Handle the image upload
            $path = $request->file('ID_card_image')->store('id_cards', 'public');

            Customer::create([
                'name' => $request->name,
                'mobile_number' => $request->mobile_number,
                'ID_card_image' => $path,
                'vehicle_number' => $request->vehicle_number,
            ]);

            return redirect()->route('customers.index')->with('success', 'Customer created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the customer.');
        }
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:10',
            'ID_card_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Optional for update
            'vehicle_number' => 'required|string|max:50',
        ]);

        try {
            // Handle the image upload if a new image is provided
            if ($request->hasFile('ID_card_image')) {
                // Delete the old image if it exists
                if ($customer->ID_card_image) {
                    Storage::disk('public')->delete($customer->ID_card_image);
                }

                $path = $request->file('ID_card_image')->store('id_cards', 'public');
                $customer->ID_card_image = $path; // Update the image path
            }

            $customer->update($request->only(['name', 'mobile_number', 'vehicle_number'])); // Update other fields
            $customer->save();

            return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the customer.');
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            // Delete the associated image before deleting the customer
            if ($customer->ID_card_image) {
                Storage::disk('public')->delete($customer->ID_card_image);
            }

            $customer->delete();

            return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the customer.');
        }
    }
}
