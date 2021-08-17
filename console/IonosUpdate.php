<?php 

namespace Synder\IONOS\Console;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use System\Classes\UpdateManager;


class IonosUpdate extends Command
{
    /**
     * Console Command Name
     * @var string
     */
    protected $name = 'ionos:update';

    /**
     * Console Command Description
     * @var string
     */
    protected $description = 'Updates October CMS and all plugins, database and files on IONOS Webhoster packages.';

    /**
     * Execute Command
     * 
     * @return void
     */
    public function handle()
    {
        $this->output->writeln('<info>Updating October CMS...</info>');

        // Check PHP Version
        $phpv = $this->option('phpv') ?? 'php7.4-cli';
        $skip = $this->option('skip-nophp') ?? false;
        if (strpos($phpv, 'php') !== 0 && !$skip) {
            $this->output->error('The passed PHP Command "' . $phpv . '" seems invalid, use --skip-nophp to proceed.');
            exit(1);
        }

        // Check PHP Command
        $errCode = null;
        passthru("command -v $phpv", $errCode);
        if (!empty($errCode)) {
            $this->output->error('The passed PHP command "' . $phpv . '" does not exist on your machine.');
            exit(1);
        }

        // Composer update
        $this->comment("Executing: $phpv composer update --no-scripts");
        $this->output->newLine();

        $errCode = null;
        passthru("$phpv composer update --no-scripts", $errCode);

        if ($errCode !== 0) {
            $this->output->error('Update failed. Check output above');
            exit(1);
        }

        // October Util
        $this->comment("Executing: $phpv artisan october:util set build");
        $this->output->newLine();

        passthru("$phpv artisan october:util set build");

        // October Mirror
        $this->comment("Executing: $phpv artisan october:mirror --composer");
        $this->output->newLine();

        passthru("$phpv artisan october:mirror --composer");

        // Migrate database
        $this->comment("Executing: $phpv artisan october:migrate");
        $this->output->newLine();

        $errCode = null;
        passthru("$phpv artisan october:migrate", $errCode);

        if ($errCode !== 0) {
            $this->output->error('Migration failed. Check output above');
            exit(1);
        }

        try {
            $this->output->success(sprintf('System Updated to v%s', UpdateManager::instance()->getCurrentVersion()));
        }
        catch (Exception $ex) {
            // ...
        }
    }

    /**
     * getOptions get the console command options
     */
    protected function getOptions()
    {
        return [
            ['phpv', null, InputOption::VALUE_OPTIONAL, 'Change the used PHP command version (ex. php8.0-cli).'],
            ['skip-nophp', null, InputOption::VALUE_NONE, 'Required, if the desired phpv command does not start with php.']
        ];
    }
}
