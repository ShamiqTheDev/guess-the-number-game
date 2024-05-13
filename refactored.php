<?php
session_start();

function generateRandomNumber() {
    return strval(mt_rand(1000, 9999));
}

function checkGuess($user_guess, $target_number) {
    $correct_positions = 0;
    $correct_digits = 0;

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

    return ['correct_positions' => $correct_positions, 'correct_digits' => $correct_digits];
}

if (!isset($_SESSION['target_number']) || (isset($_POST['reset']) && $_POST['reset'])) {
    $_SESSION['target_number'] = generateRandomNumber();
    $_SESSION['attempts'] = 0;
    $_SESSION['reset'] = false;
    $_SESSION['history'] = [];
}

if (isset($_POST['guess'])) {
    $user_guess = strval($_POST['guess']);
    $target_number = $_SESSION['target_number'];
    $attempts = $_SESSION['attempts'];

    $result = '';
    if ($attempts < 5) {
        $resultArray = checkGuess($user_guess, $target_number);

        $attempts++;
        $_SESSION['attempts'] = $attempts;
        $_SESSION['history']['inputs'][$user_guess][] = $resultArray;

        if ($resultArray['correct_positions'] === 4) {
            $result = "Congratulations! You guessed the number: $user_guess";
            $_SESSION['reset'] = true;
            unset($_SESSION['target_number']);
        } else {
            $result = "Attempts: $attempts | Correct Digits Guessed: " . $resultArray['correct_digits'] . " | Correct Positions Guessed: " . $resultArray['correct_positions'];
        }
    } else {
        $result = "Sorry, you've run out of attempts. The number was: " . $_SESSION['target_number'];
        $_SESSION['reset'] = true;
        unset($_SESSION['target_number']);
    }
}

include('header.php'); // Consider creating a header and footer for consistent HTML structure.

if (isset($_SESSION['reset']) && $_SESSION['reset']) {
    echo '<button type="submit" name="reset">Reset Game</button>';
} else {
    echo '<label for="guess">Enter your 4-digit guess:</label>';
    echo '<input type="text" name="guess" pattern="\d{4}" maxlength="4" required>';
    echo '<button type="submit">Submit Guess</button>';
}

include('footer.php'); // Consider creating a header and footer for consistent HTML structure.
