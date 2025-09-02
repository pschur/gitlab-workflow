<?php

$gitlab_token = getenv("GITLAB_TOKEN");

if (!$gitlab_token) {
    http_response_code(500);
    echo "GITLAB_TOKEN environment variable is not set.\n";
    exit(1);
}

// verify if gitlab token exists and matches X-GITLAB-TOKEN header
if ($_SERVER['HTTP_X_GITLAB_TOKEN'] !== $gitlab_token) {
    http_response_code(403);
    echo "Invalid GITLAB_TOKEN.\n";
    exit(1);
}

$script = getenv("SCRIPT") ?? 'git pull';
$response = shell_exec("cd /workspace && $script");

$discord_webhook = getenv("DISCORD_WEBHOOK_URL");
if ($discord_webhook) {
    $payload = json_encode([
        'content' => "GitLab update received:\n```bash\n$response\n```"
    ]);
    $ch = curl_init($discord_webhook);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload)
    ]);
    curl_exec($ch);
    curl_close($ch);
}

$telegram_bot_token = getenv("TELEGRAM_BOT_TOKEN");
$telegram_chat_id = getenv("TELEGRAM_CHAT_ID");

if ($telegram_bot_token && $telegram_chat_id) {
    $payload = json_encode([
        'chat_id' => $telegram_chat_id,
        'text' => "GitLab update received:\n```bash\n$response\n```",
        'parse_mode' => 'Markdown'
    ]);
    $ch = curl_init("https://api.telegram.org/bot$telegram_bot_token/sendMessage");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload)
    ]);
    curl_exec($ch);
    curl_close($ch);
}

http_response_code(200);
echo "Success\n";
exit(0);