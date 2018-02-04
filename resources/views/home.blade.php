@extends('layouts.app')

@section('scripts')
<script type="text/javascript">
  var pushr = new Pusher('a7b1e008db247b5f36dc', {'cluster':'mt1'});
  var gameChannel = pushr.subscribe('newGameChannel');
  // When event is triggered, "data" contains public variables in "NewGame"
  gameChannel.bind('App\\Events\\NewGameEvent', function(data) {
    // Is the invitation for the logged-in user?
    if(data.invitee == '{{$me->id}}') {
      $('#from').html(data.invitor);
      $('#new-game-form').attr('action', '/board/' + data.gameId);
      $('#new-game-modal').modal('show');
    }
  });
  // When invitee clicks "Play" button in the modal window
  $('#play').on('click', function() {
    $('#new-game-form').submit();
  })
</script>
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading panel-heading-custom">Me</div>
        <div class="panel-body">
          <div class="profile-pic">
            <img src="https://www.gravatar.com/avatar/{{md5($me->email)}}?d=retro&s=200"
                 class="img-circle img-responsive" alt="{{$me->name}}">
          </div>
          <div class="profile-info">
            <div class="profile-name">{{$me->name}}</div>
            <div class="profile-score">Score: {{$me->score}}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading panel-heading-custom">Available Players
          <form class="form-inline pull-right" method="get"> <!-- Search form -->
            <div class="form-group">
              <label>Search:&nbsp;&nbsp;</label>
              <input type="text" name="search" class="form-control" value="{{request('search')}}">&nbsp;&nbsp;
              <button type="submit" class="btn btn-primary btn-xs">Go</button>
            </div>
          </form>
        </div>
        <div class="panel-body"> <!-- List of players and invite button -->
          <div class="list-group">
            @foreach($users as $u)
              <div class="list-group-item clearfix">
                <img src="https://www.gravatar.com/avatar/{{md5($u->email)}}?d=retro&s=75"
                     class="img-circle img-responsive" alt="{{$u->name}}">
                <span class="user-info">{{$u->name}}
                  <br>
                  <small>Score: {{$u->score}}</small>
                </span>
                <form action="{{route('newGame')}}" method="post">
                  {{csrf_field()}}
                  <input type="hidden" name="invitee" value="{{$u->id}}">
                  <button type="submit" class="btn btn-primary pull-right" name="button">Invite</button>
                </form>
              </div>
            @endforeach
          </div>
          {{$users->links()}}
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Invitation modal -->
<div class="modal fade" id="new-game-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Invitation to Play</h4>
      </div>
      <div class="modal-body">
        <p><span id="from"></span> is inviting you to play.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="play">Play</button>
      </div>
    </div>
  </div>
</div>
<!-- Form to redirect invitee to game board -->
<form id="new-game-form" method="get">
  {{csrf_field()}}
</form>
@endsection
