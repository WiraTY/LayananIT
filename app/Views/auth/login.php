<!-- app/Views/auth/login.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($error)): ?>
        <p><?= esc($error) ?></p>
    <?php endif; ?>

    <!-- Form login -->
    <form action="/processLogin" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?= old('username') ?>"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
