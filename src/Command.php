<?php

/**
 * Command registration
 * @package iqomp/publish
 * @version 0.0.3
 */

namespace Iqomp\Publish;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Utils\Arr;
use Hyperf\Utils\Composer;
use Hyperf\Utils\Filesystem\Filesystem;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * @Command
 */
class Command extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    protected function configure()
    {
        $this->setDescription('Run the publishing for this module');
    }

    public function handle()
    {
        $fs = $this->filesystem;

        $extras = Composer::getMergedExtra() ?? null;

        foreach ($extras as $extra) {
            $provider = Arr::get($extra, 'hyperf.config');
            if (!$provider || !class_exists($provider)) {
                continue;
            }

            $config = (new $provider())();
            $publish = Arr::get($config, 'publish');

            if (!$publish) {
                continue;
            }

            foreach ($publish as $pub) {
                $source = $pub['source'];
                $target = $pub['destination'];
                $target_dir = dirname($target);

                if ($fs->exists($target)) {
                    continue;
                }

                if (!$fs->exists($target_dir)) {
                    $fs->makeDirectory($target_dir, 0755, true);
                }

                if ($fs->isDirectory($source)) {
                    $fs->copyDirectory($source, $target);
                } else {
                    $fs->copy($source, $target);
                }
            }
        }
    }

    public function __construct(ContainerInterface $container, Filesystem $fs)
    {
        parent::__construct('iqomp:publish');
        $this->container = $container;
        $this->filesystem = $fs;
    }
}
