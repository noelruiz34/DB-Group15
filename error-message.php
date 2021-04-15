<?php

session_start();

if (empty($_SESSION['messages'])) {
    return;
}

$messages = $_SESSION['messages'];
unset($_SESSION['messages']);
?>

<div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <ul style='list-style-type: none;padding: 0;margin: 0;'>
        <?php foreach ($messages as $message): ?>
            <li style='font-weight:500'><?php echo $message; ?></li>
        <?php endforeach; ?>
    </ul>
</div>