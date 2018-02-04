<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
  @include('inc.head')
  <body>
    <div id="app">
      @include('inc.nav')
      @yield('content')
    </div>
    <script src="https://js.pusher.com/4.2/pusher.min.js"></script>
    <script src="{{asset('/js/app.js')}}"></script>
    @yield('scripts')
  </body>
</html>
