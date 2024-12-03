function updateQuantity(inputId, delta) {
    const inputElement = document.getElementById(inputId);
    let currentValue = parseInt(inputElement.value) || 0;
    currentValue += delta;

    const maxQuota = parseInt(inputElement.getAttribute('max')); // Maximum allowed per ticket
    const totalTickets = getTotalSelectedTickets();

    // Ensure the total tickets do not exceed the allowed limit (5)
    if (totalTickets + delta > 5) {
        alert('You cannot select more than 5 tickets per transaction.');
        return;
    }

    // Ensure individual ticket quantity does not exceed the quota
    if (currentValue > maxQuota) {
        alert(`The selected quantity cannot exceed the quota of ${maxQuota} tickets.`);
        return;
    }

    if (currentValue < 0) currentValue = 0; // Prevent negative quantities
    inputElement.value = currentValue;
    updateSummary(); // Update the summary
}

function getTotalSelectedTickets() {
    let total = 0;
    document.querySelectorAll("input[name^='tickets']").forEach(input => {
        total += parseInt(input.value) || 0;
    });
    return total;
}

function updateSummary() {
    let totalPrice = 0;
    let summaryHTML = '';
    let totalTickets = 0;

    document.querySelectorAll("input[name^='tickets']").forEach(input => {
        const ticketId = input.name.match(/\d+/)[0];
        const ticketQuantity = parseInt(input.value) || 0;

        if (ticketQuantity > 0) {
            const ticketPrice = parseInt(input.dataset.price);
            const ticketName = input.dataset.name;
            const ticketDescription = input.dataset.description;

            const subtotal = ticketQuantity * ticketPrice;
            totalPrice += subtotal;
            totalTickets += ticketQuantity;

            summaryHTML += `
                    <div class="bg-white rounded-lg mb-4 shadow-md">
                        <div class="rounded-xl">
                            <!-- Ticket Name -->
                                <div class="flex items-center justify-between px-4 py-3 bg-gray-200 rounded-t-xl gap-x-10">
                                    <div>
                                        <h4 class="text-2xl font-bold text-blue-1"><i class="fas fa-ticket mr-2"></i> ${ticketName}</h4>
                                        <p class="text-grey-700">${ticketDescription}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-2xl font-bold text-blue-1">${ticketQuantity}x</h4>
                                    </div>
                                </div>
                                    
                                <div class="items-center px-4 py-4 mt-3">
                                    <h4 class="text-2xl font-bold text-blue-1"> Rp${subtotal.toLocaleString('id-ID')}</h4>
                                </div>
                        </div>
                    </div>
                `;
        }
    });

    // Update the summary section
    document.getElementById('summary-list').innerHTML = summaryHTML ||
        '<p class="text-grey-700">No tickets selected yet.</p>';
    document.getElementById('total-price').innerText = `Rp ${totalPrice.toLocaleString('id-ID')}`;
}

// Add an onchange event to validate the total tickets on manual input
document.querySelectorAll("input[name^='tickets']").forEach(input => {
    input.addEventListener('change', (event) => {
        const totalTickets = getTotalSelectedTickets();
        if (totalTickets > 5) {
            alert('You cannot select more than 5 tickets per transaction.');
            event.target.value = 0; // Reset the input if the total exceeds 5
            updateSummary(); // Update the summary
        }
    });
});

/* <div class="flex items-center justify-between bg-gray-200 p-4 bg-gray-100 rounded-lg shadow-xl">
<h4 class="text-lg font-medium text-blue-1">${ticketName}</h4>
<p class="text-grey-700">${ticketDescription}</p>
<p class="text-grey-700">Quantity: ${ticketQuantity}</p>
<p class="text-grey-700">Subtotal: Rp${subtotal.toLocaleString('id-ID')}</p>
</div> */