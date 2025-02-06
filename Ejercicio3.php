<!DOCTYPE html>
<html>
<?php
// Inicializar inventario
session_start();
if (!isset($_SESSION['list'])) {
    $_SESSION['list'] = [];
}

$message = '';
$error = '';
$name = '';
$quantity = '';
$price = '';
$totalValue = 0; // Inicializar totalValue


// Manejar la solicitud de agregar o quitar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $quantity = (int)$_POST['quantity'];
        $price = (int)$_POST['price'];
    
        if ($name && $quantity > 0 && $price > 0) {
            $_SESSION['list'][] = ['name' => $name, 'quantity' => $quantity, 'price' => $price];
            $message = "Item added properly.";
        } else {
            $error = "Please enter valid values.";
        }
    }
    if (isset($_POST['delete'])) {
        $index = (int)$_POST['index'];
        if (isset($_SESSION['list'][$index])) {
            unset($_SESSION['list'][$index]); // Elimina el elemento del array
            $_SESSION['list'] = array_values($_SESSION['list']); // Reindexa el array
            $message = "Item deleted.";
        }
    }
    if (isset($_POST['edit'])) {
        $index = (int)$_POST['index'];
        if (isset($_SESSION['list'][$index])) {
            $name = $_SESSION['list'][$index]['name'];
            $quantity = $_SESSION['list'][$index]['quantity'];
            $price = $_SESSION['list'][$index]['price'];
        }
    }
    if (isset($_POST['update'])) {
        $index = (int)$_POST['index'];
        $name = $_POST['name'];
        $quantity = (int)$_POST['quantity'];
        $price = (int)$_POST['price'];
    
        if (isset($_SESSION['list'][$index]) && $name && $quantity > 0 && $price > 0) {
            $_SESSION['list'][$index] = ['name' => $name, 'quantity' => $quantity, 'price' => $price];
            $message = "Item updated.";
        } else {
            $error = "Invalid update.";
        } 
        if (isset($_POST['Reset'])) {
            $_SESSION['list'] = []; // Reset the list
            $message = "List reset.";
        }
    }
    if (isset($_POST['total'])) {
        foreach ($_SESSION['list'] as $item) {
            $totalValue += $item['quantity'] * $item['price'];
        }
    }
    
}
?>
<head>
    <title>Shopping list</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
        }

        input[type=submit] {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Shopping list</h1>
    <form method="post">
        <label for="name">name:</label>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>">
        <br>
        <label for="quantity">quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo $quantity; ?>">
        <br>
        <label for="price">price:</label>
        <input type="number" name="price" id="price" value="<?php echo $price; ?>">
        <br>
        <input type="hidden" name="index" value="<?php echo $index; ?>">
        <input type="submit" name="add" value="Add">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="reset" value="Reset">
    </form>
    <p style="color:red;"><?php echo $error; ?></p>
    <p style="color:green;"><?php echo $message; ?></p>
    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>quantity</th>
                <th>price</th>
                <th>cost</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['list'] as $index => $item) { ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['price']; ?></td>
                    <td><?php echo $item['quantity'] * $item['price']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="name" value="<?php echo $item['name']; ?>">
                            <input type="hidden" name="quantity" value="<?php echo $item['quantity']; ?>">
                            <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <input type="submit" name="edit" value="Edit">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td><?php echo $totalValue; ?></td>
                <td>
                    <form method="post">
                        <input type="submit" name="total" value="Calculate total">
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</body>