<?php
// Inicializar inventario
session_start();
if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = ['milk' => 0, 'soft_drink' => 0];
}

$worker_name = isset($_POST['worker_name']) ? $_POST['worker_name'] : '';
$message = '';

// Manejar la solicitud de agregar o quitar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = $_POST['product'];
    $quantity = (int)$_POST['quantity'];

    if (isset($_POST['add'])) {
        $_SESSION['inventory'][$product] += $quantity;
        $message = "Added $quantity units of $product.";
    } elseif (isset($_POST['remove'])) {
        if ($_SESSION['inventory'][$product] >= $quantity) {
            $_SESSION['inventory'][$product] -= $quantity;
            $message = "Removed $quantity units of $product.";
        } else {
            $message = "Error: Not enough $product to remove.";
        }
    } elseif (isset($_POST['reset'])) {
        $_SESSION['inventory'] = ['milk' => 3, 'soft_drink' => 0];
        $message = "Inventory reset.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermarket Management</title>
</head>
<body>
    <h1>Supermarket management</h1>
    <form method="post">
        <label for="worker_name">Worker name:</label>
        <input type="text" name="worker_name" id="worker_name" value="<?php echo htmlspecialchars($worker_name); ?>" required>
        <br><br>
        
        <label for="product">Choose product:</label>
        <select name="product" id="product">
            <option value="milk">Milk</option>
            <option value="soft_drink">Soft Drink</option>
        </select>
        <br><br>

        <label for="quantity">Product quantity:</label>
        <input type="number" name="quantity" id="quantity" min="1" required>
        <br><br>
        <!-- Botones Logica --> 
        <button type="submit" name="add">Add</button>
        <button type="submit" name="remove">Remove</button>
        <button type="submit" name="reset">Reset</button>
    </form>
    
    <h2>Inventory:</h2>
    <p>Worker: <?php echo htmlspecialchars($worker_name); ?></p>
    <ul>
        <li>Units milk: <?php echo $_SESSION['inventory']['milk']; ?></li>
        <li>Units soft drink: <?php echo $_SESSION['inventory']['soft_drink']; ?></li>
    </ul>
    <?php if ($message): ?>
        <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
    <?php endif; ?>
</body>
</html>
