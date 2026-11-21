<p align="center"><a href="https://www.localzet.com" target="_blank">
  <img src="https://static.zorin.space/media/logos/LocalzetGroup.png" width="400">
</a></p>

<p align="center">
  <a href="https://packagist.org/packages/triangle/events">
  <img src="https://img.shields.io/packagist/dt/triangle/events?label=%D0%A1%D0%BA%D0%B0%D1%87%D0%B8%D0%B2%D0%B0%D0%BD%D0%B8%D1%8F" alt="Скачивания">
</a>
  <a href="https://github.com/Triangle-org/Events">
  <img src="https://img.shields.io/github/commit-activity/t/Triangle-org/Events?label=%D0%9A%D0%BE%D0%BC%D0%BC%D0%B8%D1%82%D1%8B" alt="Коммиты">
</a>
  <a href="https://packagist.org/packages/triangle/events">
  <img src="https://img.shields.io/packagist/v/triangle/events?label=%D0%92%D0%B5%D1%80%D1%81%D0%B8%D1%8F" alt="Версия">
</a>
  <a href="https://packagist.org/packages/triangle/events">
  <img src="https://img.shields.io/packagist/dependency-v/triangle/events/php?label=PHP" alt="Версия PHP">
</a>
  <a href="https://github.com/Triangle-org/Events">
  <img src="https://img.shields.io/github/license/Triangle-org/Events?label=%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F" alt="Лицензия">
</a>
</p>

# Triangle Events

Triangle Events registers application event listeners during Engine startup and provides an in-process dispatcher with exact-name and prefix listeners.

## Requirements

- PHP 8.1 or later
- Triangle Engine 9.x

Install the package with Composer:

```sh
composer require triangle/events:^2.0
```

## Register and dispatch events

```php
use support\Events;

Events::on('invoice.created', static function (array $invoice, string $event): void {
    // Handle the created invoice.
});

Events::emit('invoice.created', ['id' => 42]);
```

Use a trailing `*` to register a prefix listener, for example `invoice.*`. Listeners receive the event payload followed by the event name. Dispatch is process-local; it does not provide durable queueing or cross-worker delivery.

Listeners can also be declared in `config/event.php`:

```php
return [
    'invoice.created' => [
        [App\Listeners\InvoiceCreated::class, 'handle'],
    ],
];
```

The Engine bootstrap loads application and plugin event configuration at startup. Engine 8 is not supported: this component uses the plugin configuration hooks introduced in Engine 9.

Русская версия: [README.ru.md](README.ru.md).
