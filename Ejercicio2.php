<?php

session_start();
if (!isset($_SESSION['array'])) {
    $_SESSION['array'] = [10,20,30];
}

$message = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $position = $_POST['position'];
    $value = (int)$_POST['value'];
    if (isset($_POST['modify'])) {
        $_SESSION['array'][$position] = $value;
        $message = "Changed to $value in the position " . ($position+1) . ".";
    } elseif (isset($_POST['average'])) {
        $average = ($_SESSION['array'][0]+$_SESSION['array'][1]+$_SESSION['array'][2])/3;
         $message = 'The average is ' . $average;
    } elseif (isset($_POST['reset'])) {
        $_SESSION['array'] = [10,20,30];
        $message = "Array reset.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify array saved in session</title>
</head>
<body>
    <h1>Modify array saved in session</h1>
    <form method="post">
        
        <label for="position">Choose position:</label>
        <select name="position" id="position">
            <option value="0">1</option>
            <option value="1">2</option>
            <option value="2">3</option>
        </select>
        <br><br>

        <label for="value">New value: [Default is 0]</label>
        <input type="number" name="value" id="value" min="1" >
        <br><br>
        
        <button type="submit" name="modify">modify</button>
        <button type="submit" name="average">average</button>
        <button type="submit" name="reset">reset</button>
    </form>
    
    <h2>Array:</h2>
    <ul>
        <li>Number List: <?php echo implode(', ', $_SESSION['array']); ?></li>
    </ul>
    <?php if ($message): ?>
        <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
    <?php endif; ?>
</body>
</html>
