<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Category;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Routing\Route;

class EventController extends Controller
{
    public function index()
    {
        // Ambil semua event dengan tiket terkait menggunakan eager loading
        $events = Event::with('tickets')->get()->map(function ($event) {
            // Menambahkan tiket termurah ke setiap event
            $event->cheapest_ticket = $event->tickets->sortBy('price')->first();
            return $event;
        });

        // Return view dengan data event
        return view('explore-events', compact('events'));
    }

    public function home()
    {
        // Fetch Top Events (e.g., most favorited), including cheapest ticket
        $topEvents = Event::with(['tickets', 'favoritedBy'])
            ->withCount('favoritedBy') // Count the number of favorites
            ->orderBy('favorited_by_count', 'desc') // Sort by the number of favorites
            ->take(3) // Limit to top 5 events
            ->get()
            ->map(function ($event) {
                // Add the cheapest ticket to each event
                $event->cheapest_ticket = $event->tickets->sortBy('price')->first();
                return $event;
            });

        // Fetch Recently Added Events, including cheapest ticket
        $recentEvents = Event::with('tickets') // Eager load tickets
            ->orderBy('created_at', 'desc') // Sort by creation date
            ->take(6) // Limit to the 5 most recent events
            ->get()
            ->map(function ($event) {
                // Add the cheapest ticket to each event
                $event->cheapest_ticket = $event->tickets->sortBy('price')->first();
                return $event;
            });

        // Pass data to the view
        return view('home', compact('topEvents', 'recentEvents'));
    }

