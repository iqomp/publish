<?php

/**
 * Config provider
 * @package iqomp/publish
 * @version 0.0.1
 */

namespace Iqomp\Publish;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'commands' => [
                Command::class
            ]
        ];
    }
}
