<?php

if (isset($_SESSION['flash']['error'])) {
    echo '<p style="color:red;">' . $_SESSION['flash']['error'] . '</p>';
    unset($_SESSION['flash']['error']);
}

if (isset($_SESSION['flash']['success'])) {
    echo '<p style="color:green;">' . $_SESSION['flash']['success'] . '</p>';
    unset($_SESSION['flash']['success']);
}
?>
    <form method="POST" action="/user/registerbd">
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <button type="submit" name="save_user_btn">Login</button>
    </form>