    public function manageEvents(Request $request)
    {
        $query = $request->get('query');
        $category = $request->get('category');
        $location = $request->get('location');
        $sortByPrice = $request->get('sort_by_price');
        $sortByDate = $request->get('sort_by_date');

        $categories = Category::all();

        $events = Event::with('tickets')
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', '%' . $query . '%');
            })
            ->when($category, function ($queryBuilder) use ($category) {
                $queryBuilder->where('category_id', $category);
            })
            ->when($sortByPrice, function ($queryBuilder) use ($sortByPrice) {
                if ($sortByPrice === 'price_asc') {
                    $queryBuilder->orderByRaw('(SELECT MIN(price) FROM tickets WHERE tickets.event_id = events.id) ASC');
                } elseif ($sortByPrice === 'price_desc') {
                    $queryBuilder->orderByRaw('(SELECT MAX(price) FROM tickets WHERE tickets.event_id = events.id) DESC');
                }
            })
            ->when($sortByDate, function ($queryBuilder) use ($sortByDate) {
                if ($sortByDate === 'date_asc') {
                    $queryBuilder->orderBy('date_time', 'asc');
                } elseif ($sortByDate === 'date_desc') {
                    $queryBuilder->orderBy('date_time', 'desc');
                }
            })
            ->when($location, function ($queryBuilder) use ($location) {
                $queryBuilder->where('location', 'like', '%' . $location . '%');
            })
            ->get()->map(function ($event) {
                // Menambahkan tiket termurah ke setiap event
                $event->cheapest_ticket = $event->tickets->sortBy('price')->first();
                return $event;
            });

        // Return view dengan data event
        return view('admin.manage-events', [
            'events' => $events,
            'query' => $query,
            'category' => $categories,
            'sortByPrice' => $sortByPrice,
            'sortByDate' => $sortByDate,
            'location' => $location
        ]);
    }

    public function myEvents(Request $request)
    {
        $user = Auth::user();

        // Ambil parameter filter dan sorting dari request
        $query = $request->get('query');
        $category = $request->get('category');
        $location = $request->get('location');
        $sortByPrice = $request->get('sort_by_price');
        $sortByDate = $request->get('sort_by_date');

        // Fetch all categories for the dropdown
        $categories = Category::all();

        // Ambil semua events milik pengguna
        $allEvents = Event::where('user_id', $user->id)
            ->with('tickets')
            ->get()
            ->map(function ($event) {
                $event->cheapest_ticket = $event->tickets->sortBy('price')->first();
                return $event;
            });

        // Filter dan sorting events milik pengguna
        $filteredEvents = $allEvents->filter(function ($event) use ($query, $category, $location) {
            $matchesQuery = $query ? stripos($event->title, $query) !== false : true;
            $matchesCategory = $category ? $event->category_id == $category : true;
            $matchesLocation = $location ? stripos($event->location, $location) !== false : true;
            return $matchesQuery && $matchesCategory && $matchesLocation;
        });

        // Apply sorting if needed
        if ($sortByPrice) {
            if ($sortByPrice === 'price_asc') {
                $filteredEvents = $filteredEvents->sortBy(function ($event) {
                    return $event->tickets->min('price');
                });
            } elseif ($sortByPrice === 'price_desc') {
                $filteredEvents = $filteredEvents->sortByDesc(function ($event) {
                    return $event->tickets->max('price');
                });
            }
        }

        if ($sortByDate) {
            if ($sortByDate === 'date_asc') {
                $filteredEvents = $filteredEvents->sortBy('date_time');
            } elseif ($sortByDate === 'date_desc') {
                $filteredEvents = $filteredEvents->sortByDesc('date_time');
            }
        }

        // Kirimkan data ke view
        return view('organizer.my-events', [
            'events' => $filteredEvents,
            'allEvents' => $allEvents,
            'query' => $query,
            'category' => $categories,
            'sortByPrice' => $sortByPrice,
            'sortByDate' => $sortByDate,
            'location' => $location,
        ]);
    }

    public function myFavorites()
    {
        $user = User::findOrFail(Auth::id());
        $events = $user->favorites()->with('tickets')->get()->map(function ($event) {
            // Menambahkan tiket termurah ke setiap event
            $event->cheapest_ticket = $event->tickets->sortBy('price')->first();
            return $event;
        });
        // $events = $user->favorites;
        return view('customer.favorites', compact('events'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        // pke model user krn mau dipanggil method favorites()
        $user = User::findOrFail(Auth::id());
        $eventId = $request->event_id;

        // Check if the event is already favorited
        if ($user->favorites()->where('event_id', $eventId)->exists()) {
            // If it is, remove it from favorites
            $user->favorites()->detach($eventId);
            return response()->json(['status' => 'removed']);
        } else {
            // If it is not, add it to favorites
            $user->favorites()->attach($eventId);
            return response()->json(['status' => 'added']);
        }
    }

    // View untuk membuat event
    public function create()
    {
        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Log::debug('Starting event store process');
        
        Log::debug('Validating request data', ['request' => $request->all()]);
        $validated = $request->validate([
            'name' => 'required|string|max:70',
            'description' => 'required|string',
            'date' => 'required|date_format:d/m/Y',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string',
            'organizer_name' => 'required|string|max:70',
            'category' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'tickets' => 'required|array',
            'tickets.*.name' => 'required|string|max:70',
            'tickets.*.description' => 'required|string|max:100',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quota' => 'required|numeric|min:0',
        ]);
        Log::debug('Request validation successful', ['validated' => $validated]);

        Log::debug('Converting date and time to datetime format');
        $datetime = Carbon::createFromFormat('d/m/Y H:i', $validated['date'] . ' ' . $validated['time'])
            ->format('Y-m-d H:i:s');
        Log::debug('Datetime converted', ['datetime' => $datetime]);

        Log::debug('Storing event image');
        $imagePath = $request->file('image')->store('images/events', 'public');
        Log::debug('Image stored successfully', ['path' => $imagePath]);

        Log::debug('Creating event record');
        $event = Event::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'date_time' => $datetime,

            'organizer_name' => $validated['organizer_name'],
            'location' => $validated['location'],
            'image_path' => $imagePath,
            'category_id' => $validated['category'],
            'user_id' => Auth::user()->id
        ]);
        Log::debug('Event created successfully', ['event' => $event]);

        Log::debug('Creating ticket records');
        foreach ($request->tickets as $ticket) {
            Log::debug('Creating ticket', ['ticket_data' => $ticket]);
            $event->tickets()->create([
                'name' => $ticket['name'],
                'price' => $ticket['price'],
                'quota' => $ticket['quota'],
                'description' => $ticket['description'] ?? null,
            ]);
        }
        Log::debug('All tickets created successfully');

        Log::debug('Determining redirect route based on user role');
        if (Auth::user()->role === 'admin') {
            Log::debug('Redirecting to manage-events (admin)');
            return redirect()->route('manage-events')->with('success', 'Event berhasil diperbarui!');
        } else if (Auth::user()->role === 'organizer') {
            Log::debug('Redirecting to my-events (organizer)');
            return redirect()->route('my-events')->with('success', 'Event berhasil diperbarui!');
        }
    }


    public function show(string $id)
    {
        // $event = Event::findOrFail($id);
        $event = Event::with('category')->findOrFail($id);
        // Explicitly use the User model to fetch the authenticated user
        $user = Auth::check() ? User::find(Auth::id()) : null;

        // Determine if the event is favorited
        $isFavorited = $user ? $user->favorites()->where('event_id', $id)->exists() : false;

        return view('events.show', compact('event', 'isFavorited'));
    }

    public function edit(string $id)
    {
        $event = Event::with('tickets')->findOrFail($id);

        // organizer hanya bisa mengedit event yang dibuatnya sendiri
        if (Auth::id() !== $event->user_id && Auth::user()->role === 'organizer') {
            abort(403, 'Unauthorized action.');
        }

        $category = Category::all(); // Ambil semua kategori untuk dropdown
        return view('events.edit', compact('event', 'category'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Ambil event berdasarkan nama, organizer, atau lokasi
        $events = Event::with(['tickets' => function ($q) {
            $q->orderBy('price', 'asc'); // Tiket termurah
        }])
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('organizer_name', 'LIKE', "%{$query}%")
            ->orWhere('location', 'LIKE', "%{$query}%")
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%"); // Mencari berdasarkan nama kategori
            })
            ->orWhere(DB::raw('MONTHNAME(date_time)'), 'LIKE', "%{$query}%")
            ->orWhere(DB::raw('DAYNAME(date_time)'), 'LIKE', "%{$query}%")
            ->get();

        // Mapping untuk menambahkan tiket termurah ke setiap event
        $events->map(function ($event) {
            $event->cheapest_ticket = $event->tickets->first();
            return $event;
        });

        return view('search-results', compact('events', 'query'));
    }


    public function sorting(Request $request)
    {
        $query = $request->get('query');
        $category = $request->get('category');
        $location = $request->get('location');
        $sortByPrice = $request->get('sort_by_price');
        $sortByDate = $request->get('sort_by_date');

        // Fetch all categories for the dropdown
        $categories = Category::all();

        $events = Event::with('tickets')
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', '%' . $query . '%');
            })
            ->when($category, function ($queryBuilder) use ($category) {
                $queryBuilder->where('category_id', $category);
            })
            ->when($location, function ($queryBuilder) use ($location) {
                $queryBuilder->where('location', 'like', '%' . $location . '%');
            })
            ->when($sortByPrice, function ($queryBuilder) use ($sortByPrice) {
                // Sorting berdasarkan harga
                if ($sortByPrice === 'price_asc') {
                    $queryBuilder->orderByRaw('(SELECT MIN(price) FROM tickets WHERE tickets.event_id = events.id) ASC');
                } elseif ($sortByPrice === 'price_desc') {
                    $queryBuilder->orderByRaw('(SELECT MAX(price) FROM tickets WHERE tickets.event_id = events.id) DESC');
                }
            })
            ->when($sortByDate, function ($queryBuilder) use ($sortByDate) {
                // Sorting berdasarkan tanggal
                if ($sortByDate === 'date_asc') {
                    $queryBuilder->orderBy('date_time', 'asc');
                } elseif ($sortByDate === 'date_desc') {
                    $queryBuilder->orderBy('date_time', 'desc');
                }
            })
            ->get()
            ->map(function ($event) {
                // Menambahkan tiket termurah pada setiap event
                $event->cheapest_ticket = $event->tickets->sortBy('price')->first();
                return $event;
            });

        // Kirimkan data ke view
        return view('explore-events', [
            'events' => $events,
            'query' => $query,
            'category' => $categories,
            'location' => $location,
            'sortByPrice' => $sortByPrice,
            'sortByDate' => $sortByDate
        ]);
    }


    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        if (Auth::id() !== $event->user_id && Auth::user()->role === 'organizer') {
            abort(403, 'Unauthorized action');
        }

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:70',
            'description' => 'required|string',
            'date' => 'required|date_format:d/m/Y',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'category_id' => 'required|exists:categories,id', // Validasi kategori
            'tickets.*.name' => 'nullable|string|max:50',
            'tickets.*.price' => 'nullable|numeric|min:0',
            'tickets.*.quota' => 'nullable|integer|min:0',
            'tickets.*.description' => 'nullable|string|max:255',
        ]);

        try {
            $datetime = Carbon::createFromFormat('d/m/Y H:i', $validated['date'] . ' ' . $validated['time'])
                ->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['date' => 'Format tanggal atau waktu tidak valid.'])->withInput();
        }

        // Update gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('images/events', 'public');
            $event->image_path = $imagePath;
        }

        // Update data event
        $event->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'date_time' => $datetime,
            'location' => $validated['location'],
            'category_id' => $validated['category_id'],
        ]);

        // Kelola tiket
        if ($request->has('tickets')) {
            $event->tickets()->delete(); // Hapus semua tiket lama untuk event ini

            foreach ($validated['tickets'] as $ticket) {
                if ($ticket['name'] && $ticket['price'] !== null && $ticket['quota'] !== null) {
                    $event->tickets()->create([
                        'name' => $ticket['name'],
                        'price' => $ticket['price'],
                        'quota' => $ticket['quota'],
                        'description' => $ticket['description'] ?? null,
                    ]);
                }
            }
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('manage-events')->with('success', 'Event berhasil diperbarui!');
        } else if (Auth::user()->role === 'organizer') {
            return redirect()->route('my-events')->with('success', 'Event berhasil diperbarui!');
        }
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        if (Auth::id() !== $event->user_id && Auth::user()->role === 'organizer') {
            abort(403, 'Unauthorized action');
        }

        // Hapus gambar jika ada
        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }

        $event->delete();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('manage-events')->with('success', 'Event berhasil diperbarui!');
        } else if (Auth::user()->role === 'organizer') {
            return redirect()->route('my-events')->with('success', 'Event berhasil diperbarui!');
        }
    }
}
