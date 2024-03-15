
function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // Simulated user authentication - replace with actual authentication logic
    if (username === 'user' && password === 'password') {
        // Successful login
        var welcomeMessage = 'Welcome, User!';
        document.getElementById('popupMessage').innerText = welcomeMessage;
        document.getElementById('popup').style.display = 'block';
        // Redirect to home page after 2 seconds
        setTimeout(function() {
            window.location.href = 'home.html';
        }, 2000);
    } else {
        // Incorrect password, show popup message
        var errorMessage = 'Incorrect password. Please try again.';
        document.getElementById('popupMessage').innerText = errorMessage;
        document.getElementById('popup').style.display = 'block';
    }
});