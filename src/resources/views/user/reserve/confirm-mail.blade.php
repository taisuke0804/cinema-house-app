<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
</head>

<body>
  <p>{{ $user->name }}様、この度はご予約いただきありがとうございます。</p>
  <p>以下の内容でご予約を承りました。</p>
  <br>

  <label for="">■上映日</label>
  <div>{{ $screening_date }}</div>

  <label for="">■上映作品</label>
  <div>{{ $screen->movie->title }}</div>

  <label for="">■上映時間</label>
  <div>{{ $screen->start_time }} ~ {{ $screen->end_time }}</div>

  <label for="">■座席</label>
  <div>{{ $seat_number }}</div>
  <br>

  <p>ご来場の際は、こちらのメール画面をご提示ください。</p>
  <p>当日ご不在の場合、ユーザー登録情報の電話番号にお電話することがあります。ご了承ください。</p>
</body>

</html>