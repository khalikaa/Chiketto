<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Booking;
use App\Models\Revenue;
use App\Models\Event;
use App\Models\Ticket;

class HomeController extends Controller
{
    public function index()
    {
        // cek autentikasi
        if (Auth::check()) {
            $user = Auth::user();

            // Dashboard untuk Admin
            if ($user->role == 'admin') {
                // Total revenue untuk admin: semua transaksi di tabel revenue
                $totalRevenue = Revenue::sum('amount'); 

                // Total event: semua event yang ada di sistem
                $totalEvents = Event::count();

                // Total ticket terjual: dihitung dari total tiket yang terjual di seluruh event
                $totalTicketsSold = Ticket::whereHas('bookingDetail')->count();

                $totalUsers = User::count();

                $totalCust = User::where('role', 'customer')->count();

                $totalOrg = User::where('role', 'organizer')->count();
                
                return view('admin.dashboard', compact('totalRevenue', 'totalEvents', 'totalTicketsSold', 'totalCust', 'totalOrg', 'totalUsers'));
            } 
            // Dashboard untuk Organizer
            else if ($user->role == 'organizer') {
                // Total revenue untuk organizer: berdasarkan event yang dibuat oleh organizer
                $totalRevenue = Revenue::whereHas('booking.event', function ($query) use ($user) {
                    $query->where('user_id', $user->id); // Mengambil event yang dibuat oleh organizer
                })->sum('amount');

                // Total event: berdasarkan event yang dibuat oleh organizer
                $totalEvents = Event::where('user_id', $user->id)->count();

                // Total ticket terjual: dihitung berdasarkan event yang dibuat oleh organizer
                $totalTicketsSold = Ticket::whereHas('event', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->whereHas('bookingDetail')->count();

                return view('organizer.dashboard', compact('totalRevenue', 'totalEvents', 'totalTicketsSold'));
            } 
            // Dashboard untuk Customer (seperti sebelumnya)
            else {
                // Data customer tetap sama
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
        } else {
            return redirect('/home');
        }
    }
}