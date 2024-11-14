## Review 

> **gigaGPTIntegration** -  Это интеграция с gigachat, которая предоставляет удобный интерфейс для работы с этой нейросетью.


## Installion 

**Для установки выполните команду**


```bash
composer require vds-engineer/giga-gpt-integration
```

## Examples

<p>Для использования этого пакета вам потребуется AUTH_TOKEN - это результат кодирования в base64 идентификатора (Client ID) и клиентского ключа (Client Secret) API</p>

[подробнее тут о `Authorization`](https://developers.sber.ru/docs/ru/gigachat/api/reference/rest/post-token)


```php
$gigaGpt = (new GigaGpt($_ENV['AUTH_TOKEN']))->setToken(); // получаем JWT token 

// Генерация текста
$response = $gigaGpt->chatCompletion('что умеет GigaChat'); // Пользуемся :) 

// Генерация картинок 
 $gigaGpt = (new GigaGpt($_ENV['AUTH_TOKEN']))->setToken(); 
 $response = $gigaGpt->chatCompletionImage('Нарисуй арт'); 

// giga пришлет сообщения с id вашей картинки 
$pattern = '/(")(\d||\w||-)*(")/U';
preg_match($pattern, $response, $matches);

// с помощью downloadFile мы скачиваем файл передавая в него id файла  
$response = $gigaGpt->downloadFile(str_replace('"', '', $matches[0]));
```

#### Что умеет gigaGPTIntegration

1. Работа с контекстом 
2. Генерация текста и создания диалогов 
3. Генерация картинок

#### Важные методы для работы с пакетом 

```php 
$gigaGpt = (new GigaGpt($_ENV['AUTH_TOKEN']))->setToken(); // setToken получить JWT токен
$settingArray = [
    'auth' => $_ENV['AUTH_TOKEN'], // AUTH_TOKEN о нем было выше 
    'token' => '', // JWT токет который мы получаем с помощью setToken()
    'model' => 'GigaChat', // Желаймая модель 
    'stream' => true, // если true, будут отправляться частичные ответы сообщений
    'updateInterval' => 1, // интервал в секундах, не чаще которого будут присылаться токены в stream режиме
    'xRequestId' => 'b6874da0-bf06-410b-a150-fd5f9164a0b2', // id запроса 
    'xSessionId' => '1234567890', // id сессии 
    'xClientId' => '1234567890', // id клиета важен при гинерации картинок картинок 
    'RqUID' => '1234567890', // уникальный идентификатор запроса**
    'functionCall' => 'chatCompletion', // Поле, которое отвечает за то, как GigaChat будет.
];

$gigaGpt->setSetting($settingArray);

$gigaGpt->getSetting(); // получаем наши настройки ($settingArray)

$input = [
	"Я к вам пишу — чего же боле?",
	"Что я могу еще сказать?",
	"Теперь, я знаю, в вашей воле",
	"Меня презреньем наказать.",
	"Но вы, к моей несчастной доле",
	"Хоть каплю жалости храня,",
	"Вы не оставите меня."
];
// Получить колличество токинов за запрос
$giga->getCountToken(array $input);

// Получаем список моделей 
$giga->getListModels();
```


#### Работа с контекстом  

```php
// Также вы можете устанавливать контекст для создания диалогов

// context - это массив вида
$context[
	[
	    'role' => 'user',
	    'content' => 'Hi world',
	],
	[
	    'role' => 'system',
	    'content' => 'Hi world',
	]
];

$gigaGpt = new GigaGpt($_ENV['AUTH_TOKEN']);

// устанавливаем ваш диалог 
$gigaGpt->setContextGPT($context);

// добавляем в диалог сообщения с ролью system
$gigaGpt->pushContextSystemGPT('ты эйнштейн');

// добавляем в диалог сообщения с ролью user 
$gigaGpt->pushContextUserGPT('теория относительности это');

// Получить контекст для сохранения
$gigaGpt->getContextGPT();

// Отчищаем контекст 
$gigaGpt->clearContextGPT();
```



