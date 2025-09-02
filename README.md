# GitLab Workflow

This little app can setup to automaticly update the contents of a repository at the instance it's pushed to a repository (only in GitLab at the moment) which opens the url `http(s)://<yourdomain.com>/<maybe_some_path_if_you_like>/run.php` verifies with a pre shared token and booom the new version is online.

I don't recommend to run this in a buissness/production environment. It's build for homelab guys and some who want to have a quick workflow without the need to setup a big instance of n8n (for example).

If you have the time and will to contribute to this project to make it bigger and to add more functions, feel free to do it. As for me I plan to make some improvements in the future but not in the next months.

## Configuration (Environment Variables)

| Variable | Description |
|----------|-------------|
| `GITLAB_TOKEN` | This is a token you can generate with every password/token generator. **This value is required!** |
| `SCRIPT` (optional) | Here you define what should run after the workflow got called. Default: `git pull` |
| `DISCORD_WEBHOOK_URL` (optional) | If you want to send the result via Discord give him a webhook url and go. (I have not tested this feature) |
| `TELEGRAM_BOT_TOKEN` (optional) | If you want to send the result via Telegram give him a bot token and the chat id (the enviroment variable below). (I have not tested this feature) |
| `TELEGRAM_CHAT_ID` (optional) | *look at the description above* |
