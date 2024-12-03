function updateRemoveButtonsVisibility() {
    const ticketItems = document.querySelectorAll('.ticket-item');
    const removeButtons = document.querySelectorAll('.remove-ticket');

    removeButtons.forEach(button => {
        // Jika hanya ada satu ticket-item, sembunyikan tombol
        if (ticketItems.length === 1) {
            button.classList.add('hidden');
        } else {
            button.classList.remove('hidden');
        }
    });
}

// Event untuk menambahkan tiket baru
document.getElementById('add-ticket').addEventListener('click', function () {
    const ticketItem = document.querySelector('.ticket-item').cloneNode(true);
    const ticketsContainer = document.getElementById('tickets-container');
    const index = ticketsContainer.children.length;

    // Update semua input di elemen baru
    ticketItem.querySelectorAll('input').forEach(input => {
        input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
        input.value = ''; // Reset value
    });

    ticketsContainer.appendChild(ticketItem);
    updateRemoveButtonsVisibility(); // Perbarui visibilitas tombol
});

// Event untuk menghapus tiket
document.getElementById('tickets-container').addEventListener('click', function (e) {
    if (e.target.closest('.remove-ticket')) {
        e.target.closest('.ticket-item').remove();
        updateRemoveButtonsVisibility(); // Perbarui visibilitas tombol
    }
});

const tickets = [];

document.getElementById('ticketForm').addEventListener('submit', async function(e) {    
    e.preventDefault(); // Prevent default form submission
    
    // Clear existing tickets array
    tickets.length = 0;
    
    // Collect ticket data from all ticket items
    document.querySelectorAll('.ticket-item').forEach((ticketItem, index) => {
        const ticket = {
            name: ticketItem.querySelector(`input[name="tickets[${index}][name]"]`).value,
            price: ticketItem.querySelector(`input[name="tickets[${index}][price]"]`).value,
            quota: ticketItem.querySelector(`input[name="tickets[${index}][quota]"]`).value,
            description: ticketItem.querySelector(`input[name="tickets[${index}][description]"]`).value
        };
        tickets.push(ticket);
    });

    try {
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ tickets: tickets })
        });
        
        if (response.ok) {
            console.log('Tickets submitted successfully:', tickets);
            window.location.href = '/dashboard'; // Redirect after successful submission
        } else {
            console.error('Submission failed');
        }
    } catch (error) {
        console.error('Error:', error);
    }
});

// Inisialisasi saat pertama kali load
updateRemoveButtonsVisibility();

console.log(tickets);