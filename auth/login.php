<form class="sign-in-form" name="loginForm" id="loginForm">
    <h2 class="title">Log In</h2>
    <div class="input-field">
    <i class="fas fa-user"></i>
    <input type="email" placeholder="Email-id" name="user_email" required/>
    </div>
    <div class="input-field">
    <i class="fas fa-lock"></i>
    <input type="password" placeholder="Password" name="user_password" required/>
    </div>
    <!-- <div class="input-field">
    <i class="fas fa-user"></i>
    <input list="type_of_user" id="typeofuser" name="usertype" placeholder="Type of User" required/>
    <datalist id="type_of_user">
        <option value="Admin">
        <option value="Faculty">
        <option value="Student">
    </datalist>
    </div> -->
    <button type="submit" class="btn solid" name="login-user">Login</button>
</form>

<script>
$(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'login_check.php',
            type: 'POST',
            data: {
                login_user: 'login-user',
                user_email: this.user_email.value,
                user_password: this.user_password.value
            },
            dataType: 'json',  
            success: function(response) {
                console.log('response : ', response);
                alert(response.message);
                if(response.status == 'success') {
                    window.location.href = response.redirect;
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
});
</script>