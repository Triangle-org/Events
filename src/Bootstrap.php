<?php
/**
 * @package     Triangle Events Component
 * @link        https://github.com/Triangle-org/Events
 *
 * @author      Ivan Zorin <creator@localzet.com>
 * @copyright   Copyright (c) 2023-2024 Triangle Framework Team
 * @license     https://www.gnu.org/licenses/agpl-3.0 GNU Affero General Public License v3.0
 *
 *              This program is free software: you can redistribute it and/or modify
 *              it under the terms of the GNU Affero General Public License as published
 *              by the Free Software Foundation, either version 3 of the License, or
 *              (at your option) any later version.
 *
 *              This program is distributed in the hope that it will be useful,
 *              but WITHOUT ANY WARRANTY; without even the implied warranty of
 *              MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *              GNU Affero General Public License for more details.
 *
 *              You should have received a copy of the GNU Affero General Public License
 *              along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 *              For any questions, please contact <triangle@localzet.com>
 */

namespace Triangle\Events;

use localzet\Server;
use RuntimeException;
use support\Container;
use support\Events;
use Triangle\Engine\BootstrapInterface;
use Triangle\Engine\Plugin;

class Bootstrap implements BootstrapInterface
{
    public static function start(?Server $server = null): void
    {
        if (!$server) {
            return;
        }

        $config = config();

        self::load($config['event'] ?? []);

        Plugin::app_reduce(function ($plugin, $config) {
            self::load($config['event'] ?? []);
        });

        Plugin::plugin_reduce(function ($vendor, $plugins, $plugin, $config) {
            self::load($config['event'] ?? []);
        });
    }

    public static function load(array $events): void
    {
        foreach ($events as $event => $callbacks) {
            if (!is_array($callbacks)) {
                throw new RuntimeException('Некорректная конфигурация событий');
            }

            foreach ($callbacks as $callback) {
                $callback = self::convertCallable($callback);

                if (is_callable($callbacks)) {
                    Events::on($event, $callback);
                } else {
                    throw new RuntimeException("Событие: $event => " . var_export($callback, true) . " не вызываемо");
                }
            }
        }
    }

    /**
     * Преобразует колбэк(и) в массив колбэков
     * @param mixed $callbacks
     * @return array|mixed
     */
    protected static function convertCallable(mixed $callbacks): mixed
    {
        if (is_array($callbacks)) {
            $callback = array_values($callbacks);
            if (is_array($callback) && is_string($callback[0])) {
                return [Container::get($callback[0]), $callback[1]];
            }
        }
        return $callbacks;
    }
}