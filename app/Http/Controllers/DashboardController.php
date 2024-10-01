<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch total number of customers
        $totalCustomers = Customer::count();

         // Get the authenticated user
         $user = Auth::user();

         // Determine the greeting based on the time of day
         $hour = now()->hour;
         if ($hour < 12) {
             $greeting = 'Good Morning';
         } elseif ($hour < 18) {
             $greeting = 'Good Afternoon';
         } else {
             $greeting = 'Good Evening';
         }

        // Pass data to the view
        return view('dashboard', compact('totalCustomers', 'user', 'greeting'));
    }
}
