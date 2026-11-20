<?php declare(strict_types=1);

/**
 * @package     Triangle Events Component
 * @link        https://github.com/Triangle-org/Events
 * @author      Ivan Zorin <creator@localzet.com>
 * @copyright   Copyright © 2016-2026 Localzet Group. All rights reserved.
 * @license     https://www.gnu.org/licenses/agpl-3.0 GNU Affero General Public License v3.0
 */

require dirname(__DIR__) . '/vendor/autoload.php';

use support\Events;
use Triangle\Engine\BootstrapInterface;
use Triangle\Engine\Plugin;
use Triangle\Events\Bootstrap;

if (!is_a(Bootstrap::class, BootstrapInterface::class, true)) {
    throw new RuntimeException('The event bootstrap must implement the Engine bootstrap contract.');
}

if (!method_exists(Plugin::class, 'app_reduce') || !method_exists(Plugin::class, 'plugin_reduce')) {
    throw new RuntimeException('The event bootstrap requires Engine plugin reduction hooks.');
}

$event = 'triangle.events.bootstrap.compatibility';
$received = null;
$payload = ['source' => 'test'];

Bootstrap::load([
    $event => [
        static function (array $data) use (&$received): void {
            $received = $data;
        },
    ],
]);

Events::emit($event, $payload);

if ($received !== $payload) {
    throw new RuntimeException('The configured event listener did not receive its payload.');
}

echo "TRIANGLE_EVENTS_ENGINE_COMPATIBILITY=ok\n";
