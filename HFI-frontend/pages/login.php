<?php
$page_title = "Login";
include '../global/header.php';
?>


<div class="login">

    <p class="login-tagline">Log in. Make work happen.</p>

    <!-- Login Card -->
    <div class="login-card">

    <!-- Email -->
    <label class="field-label" for="email">Email Address</label>
    <input class="login-input" type="email" id="email" autocomplete="email"/>

    <!-- Password -->
    <label class="field-label" for="password">Password</label>
    <div class="password-wrap">
        <input class="login-input" type="password" id="password" autocomplete="current-password"/>
        <button class="toggle-pw" type="button" onclick="togglePassword()" aria-label="Toggle password visibility">
        <!-- Eye icon -->
        <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
            <!-- strike line (hidden by default) -->
            <line id="eyeStrike" x1="3" y1="3" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:none;"/>
        </svg>
        </button>
    </div>

    <!-- Login button -->
    <button class="btn-login" type="button">LOGIN</button>

    <!-- Forgot -->
    <a href="#" class="forgot-link">Forgot your password?</a>
    </div>

    <!-- Register box -->
    <div class="register-box">
    Not yet registered? <a href="#">Create a free account.</a>
    </div>

</div>

<?php
include '../global/footer.php';
?>