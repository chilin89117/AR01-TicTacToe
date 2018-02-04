# AR01-TicTacToe
## Tic-Tac-Toe game

![Home](../assets/a.png?raw=true)
![Board](../assets/b.png?raw=true)

### Pusher
- Add `"require":{"pusher/pusher-php-server":"^3.0"}` to `composer.json` and run `composer update`
- Set values in `.env` file
  - `PUSHER_APP_ID=`
  - `PUSHER_APP_KEY=`
  - `PUSHER_APP_SECRET=`
  - `PUSHER_APP_CLUSTER=`
  - `BROADCAST_DRIVER=pusher`
- Add `<script src="https://js.pusher.com/4.2/pusher.min.js"></script>` to main layout `app.blade.php`

### `home.blade.php`
- When "Invite" button is clicked,
  - `HomeController@newGame()`
    - sets userids for invitor and invitee
    - creates a new game in `games` table
    - creates 9 turns in `turns` table
    - (invitor always goes first with 'X')
    - triggers `NewGameEvent` (`app/events/NewGameEvent.php`)
    - invitor is redirected to the game board
- When `NewGameEvent` is triggered, it is broadcast on `newGameChannel` with variables
  - userid for invitor
  - userid for invitee
  - gameid
- A `Pusher` object subscribed to the `newGameChannel` listens for the event
- If the invitation is for the logged-in user, a modal window pops up for the invitee to accept
- If the invitee accepts (clicks the `Play` button), a form with `GET` request and action to the game board is submitted

### `board.blade.php`
- Use `<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>` in `head.blade.php`, version 5 of FA did not work
- `GameController@board` sets up board based on status of game
- When player clicks a box,
  - if the game is still in progress,
    - AJAX request is sent to `play/{game_id}` route
    - `GameController@play` records the move and broadcasts the event (`PlayEvent.php`)
  - if the game has ended,
    - AJAX request is sent to `game-over/{game_id}` route
    - `GameController@gameOver` records the move and broadcasts the event(`EndEvent.php`)
- `Pusher` object
  - listens for `PlayEvent` on `playChannel`
  - listens for `EndEvent` on `endChannel`
  - sets the board's CSS classes accordingly
