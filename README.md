## PICSHARE

簡易インスタグラム。ログイン機能 / 文章・写真投稿 / タグ付け / タグ検索 / タグあいまい検索 / 投稿の更新・削除 等が使える。

AWSのlightsailを使用して、デプロイしている。

Controller -> App/Http/Controllers/HomeController.php メインコントローラー。できるだけ見やすいを意識

Validate ->  App/Http/Reqests 投稿された値のバリデートを行うクラスをまとめている

Models -> DBとのリレーション、DBとのやり取りを行うメソッドなどをまとめている

View -> resources/views Bladeファイルをまとめている。CSS・JSはpublicの中にある

Storage -> 投稿された写真をまとめている。publicとリンクしている
