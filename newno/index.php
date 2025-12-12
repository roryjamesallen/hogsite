<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>NEWNO</title>
  </head>
  <body>
    <h1><img src="newno.png" class="drawing"/></h1>
    <h2>Introduction</h2>
    <i>NEWNO</i> is a custom ruleset for the popular card game <a href="https://en.wikipedia.org/wiki/Uno_(card_game)">UNO</a> that has been cobbled together over many years by a group of friends from <a href="https://en.wikipedia.org/wiki/Macclesfield">Macclesfield, England.</a>
    <h2>Gameplay</h2>
    <h3>Overview</h3>
    The basic gameplay is the same as the standard game, so read <a href="https://www.unorules.com/">those rules</a> if you aren't already familiar. The NEWNO ruleset may override original UNO rules, and the specific edge cases that may arise have been considered only in relation to the ruleset as a whole: don't expect for whatever individual house rules you have for the standard game to integrate neatly - they probably won't.<br><br>The best way to start playing NEWNO is to skim this document and begin playing, then consult when you aren't sure what's supposed to happen.
    <h3>Dealing</h3>
    Deal seven cards to each player, placing them face down on the table. Once you've dealt them, place the remaining deck in the middle of the table, also face down.<br><br>You cannot touch any of the hands while cards are still being dealt, but after the last card is dealt you may take any hand to be your own (not necessarily the one in front of you). Once you have touched a hand it becomes yours, as long as you were the first to touch it.
    <h3>Starting to Play</h3>
    <strong>The first player to play plays first.</strong>
    Any player may start the game once all the cards have been dealt and the deck has been placed in the middle. The starting player may play any card from their deck by placing it face up next to the face down deck, creating the <i>discard pile</i>.
    <strong>The second player to play goes second.</strong>
    Whichever player (to either the direct left or direct right of the starting player) is quick enough to go second, may play any legal card from their hand, also placing it face up on the discard pile. After the second player has played, the direction is set. If you find yourself in a stalemate where neither player adjacent to the first player wants to play (for example if neither can play so one would have to pick up a card to determine the direction of play), the first player can nominate who goes second. It's up to the rest of the players to determine if a fair amount of time has passed before this can happen.
  <h3>Continuing to Play</h3>
  After the first two players have played, each player in turn (in the direction set by the first two players' order) play one card from their deck. Special cards may change the direction - see below for all of the special cards and their eccentricities. If you cannot play, you must draw one card from the face down deck.
  <h4>The Apex Gambit</h4>
  If you cannot play and thus draw one card, you are allowed to immediately play that card if it is legal. This does not apply when drawing cards as a penalty, for example after +2 or Wild Draw 4 cards.
  <h2>Special Rules</h2>
  <h3>Swap Cards</h3>
  <div class="drawing-by-text">
    <h4><img src="seven.png" class="drawing"/></h4>
    Seven cards act as 'swap with one other player' cards. When you play one, you can pick one player to swap hands with.
  </div>
  <hr>
  <div class="drawing-by-text">
    <h4><img src="zero.png" class="drawing"/></h4>
    Zero cards act as 'swap in the direction of play' cards. Every player passes their hand to the player on whichever side of them would play next given the current direction.
  </div>
  <hr>
  <h3>The Jump In Rule</h3>
  This is the biggest change to the original UNO rules, and is the one that makes Newno so fun:
  <strong>If you have the same colour AND number, you can play it <i>even when it isn't your turn.</i></strong>
  <ul>
    <li>You can only jump in if you have the same colour AND number (or special card)</li>
    <li>Play continues from the player who jumped in</li>
    <li>Play continues in the same direction as it was going before</li>
    <li>You can jump in on yourself but you must use one hand to draw them one after each other from your other hand - you can't put both down in one movement</li>
    <li>You can jump in with special cards too, see the individual rules below</li><br>
  </ul>
  <hr>
  <div class="drawing-by-text">
    <h4><img src="reverse.png" class="drawing"/></h4>
    <p>Jumping in with a reverse card cancels the original reverse (as <a href="https://www.youtube.com/watch?v=Uk1lU3nJsZg">two reverse</a> cards = no reverse), and play continues from the player who jumped in.</p>
  </div>
  For example:
  <ul>
    <li>6 people are playing: A, B, C, D, E, and F and the play direction is clockwise (A, B, C etc)</li>
    <li>C plays a reverse card</li>
    <li>E jumps in with a reverse card of the same colour</li>
    <li>Play resumes in the original direction, clockwise, with F playing next</li><br>
  </ul>
  <hr>
  <div class="drawing-by-text">
    <h4><img src="skip.png" class="drawing"/></h4>
    Jumping in with a skip will add one to the number of people to be skipped, so if you are jumping in on one skip, two people after you will be skipped.
  </div>
  For example:
  <ul>
    <li>6 people are playing: A, B, C, D, E, and F</li>
    <li>A plays a skip card</li>
    <li>C jumps in with a skip card of the same colour</li>
    <li>D and E are <i>both</i> skipped, and play resumes with F playing next</li>
  </ul>
  Skips can stack, but the number of skip jump ins in a row is limited by the number of players:<br>
  <strong>You cannot jump in with a skip if you would have had your go skipped by a previously played skip card, even if the previously played skip was a jump in.</strong><br>
  <hr>
  <div class="drawing-by-text">
    <h4><img src="wild.png" class="drawing"/></h4>
    For normal wild cards, the player who jumped in can choose the new colour instead of the original player, however you cannot jump in on a wild card if the first player has already called the new colour.
  </div>
  <hr>
  <div class="drawing-by-text">
    <h4 style="display: flex;"><img src="wild.png" class="drawing"/> <img src="plus-four.png" class="drawing"/></h4>
    The new player picks the colour in the same way as for a normal Wild card, however the number adds, so for the first jump in the number would increase from draw 4 to draw 8. As with a Wild, you cannot jump in if the colour has already been called (but you can still play it to defend yourself if it's your turn).
  </div>
  <hr>
  <div class="drawing-by-text">
    <h4><img src="plus-two.png" class="drawing"/></h4>
    The number of cards the next player along without a +2 to play must draw adds up normally, when jumping in play will just continue from the player who jumped.
  </div>
  <hr>
  <div class="drawing-by-text">
    <h4><img src="seven.png" class="drawing"/></h4>
    The first player to play a swap hand card (7) swaps with a player of their choice, and afterwards the player who jumped in can swap their hand with anyone else. Alternatively the player who jumped in can choose to swap two other players' hands and keep their own. You cannot jump in with a 7 if the first player to play one has already said which player they want to switch with.
  </div>
  <hr>
  <div class="drawing-by-text">
    <h4><img src="zero.png" class="drawing"/></h4>
    You can only jump in with an all swap (0) if nobody has yet touched the hand that they would be receiving by swapping. If you can and do jump in with another 0, nobody gets to look at the cards they would have got with a single swap/rotation, they just pass twice in the direction of play instead.
  </div>
  <h2>Playing Cards</h2>
  It is possible to play NEWNO with a standard set of playing cards (as opposed to UNO cards), just substitute each of the special cards with normal cards as below, and use suits instead of colours.
  <ul>
    <li>0: 0</li>
    <li>2: +2</li>
    <li>3: Skip</li>
    <li>7: 7</li>
    <li>5: Reverse</li>
    <li>King: Wild</li>
    <li>Ace: Wild +4</li>
  </ul>
  </body>
</html>
