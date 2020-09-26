<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
  </head>

  <body>
    @include('inc.nav')
      <div class="main">
        <div class="container">
            @include('inc.messages')
        </div>
        @yield('main')
      </div>
    @include('inc.footer')
    <script src="{{asset('js/app.js')}}"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('article-ckeditor',  {
          extraPlugins:'colorbutton',
          language: 'en',
          uiColor: '#985e6d'
        });
        /*var table = document.getElementsByTagName('table')[0],
        rows = table.getElementsByTagName('tr'),
        text = 'textContent' in document ? 'textContent' : 'innerText';

            for (var i = 0, len = rows.length; i < len; i++){
            rows[i].children[0][text] = i + ': ' + rows[i].children[0][text];
        }*/
    </script>
  </body>
</html>
