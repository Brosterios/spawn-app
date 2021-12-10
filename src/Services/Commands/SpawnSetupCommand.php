<?php

namespace spawnApp\Services\Commands;

use bin\spawn\IO;
use Doctrine\DBAL\Exception;
use spawn\system\Core\Base\Helper\DatabaseHelper;
use spawn\system\Core\Custom\AbstractCommand;
use spawn\system\Core\Services\ServiceContainerProvider;
use spawn\system\Throwables\DatabaseConnectionException;
use spawn\system\Throwables\WrongEntityForRepositoryException;

class SpawnSetupCommand extends AbstractCommand {


    public static function getCommand(): string
    {
        return 'spawn:setup';
    }

    public static function getShortDescription(): string
    {
        return 'Executes the default setup for a clean start in the project';
    }

    public static function getParameters(): array
    {
        return [];
    }

    /**
     * @param array $parameters
     * @return int
     * @throws Exception
     * @throws WrongEntityForRepositoryException
     * @throws DatabaseConnectionException
     */
    public function execute(array $parameters): int
    {
        (new PrintSpawnCommand())->execute([]);

        $confirmation = IO::readLine(IO::LIGHT_RED_TEXT.'This action depends on having an empty database. Do you want to continue? (yes/no/y/n)'.IO::DEFAULT_TEXT, function ($answer) {
            return in_array($answer, ['yes','no','y','n']);
        });

        if(!in_array($confirmation, ['yes', 'y'])) {
            IO::printLine('Aborting...', IO::RED_TEXT);
            return 0;
        }


        $databaseHelper = new DatabaseHelper();

        try {
            $connection = $databaseHelper->getConnection()::getConnection();
            if(!$connection->isConnected()) {
                $connection->connect();
            }
        }catch (Exception $e) {
            IO::printError('Cant connect to Database! Aborting...');
            return 1;
        }

        $container = ServiceContainerProvider::getServiceContainer();


        //setup minimal db structure
        (new DatabaseSetupMinimalCommand())->execute(DatabaseSetupMinimalCommand::createParameterArray([]));

        //refresh modules
        /** @var ModulesRefreshCommand $modulesRefreshCommand */
        $modulesRefreshCommand = $container->get('system.command.module_refresh');
        $modulesRefreshCommand->execute(ModulesRefreshCommand::createParameterArray(['m'=>true]));

        //update database
        (new DatabaseUpdateCommand())->execute(DatabaseUpdateCommand::createParameterArray([]));

        //execute migrations
        /** @var MigrationExecuteCommand $modulesRefreshCommand */
        $migrationExecuteCommand = $container->get('system.command.migration_execute');
        $migrationExecuteCommand->execute(MigrationExecuteCommand::createParameterArray([]));

        //refresh actions
        $modulesRefreshCommand->execute(ModulesRefreshCommand::createParameterArray(['a'=>true]));

        //clear cache
        (new CacheClearCommand())->execute(CacheClearCommand::createParameterArray([]));

        return 0;
    }





}