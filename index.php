<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>DripDrop | Streetwear Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

 <header>
    <div class="logo">
        DRIP<span class="inverted">DROP</span>
    </div>
    
    <div class="nav-links">
        <?php if(isset($_SESSION['username'])): ?>
            <span>Τι λέει, <strong><?php echo $_SESSION['username']; ?></strong>;</span>
            
            <a href="cart.php" class="cart-icon">
                🛍️ DROP 
                <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                    <span class="badge"><?php echo count($_SESSION['cart']); ?></span>
                <?php endif; ?>
            </a>

            <a href="logout.php" class="logout-link">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="signup.php">Register</a>
        <?php endif; ?>
    </div>
</header>

    <div class="container">
        <?php
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="product-card">';
                echo '<img src="images/' . $row['image'] . '" alt="' . $row['name'] . '">';
                echo '<div class="product-info">'; 
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>' . $row['price'] . '€</p>';
                echo '<a href="cart.php?action=add&id=' . $row['id'] . '" class="btn">ADD TO DROP</a>';
                echo '</div>'; 
                echo '</div>';
            }
        } else {
            echo "<h2>No drops available yet.</h2>";
        }
        ?>
    </div>

    <footer>
        <p>DRIPDROP &copy; 2026 // NO REFUNDS // ALL SALES FINAL</p>
    </footer>

</body>
</html>