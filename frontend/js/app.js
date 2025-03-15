document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    
    // Basic validation
    if (username.trim() === '' || password.trim() === '') {
        alert('Please enter both username and password');
        return;
    }
    
    // Here you would typically send the data to your server
    console.log('Login attempt:', { username, password });
    alert('Login successful!');
    
    // Reset form
    this.reset();
});