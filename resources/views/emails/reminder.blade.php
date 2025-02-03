<!DOCTYPE html>
<html>
<head>
    <title>リマインダー</title>
</head>
<body>
    <h1>{{ $user->name }} さん、こんにちは！</h1>
    <p>昨日（{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}）の食事ログが一部未入力です。</p>
    <p>以下の食事が記録されていません：</p>
    <ul>
        @foreach ($missingMeals as $meal)
            <li>{{ ucfirst($meal) }}</li>
        @endforeach
    </ul>
    <p>忘れずにログを記録してください！</p>
</body>
</html>