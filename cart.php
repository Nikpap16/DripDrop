<?php
session_start();
include 'db.php';

// 1. Προσθήκη προϊόντος (ΑΥΤΟ ΕΛΕΙΠΕ!)
if (isset($_GET['action']) && $_GET['action'] == "add") {
    $id = $_GET['id'];
    
    // Αν δεν υπάρχει καλάθι, το δημιουργούμε
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    // Προσθέτουμε το ID του προϊόντος
    array_push($_SESSION['cart'], $id);
    
    // Επιστρέφουμε στο index για να δει ο χρήστης το badge να ανανεώνεται
    // Ή αν προτιμάς να μένει στο καλάθι, βάλε header("Location: cart.php");
    header("Location: index.php"); 
    exit();
}

// 2. Αφαίρεση μεμονωμένου προϊόντος
if (isset($_GET['action']) && $_GET['action'] == "remove") {
    $key = $_GET['key'];
    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header("Location: cart.php");
    exit();
}

// 3. Καθαρισμός όλου του καλαθιού
if (isset($_GET['action']) && $_GET['action'] == "clear") {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>DripDrop | Your Drop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>YOUR DROP 🛍️</h1>
        <div class="nav-links">
            <a href="index.php">← BACK TO SHOP</a>
        </div>
    </header>

    <div class="container">
        <div class="cart-list">
            <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $total = 0;
                foreach ($_SESSION['cart'] as $key => $product_id) {
                    $sql = "SELECT * FROM products WHERE id = $product_id";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    
                    if ($row) {
                        echo "<div class='cart-item'>";
                        echo "<span>" . $row['name'] . "</span>";
                        echo "<div>";
                        echo "<span>" . $row['price'] . "€</span>";
                        echo "<a href='cart.php?action=remove&key=$key' class='remove-link'>[X]</a>";
                        echo "</div>";
                        echo "</div>";
                        $total += $row['price'];
                    }
                }
                echo "<div class='cart-total'>TOTAL: " . $total . "€</div>";
                echo "<a href='checkout.php' class='btn'>PROCEED TO CHECKOUT</a>";
                echo "<a href='cart.php?action=clear' class='clear-all'>CLEAR ALL ITEMS</a>";
            } else {
                echo "<h2 style='text-align:center;'>YOUR DROP IS EMPTY</h2>";
                echo "<a href='index.php' class='btn'>GO GET SOME DRIP</a>";
            }
            ?>
        </div>
    </div>

    <footer>
        <p>DRIPDROP &copy; 2026 // NO REFUNDS // ALL SALES FINAL</p>
    </footer>

</body>
</html>