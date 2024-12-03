document.addEventListener('DOMContentLoaded', function () {
    // Select the favorite button
    const button = document.querySelector('[id^=favorite-btn-]');
    const icon = document.querySelector('[id^=favorite-icon-]');

    if (button) {
        button.addEventListener('click', function () {
            const eventId = this.dataset.eventId; // Get event_id from data attribute
            const url = this.dataset.url; // Get the URL from data attribute
            const csrfToken = this.dataset.csrf; // Get CSRF token from data attribute

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    event_id: eventId
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'added') {
                        // Update to liked state
                        icon.classList.remove('far', 'text-white'); // Remove outlined heart and gray color
                        icon.classList.add('fas', 'text-red-500'); // Add solid heart and red color
                    } else if (data.status === 'removed') {
                        // Update to unliked state
                        icon.classList.remove('fas', 'text-red-500'); // Remove solid heart and red color
                        icon.classList.add('far', 'text-white'); // Add outlined heart and gray color
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    }
});

// document.addEventListener('DOMContentLoaded', function () {
//     // Select the favorite button
//     const button = document.querySelector('[id^=favorite-btn-]');

//     if (button) {
//         button.addEventListener('click', function () {
//             const eventId = this.dataset.eventId; // Get event_id from data attribute
//             const url = this.dataset.url; // Get the URL from data attribute
//             const csrfToken = this.dataset.csrf; // Get CSRF token from data attribute

//             fetch(url, {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': csrfToken
//                 },
//                 body: JSON.stringify({
//                     event_id: eventId
//                 })
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.status === 'added') {
//                         // Change button if favorited
//                         button.textContent = 'Remove from Favorites';
//                         button.classList.remove('bg-red-500', 'hover:bg-red-600');
//                         button.classList.add('bg-green-500', 'hover:bg-green-600');
//                     } else if (data.status === 'removed') {
//                         // Change button if unfavorited
//                         button.textContent = 'Add to Favorites';
//                         button.classList.remove('bg-green-500', 'hover:bg-green-600');
//                         button.classList.add('bg-red-500', 'hover:bg-red-600');
//                     }
//                 })
//                 .catch(error => {
//                     console.error('Error:', error);
//                 });
//         });
//     }
// });

// qselectorAll
// document.addEventListener('DOMContentLoaded', function () {
//     // Select all favorite buttons
//     document.querySelectorAll('[id^=favorite-btn-]').forEach(function (button) {
//         button.addEventListener('click', function () {
//             const eventId = this.dataset.eventId; // Get event_id from data attribute
//             const url = this.dataset.url; // Get the URL from data attribute
//             const csrfToken = this.dataset.csrf; // Get CSRF token from data attribute

//             fetch(url, {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': csrfToken
//                 },
//                 body: JSON.stringify({
//                     event_id: eventId
//                 })
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.status === 'added') {
//                         // Change button if favorited
//                         button.textContent = 'Remove from Favorites';
//                         button.classList.remove('bg-red-500', 'hover:bg-red-600');
//                         button.classList.add('bg-green-500', 'hover:bg-green-600');
//                     } else if (data.status === 'removed') {
//                         // Change button if unfavorited
//                         button.textContent = 'Add to Favorites';
//                         button.classList.remove('bg-green-500', 'hover:bg-green-600');
//                         button.classList.add('bg-red-500', 'hover:bg-red-600');
//                     }
//                 })
//                 .catch(error => {
//                     console.error('Error:', error);
//                 });
//         });
//     });
// });
