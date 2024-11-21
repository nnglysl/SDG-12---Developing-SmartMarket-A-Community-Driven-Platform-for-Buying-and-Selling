
function editField(field) {
    const displayDiv = document.getElementById(field + 'Display'); // the non-editable field
    const inputField = document.getElementById(field); // the editable input field
    
    displayDiv.classList.add('hidden'); // Hide the non-editable text
    inputField.classList.remove('hidden'); // Show the input field for editing
    inputField.focus(); // Focus on the input field
}

function saveField(field) {
    const inputField = document.getElementById(field);
    const displayDiv = document.getElementById(field + 'Display');
    
    // Update the display div with the new value
    displayDiv.innerText = inputField.value;
    displayDiv.classList.remove('hidden');
    inputField.classList.add('hidden');
}

function saveChanges() {
    // Here you can add code to save changes to the server
    alert('Changes saved!');
}
function showMessage() {
    const messageDiv = document.getElementById('statusMessage');
    if (messageDiv) {
        messageDiv.style.display = 'block'; // Show the message
    }
}
