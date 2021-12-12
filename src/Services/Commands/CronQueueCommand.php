<?php

namespace spawnApp\Services\Commands;

use spawnCore\Cron\CronManager;
use spawnCore\Custom\FoundationStorage\AbstractCommand;
use spawnCore\ServiceSystem\ServiceContainerProvider;

class CronQueueCommand extends AbstractCommand {

    public static function getCommand(): string
    {
        return 'cron:queue:start';
    }

    public static function getShortDescription(): string
    {
        return 'Executes the cron queue';
    }

    public static function getParameters(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function execute(array $parameters): int
    {
        /** @var CronManager $cronManager */
        $cronManager = ServiceContainerProvider::getServiceContainer()->getServiceInstance('system.core.cron.manager');
        $cronManager->executeCrons();

        return 0;
    }

}