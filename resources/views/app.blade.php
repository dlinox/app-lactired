<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  @vite(['resources/assets/styles/scss/app.scss', 'resources/js/app.js'])
  @inertiaHead

  <style>
    html {
      overflow: auto !important;
    }
  </style>
</head>

<body>
  @inertia
</body>

</html>