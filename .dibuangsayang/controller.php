// public function accept($id)
    // {
    //     // Fetch the booking and ensure it exists
    //     $booking = Booking::with('bookingDetail.ticket', 'event')->findOrFail($id);

    //     // Ensure the current user is the organizer of the event
    //     if (Auth::id() !== $booking->event->user_id && Auth::user()->role !== 'admin') {
    //         return redirect()->back()->withErrors(['message' => 'Unauthorized action']);
    //     }

    //     // Check if the booking is already active
    //     if ($booking->status === 'active') {
    //         return redirect()->back()->with('success', 'Booking is already active');
    //     }

    //     $totalrevenue = 0;
    //     // Update ticket stock and confirm booking
    //     foreach ($booking->bookingDetail as $detail) {
    //         $ticket = $detail->ticket;

    //         // Ensure there is enough stock for the ticket
    //         if ($ticket->quota < 1) {
    //             return redirect()->back()->withErrors(['message' => "Not enough stock for ticket: {$ticket->name}"]);
    //         }

    //         // Reduce ticket quota
    //         $ticket->quota -= 1;
    //         $ticket->save();

    //         // Record revenue
    //         $totalrevenue += $ticket->price;
    //     }

    //     // Update booking status
    //     $booking->update(['status' => 'active']);

    //     // Record revenue
    //     Revenue::create([
    //         'amount' => $totalrevenue,
    //         'booking_id' => $booking->id,
    //     ]);

    //     return redirect()->back()->with('success', 'Booking has been accepted and ticket stock has been updated.');
    // }


    // public function index()
    // {
    //     $user = Auth::user();

    //     // Ambil query dasar
    //     $bookingsQuery = Booking::with('bookingDetail.ticket', 'event')->latest();

    //     if ($user->role === 'customer') {
    //         // Jika user adalah customer, hanya ambil booking yang dia buat
    //         $bookings = $bookingsQuery->where('user_id', $user->id)->get();
    //         return view('customer.bookings', compact('bookings'));
    //     } elseif ($user->role === 'organizer') {
    //         // Jika user adalah organizer, ambil booking untuk event yang dia buat
    //         $bookings = $bookingsQuery->whereHas('event', function ($q) use ($user) {
    //             $q->where('user_id', $user->id);
    //         })->get();
    //         return view('organizer.manage-orders', compact('bookings'));
    //     } else {
    //         // Jika user adalah admin, ambil semua booking
    //         $bookings = $bookingsQuery->get();
    //         return view('admin.manage-orders', compact('bookings'));
    //     }
    // }    
