<?php

/**
 * Composer plugin definition
 * @package iqomp/publish
 * @version 0.0.1
 */

namespace Iqomp\Publish;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Script\ScriptEvents;
use Composer\Script\Event;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    protected $composer;
    protected $io;

    // PluginInterface
    public function activate(Composer $composer, IOInterface $io)
    {
    }

    // PluginInterface
    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    // PluginInterface
    public function uninstall(Composer $composer, IOInterface $io)
    {
    }

    // EventSubscriberInterface
    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_AUTOLOAD_DUMP => 'postAutoloadDump'
        ];
    }

    public static function postAutoloadDump(Event $event)
    {
        `php bin/hyperf.php iqomp:publish`;
    }
}
