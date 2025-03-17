<?php if (isset($_SESSION['error'])): ?>
    <script>
        alert("🚨 Error: <?php echo $_SESSION['error']; ?>");
    </script>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>