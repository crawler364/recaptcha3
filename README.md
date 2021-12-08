### Установка компонента
* Распаковать в /local/components/wc/recaptcha3/
* Разместить в форме (Путь в визуальном редакторе WC/reCAPTCHA v3)
* Установить параметры компонента

###  Описание параметров
* Ключ сайта - https://www.google.com/recaptcha/.
* Секретный ключ - https://www.google.com/recaptcha/.
* Минимальный балл - 1.0 is very likely a good interaction, 0.0 is very likely a bot.
* Действие - reCAPTCHA v3 introduces a new concept: actions. When you specify an action name in each place you execute reCAPTCHA, you enable the following new features:
A detailed break-down of data for your top ten actions in the admin console
Adaptive risk analysis based on the context of the action, because abusive behavior can vary.
Importantly, when you verify the reCAPTCHA response, you should verify that the action name is the name you expect.

    *Note: Actions may only contain alphanumeric characters and slashes, and must not be user-specific.
* Расположение - расположение на странице.

### Системные требования
* 1C-Битрикс: 20.200.300 (на более старых не проверено)
* Кодировка: UTF-8

### Примечания
* Проверка капчи на стороне битрикса производится с помощью CMain::CaptchaCheckCode(captcha_word,captcha_sid);
