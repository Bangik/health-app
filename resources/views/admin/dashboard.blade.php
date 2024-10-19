<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  Hello: {{Auth::user()->name}}
  <br>
  Docs API: <a href="{{url('/docs/api#/')}}">Docs API</a>
</body>
</html>