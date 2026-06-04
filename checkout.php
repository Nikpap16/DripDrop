<?php
session_start();
include 'db.php';

// Αν ο χρήστης δεν είναι συνδεδεμένος, τον στέλνουμε στο login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Αν το καλάθι  είναι άδειο, επιστροφή στην αρχική
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

// Υπολογισμός τελικού ποσού
$total = 0;
foreach ($_SESSION['cart'] as $product_id) {
    $sql = "SELECT price FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $total += $row['price'];
    }
}

// Όταν πατήσει το κουμπί για ολοκλήρωση
if (isset($_POST['place_order'])) {
    // Εδώ κανονικά γινεται αποθήκευση στην βάση στον πίνακα "orders"
    unset($_SESSION['cart']);
    $success = true;
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>DripDrop | Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="checkout-card">
        <?php if (isset($success)): ?>
            <h1 class="success-msg">ORDER SECURED 📦</h1>
            <p>Το drop σου ετοιμάζεται. Θα λάβεις σύντομα mail με όλες τις σχετικές πληροφορίες.</p>
            <br>
            <a href="index.php">ΕΠΙΣΤΡΟΦΗ ΣΤΗΝ ΑΡΧΙΚΗ</a>
        <?php else: ?>
            <h1 style="letter-spacing: 4px;">CHECKOUT</h1>
            <hr style="border: 0.5px solid #333;">
            <p style="margin: 20px 0;">ΣΥΝΟΛΙΚΟ ΠΟΣΟ:</p>
            <h2 style="font-size: 3rem; margin: 10px 0;"><?php echo $total; ?>€</h2>
            
            <form method="POST">
                <button type="submit" name="place_order" class="btn-order">CONFIRM DROP</button>
            </form>
            <br>
            <a href="cart.php">ΑΚΥΡΩΣΗ</a>
        <?php endif; ?>
    </div>

</body>
</html>