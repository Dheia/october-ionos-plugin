<?php

namespace Synder\IONOS;

use System\Classes\PluginBase;


class Plugin extends PluginBase
{
    const VERSION = '1.0.0';

    /**
     * Plugin dependencies
     *
     * @var array
     */
    public $require = [];

    /**
     * Plugin Details
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'synder.ionos::lang.plugin.name',
            'description' => 'synder.ionos::lang.plugin.description',
            'author'      => 'Synder <october@synder.dev>',
            'homepage'    => 'https://octobercms.com/plugin/synder-ionos'
        ];
    }

    /**
     * Register Plugin
     *
     * @return void
     */
    public function register()
    {
        $this->registerConsoleCommand('ionos.update', 'Synder\IONOS\Console\IonosUpdate');
    }
}
