<form class="sign-up-form" name="signupForm" id="signupForm">
    <h2 class="title">Sign up</h2>
    <div class="input-field">
    <i class="fas fa-envelope"></i>
    <input type="email" placeholder="Email" name="register_email" required/>
    </div>
    <div class="input-field">
    <i class="fas fa-lock"></i>
    <input type="password" placeholder="Password" name="register_password" required/>
    </div>
    <!-- <div class="input-field">
    <i class="fas fa-user"></i>
    <input list="register_usertype" name="reg_usertype" placeholder="Type of user">
    <datalist id="register_usertype">
        <option value="Student">
        <option value="Faculty">
        <option value="Admin">
    </datalist>
    </div> -->
    <button type="submit" class="btn" name="signup_user">Sign Up</button>
</form>

<script>
$(document).ready(function() {
    $('#signupForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'register_user.php',
            type: 'POST',
            data: {
                signup_user: 'signup_user',
                register_email: this.register_email.value,
                register_password: this.register_password.value
            },
            dataType: 'json',  
            success: function(response) {
                console.log('response : ', response);
                alert(response.message);
                location.reload();
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
});
</script>