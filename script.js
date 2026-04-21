// Handle login form submission
document.getElementById('loginForm').addEventListener('submit', function(event) {
  event.preventDefault();
  alert('Login Successful!');
});

// Handle booking form submission
document.getElementById('bookingForm').addEventListener('submit', function(event) {
  event.preventDefault();
  alert('Booking Successful! We will send a confirmation shortly.');
});

<script>
  function showUserLogin() {
    document.getElementById("userLoginForm").style.display = "block";
  }

  function redirectToProviderLogin() {
    window.location.href = "provider-login.html"; // Service provider ka page
  }


</script>
