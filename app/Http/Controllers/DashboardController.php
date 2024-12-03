<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Revenue;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Pada controller CustomerDashboardController
    public function customer()
    {
        $user = User::findOrFail(Auth::id());
    
        // Total bookings
        $totalBookings = Booking::where('user_id', $user->id)->count();

        // Total spent (revenue table)
        $totalSpent = Revenue::whereHas('booking', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('amount'); // Asumsi 'amount' adalah kolom yang menyimpan total uang yang dibayar

        // Total favorites (pivot table)
        $totalFavorites = $user->favorites()->count();

        return view('customer.dashboard', compact('totalBookings', 'totalSpent', 'totalFavorites'));
    }
}
