// Tab functionality
function openTab(evt, tabName) {
    const tabContents = document.getElementsByClassName("tabcontent");
    for (let content of tabContents) {
        content.style.display = "none";
    }
    document.getElementById(tabName).style.display = "block";
}

// AJAX to search contacts
document.getElementById('search-contacts').addEventListener('input', function(e) {
    fetch(`/search_contacts.php?q=${e.target.value}`)
        .then(response => response.json())
        .then(contacts => {
            const results = document.getElementById('contact-results');
            results.innerHTML = contacts.map(contact => `
                <div>
                    ${contact.surname}, ${contact.name} (${contact.email})
                    <button onclick="linkContact(${contact.id})">Link</button>
                </div>
            `).join('');
        });
});

// Link contact to client
function linkContact(contactId) {
    const clientId = new URLSearchParams(window.location.search).get('client_id');
    fetch(`link_contact.php?client_id=${clientId}&contact_id=${contactId}`, { method: 'POST' })
        .then(response => location.reload()); // Refresh to show changes
}

// Form validation
document.querySelector("form").addEventListener("submit", function(e) {
    const nameInput = document.querySelector("input[name='name']");
    if (nameInput.value.trim() === "") {
        e.preventDefault();
        alert("Name is required!");
        nameInput.focus();
    }
});

// AJAX Contact Search
document.getElementById('search-contacts').addEventListener('input', function(e) {
    const query = e.target.value;
    if (query.length < 2) return;

    fetch(`search_contacts.php?q=${query}`)
        .then(response => response.json())
        .then(contacts => {
            const results = document.getElementById('contact-results');
            results.innerHTML = contacts.map(contact => `
                <div class="search-result">
                    ${contact.surname}, ${contact.name} (${contact.email})
                    <button onclick="linkContact(${contact.id})">Link</button>
                </div>
            `).join('');
        });
});

// Link Contact
function linkContact(contactId) {
    const clientId = new URLSearchParams(window.location.search).get('client_id');
    fetch(`link_contact.php?client_id=${clientId}&contact_id=${contactId}`)
        .then(() => window.location.reload()); // Refresh to show changes
}

// Client search (for contacts/link_clients.php)
document.getElementById('search-clients')?.addEventListener('input', function(e) {
    fetch(`search_clients.php?q=${e.target.value}`)
        .then(response => response.json())
        .then(clients => {
            const results = document.getElementById('client-results');
            results.innerHTML = clients.map(client => `
                <div class="search-result">
                    ${client.name} (${client.client_code})
                    <button onclick="linkClient(${client.id})">Link</button>
                </div>
            `).join('');
        });
});

// Link client to contact
function linkClient(clientId) {
    const contactId = new URLSearchParams(window.location.search).get('contact_id');
    fetch(`link_client.php?contact_id=${contactId}&client_id=${clientId}`)
        .then(() => window.location.reload());
}