# Triangle Events

Triangle Events подключает обработчики событий при запуске Engine и предоставляет диспетчер внутри процесса с точными и префиксными именами событий.

## Требования

- PHP 8.1 или новее
- Triangle Engine 9.x

Установите пакет через Composer:

```sh
composer require triangle/events:^2.0
```

## Регистрация и отправка событий

```php
use support\Events;

Events::on('invoice.created', static function (array $invoice, string $event): void {
    // Обработать созданный счёт.
});

Events::emit('invoice.created', ['id' => 42]);
```

Для регистрации обработчика на группу событий используйте `*` в конце имени, например `invoice.*`. Обработчик получает данные события, а затем его имя. Диспетчер работает в памяти процесса: он не сохраняет сообщения и не передаёт их другим workers.

Обработчики также можно указать в `config/event.php`:

```php
return [
    'invoice.created' => [
        [App\Listeners\InvoiceCreated::class, 'handle'],
    ],
];
```

Engine загружает конфигурацию приложения и плагинов во время запуска. Engine 8 не поддерживается: компонент использует хуки конфигурации плагинов, добавленные в Engine 9.

English version: [README.md](README.md).
