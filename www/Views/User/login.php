<?php
if (isset($_SESSION['login']['error'])) {
    echo '<p style="color:red;">' . $_SESSION['login']['error'] . '</p>';
    unset($_SESSION['login']['error']);
}

if (isset($_SESSION['login']['success'])) {
    echo '<p style="color:green;">' . $_SESSION['login']['success'] . '</p>';
    unset($_SESSION['login']['success']);
}
?>
    <form method="POST" action="/user/loginbd">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login_btn">Register</button>
    </form>