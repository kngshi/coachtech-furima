<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $subject }}</title>
</head>
<body>
    <h2>{{ $subject }}</h2>
    <p>{!! nl2br(e($content)) !!}</p>
</body>
</html>