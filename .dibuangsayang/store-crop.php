gk adapi phpnya tp klo dikasi erorki

public function store(Request $request)
{
    try {
        // Log incoming request data
        Log::info('Creating new event', ['request' => $request->all()]);
        
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:70',
            'description' => 'required|string',
            'date' => 'required|date_format:d/m/Y',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string',
            'organizer_name' => 'required|string|max:70',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'tickets' => 'required|array|min:1',
            'tickets.*.name' => 'required|string|max:70',
            'tickets.*.description' => 'required|string|max:100',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quota' => 'required|integer|min:1',
        ]);

        // Log validated data
        Log::info('Validation passed', ['validated' => $validated]);

        try {
            $datetime = Carbon::createFromFormat('d/m/Y H:i', $validated['date'] . ' ' . $validated['time'])
                ->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            Log::error('DateTime parsing failed', [
                'date' => $validated['date'],
                'time' => $validated['time'],
                'error' => $e->getMessage()
            ]);
            throw $e;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                $imagePath = $request->file('image')->store('images/events', 'public');
                Log::info('Image uploaded successfully', ['path' => $imagePath]);
            } catch (\Exception $e) {
                Log::error('Image upload failed', ['error' => $e->getMessage()]);
                throw $e;
            }
        } else {
            Log::error('No image file uploaded');
            throw new \Exception('No image file uploaded.');
        }

        // Create event using DB transaction
        DB::beginTransaction();
        try {
            // Create event
            $event = Event::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'date_time' => $datetime,
                'organizer_name' => $validated['organizer_name'],
                'location' => $validated['location'],
                'image_path' => $imagePath,
                'category_id' => $validated['category_id'],
                'user_id' => Auth::id()
            ]);

            Log::info('Event created', ['event_id' => $event->id]);

            // Create tickets
            foreach ($request->tickets as $ticket) {
                $event->tickets()->create([
                    'name' => $ticket['name'],
                    'price' => $ticket['price'],
                    'quota' => $ticket['quota'],
                    'description' => $ticket['description'],
                ]);
            }

            Log::info('Tickets created for event', ['event_id' => $event->id]);

            DB::commit();
            return redirect()->route('events.index')
                ->with('success', 'Event created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create event', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Log::info('Deleted uploaded image after failure', ['path' => $imagePath]);
            }
            throw $e;
        }

    } catch (\Exception $e) {
        Log::error('Event creation failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Failed to create event. ' . $e->getMessage()]);
    }
}