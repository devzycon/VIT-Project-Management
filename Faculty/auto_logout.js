// Auto Logout after 20 minutes of inactivity
var timeout;
var inactiveTime = 20 * 60 * 1000; // 20 minutes in milliseconds

function setupTimeout() {
    timeout = setTimeout(logout, inactiveTime);
}

function resetTimeout() {
    clearTimeout(timeout);
    setupTimeout();
}

function logout() {
    // Redirect to logout.php when the user is inactive
    window.location.href = 'logout.php';
}

// Set up initial timeout
setupTimeout();

// Logout when the tab is closed or browser is exited
window.addEventListener('unload', function() {
    // Perform an asynchronous AJAX request to logout.php
    $.ajax({
        url: 'logout.php',
        type: 'POST',
        async: true,
        success: function(data) {
            // Session is destroyed, and the user is logged out
        }
    });
});

// Set up event listeners to reset timeout on user activity
document.addEventListener('mousemove', resetTimeout);
document.addEventListener('keypress', resetTimeout);
