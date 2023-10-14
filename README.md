# Number Guessing Game

This is a simple number guessing game implemented in PHP. The game generates a random 4-digit number, and the user has 5 attempts to guess the correct number. The game keeps track of the number of correct digits guessed and the correct positions guessed.

## How to Play

1. When you open the game, you'll see a form to enter your 4-digit guess.

2. Enter your guess in the input field and click the "Submit Guess" button.

3. If your guess is correct, you'll receive a message saying "Congratulations! You guessed the number."

4. If you don't guess the correct number within 5 attempts, the game will show a message saying "Sorry, you've run out of attempts. The number was: [the correct number]."

5. You can reset the game at any time by clicking the "Reset Game" button.

## Features

- The game uses PHP sessions to keep track of the game state, including the target number, the number of attempts, and the user's guess history.

- It provides feedback on each guess, showing the number of correct digits guessed and the correct positions guessed.

- It allows you to reset the game if you want to play again.

## Code Structure

- `index.php` is the main PHP file that contains the game logic and HTML for user interaction.

- The game initializes a 4-digit random number and tracks user attempts in PHP sessions.

- The user's guesses are compared to the target number, and the results are displayed.

- The game keeps a history of the user's guesses and their results in the session data.

- The user can reset the game to play again.

## Requirements

- This game runs on a web server with PHP support. You can deploy it on a local server or a web hosting service.

## License

This game is open-source and free to use and modify according to your needs.
