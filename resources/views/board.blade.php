@extends('layouts.app')

@section('scripts')
<script type="text/javascript">
  // Check rows, columns and diagonals to find winner
  function checkResult() {
    let result = 'inProgress';
    if (
      $('#block-1.player-{{$mySym}}:checked').length &&
      $('#block-2.player-{{$mySym}}:checked').length &&
      $('#block-3.player-{{$mySym}}:checked').length
    ) {
      result = 'win';
    } else if (
      $('#block-4.player-{{$mySym}}:checked').length &&
      $('#block-5.player-{{$mySym}}:checked').length &&
      $('#block-6.player-{{$mySym}}:checked').length
    ) {
      result = 'win';
    } else if (
      $('#block-7.player-{{$mySym}}:checked').length &&
      $('#block-8.player-{{$mySym}}:checked').length &&
      $('#block-9.player-{{$mySym}}:checked').length
    ) {
      result = 'win';
    } else if (
      $('#block-1.player-{{$mySym}}:checked').length &&
      $('#block-4.player-{{$mySym}}:checked').length &&
      $('#block-7.player-{{$mySym}}:checked').length
    ) {
      result = 'win';
    } else if (
      $('#block-2.player-{{$mySym}}:checked').length &&
      $('#block-5.player-{{$mySym}}:checked').length &&
      $('#block-8.player-{{$mySym}}:checked').length
    ) {
      result = 'win';
    } else if (
      $('#block-3.player-{{$mySym}}:checked').length &&
      $('#block-6.player-{{$mySym}}:checked').length &&
      $('#block-9.player-{{$mySym}}:checked').length
    ) {
      result = 'win';
    } else if (
      $('#block-1.player-{{$mySym}}:checked').length &&
      $('#block-5.player-{{$mySym}}:checked').length &&
      $('#block-9.player-{{$mySym}}:checked').length
    ) {
      result = 'win';
    } else if (
      $('#block-3.player-{{$mySym}}:checked').length &&
      $('#block-5.player-{{$mySym}}:checked').length &&
      $('#block-7.player-{{$mySym}}:checked').length
    ) {
      result = 'win';
    };
    if((result == 'inProgress') && $('input[type=radio]:checked').length == 9) {
      result = 'tie';
    }
    return result;
  }
  // Pusher
  var pushr = new Pusher('a7b1e008db247b5f36dc', {'cluster' : 'mt1'});
  var playChannel = pushr.subscribe('game-channel-{{$game_id}}-{{$opponentId}}');
  var endChannel = pushr.subscribe('end-channel-{{$game_id}}-{{$opponentId}}');
  // When event is triggered, use public variables of event to update
  playChannel.bind('App\\Events\\PlayEvent', function(data) {
    $('#block-'+data.box).removeClass('player-{{$mySym}}')
                         .addClass('player-'+data.sym);
    $('#block-'+data.box).attr('checked', true);
    $('input[type=radio]').removeAttr('disabled');
    $('.profile-name').html("It's your move...");
  });
  endChannel.bind('App\\Events\\EndEvent', function(data) {
    $('#block-'+data.box).removeClass('player-{{$mySym}}')
                         .addClass('player-'+data.sym);
    $('#block-'+data.box).attr('checked', true);
    if(data.gameResult == 'win') {
      $('.profile-name').html('You Lose!!!');
    } else {
      $('.profile-name').html("It's a tie!");
    }
    $('#exit-button').show();
  });

  $(document).ready(function() {
    // When the board is clicked
    $('input[type=radio]').on('click', function() {
      // First disable all inputs
      $('input[type=radio]').attr('disabled', true);
      // Check if game has ended in "win" or "tie"
      // If game has not ended, send request to "/play/{game_id}" route
      // If game has ended, send request to "/game-over/{game_id}" route
      let gameResult = checkResult();
      if(gameResult == 'inProgress') {
        $('.profile-name').html('Waiting for opponent...');
        let box_num  = $(this).val();
        let post_url = '/play/' + {{$game_id}};
        let params   = {
          box : box_num,
          _token : $('input[name=_token]').val()
        };
        $.ajax({
          method : 'post',
          url    : post_url,
          data   : params,
        })
        .done(function(response) {
          console.log(response.data);
        })
        .fail(function(xhr, txt, err) {
          console.log(err + ' => ' + txt);
        });
      } else {
        if(gameResult == 'win') {
          $('.profile-name').html('You Win!!!');
        } else {
          $('.profile-name').html("It's a tie!");
        }
        $('#exit-button').show();
        let box_num  = $(this).val();
        let post_url = '/game-over/' + {{$game_id}};
        let params = {
          box        : box_num,
          gameResult : gameResult,
          _token     : $('input[name=_token]').val()
        };
        $.ajax({
          method : 'post',
          url    : post_url,
          data   : params,
        })
        .done(function(response) {
          console.log(response.data);
        })
        .fail(function(xhr, txt, err) {
          console.log(err + ' => ' + txt);
        });
      }
    });
  });
</script>
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="profile-info">
        <div class="profile-name">
          {{auth()->id()==$notPlayed->first()->player_id ? "It's your move..." : 'Waiting for opponent...'}}
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tic-tac-toe">
        @foreach($loc as $index => $lo)
        <input type="radio"
               class="player-{{$lo['checked'] ? $lo['sym'] : $mySym}} {{$lo['class']}}"
               id="block-{{$index}}"
               value="{{$index}}"
               {{$lo['checked'] ? 'checked' : ''}}
               {{auth()->id()!=$notPlayed->first()->player_id ? 'disabled' : ''}}>
        <label for="block-{{$index}}"></label>
        @endforeach
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <a id="exit-button" href="/home" class="btn btn-lg btn-primary"
         style="display: none;">Exit Game</a>
    </div>
  </div>
  {{csrf_field()}}
</div>
@endsection
