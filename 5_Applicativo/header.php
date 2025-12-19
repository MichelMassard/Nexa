<style>
    .main-header {
        background: #ffffff;
        border-bottom: 2px solid #e1e1e1;
        padding: 10px 20px;
        display: flex;
        align-items: center;
    }

    .main-header img {
        height: 50px;
        margin-right: 15px;
    }

    .logout-link {
        margin-left: auto;
        font-weight: bold;
        color: #dc3545;
        text-decoration: none;
    }
    .logout-link:hover {
        color: #a71d2a;
    }
</style>


<div class="main-header">
    <a href="landing.php"><img src="images/Logo-Nexa.png" alt="Logo"></a>
    <?php if (isset($_SESSION['userId'])): ?>
        <a href="logout.php" class="logout-link">Logout</a>
    <?php endif; ?>
</div>
