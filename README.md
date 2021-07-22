## Setup Webhook


```bash
https://api.telegram.org/botTokenBoTAnda/setWebhook?url=https://nadoyo.my.id/webhook_telegram.php?auth=3b68b6a4f1ebeec7bae41cd0d3fab46a
```

## Kirim Callback

```php
function senTele($chatID, $akun, $username, $data, $server)
{
    $botToken = "881663171:AAHnbbTVRqoP7XaF83_gtJvyXa53E0oApSE";
    $website = "https://api.telegram.org/bot" . $botToken;
    $params = [
        'chat_id' => $chatID,
        'text' => "Hi @$username
    [#] Total Call Akun $akun $data di Server $server"];

    $ch = curl_init($website . '/sendMessage');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
}
```
