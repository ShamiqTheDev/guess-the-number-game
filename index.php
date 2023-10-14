<?php session_start();

// Check if the game is just starting or being reset
if (!isset($_SESSION['target_number']) || (isset($_POST['reset']) && $_POST['reset']) ) {
    // Generate a 4-digit random number
    $_SESSION['target_number'] = strval(mt_rand(1000, 9999));
    $_SESSION['attempts'] = 0;
    $_SESSION['reset'] = false;
    $_SESSION['history'] = [];
}

// Check if the user has submitted a guess
if (isset($_POST['guess'])) {
    $user_guess = strval($_POST['guess']);
    $target_number = $_SESSION['target_number'];
    $attempts = $_SESSION['attempts'];

    // Initialize arrays to track correct positions and correct digits
    $correct_positions = 0;
    $correct_digits = 0;

    // Convert the numbers to arrays for easy comparison
    $user_array = str_split($user_guess);
    $target_array = str_split($target_number);

    for ($i = 0; $i < 4; $i++) {
        if ($user_array[$i] == $target_array[$i]) {
            $correct_positions++;
        }

        if (in_array($user_array[$i], $target_array)) {
            $correct_digits++;
        }
    }

    $attempts++;

    if ($correct_positions === 4) {
        // User has guessed the correct number
        $result = "Congratulations! You guessed the number: $user_guess";
        $_SESSION['reset'] = true;
        unset($_SESSION['target_number']);
    } elseif ($attempts >= 5) {
        // User has used all their attempts
        $result = "Sorry, you've run out of attempts. The number was: " . $_SESSION['target_number'];

        $_SESSION['reset'] = true;
        unset($_SESSION['target_number']);
    } else {
        // Display the result of the current guess
        $result = "Attempts: $attempts | Correct Digits Guessed: $correct_digits | Correct Positions Guessed: $correct_positions";
    }
    $_SESSION['attempts'] = $attempts;

    $_SESSION['history']['inputs'][$user_guess][] = [
        'correct_digits' => $correct_digits,
        'correct_positions' => $correct_positions,
    ];


} else {
    // User hasn't submitted a guess yet
    $result = "";

}
var_dump($_SESSION['reset']);
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Number Guessing Game</title>
</head>
<body>
    <h1>Number Guessing Game</h1>
    <p><?php echo $result; ?></p>

    <form method="POST">
        <?php if(isset($_SESSION['reset']) && $_SESSION['reset']) { ?>
            <button type="submit" name="reset">Reset Game</button>
        <?php } else {?>
            <label for="guess">Enter your 4-digit guess:</label>
            <input type="text" name="guess" pattern="\d{4}" maxlength="4" required>
            <button type="submit">Submit Guess</button>
        <?php } ?>
    </form>

</body>
</html>
