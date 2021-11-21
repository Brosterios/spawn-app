<?php

namespace spawnApp\Services\Commands;

use bin\spawn\IO;
use spawn\system\Core\Contents\Modules\Module;
use spawn\system\Core\Contents\Modules\ModuleCollection;
use spawn\system\Core\Custom\AbstractCommand;
use spawn\system\Core\Helper\FrameworkHelper\ResourceCollector;
use spawn\system\Core\Helper\ScssHelper;

class ThemeCompileCommand extends AbstractCommand {

    public static function getCommand(): string
    {
        return 'modules:compile';
    }

    public static function getShortDescription(): string
    {
        return '';
    }

    protected static function getParameters(): array
    {
        return [
            'js' => ['j', 'javascript'],
            'scss' => ['s', 'scss'],
        ];
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function execute(array $parameters): int
    {
        $moduleCollection = ListModulesCommand::getModuleList();

        $compileAll = (!!$parameters['js'] && !!$parameters['scss']);



        $this->gatherFiles($moduleCollection);

        if($parameters['js'] || $compileAll) {
            $this->compileJavascript();
        }

        if($parameters['scss'] || $compileAll) {
            $this->compileScss();
        }

        return 0;
    }


    protected function compileScss(): void {
        IO::printWarning("> compiling SCSS");

        $scssHelper = new ScssHelper();
        $scssHelper->setBaseVariable("assetsPath", MAIN_ADDRESS.'/'.CACHE_DIR.'/public/assets');
        $scssHelper->setBaseVariable("defaultAssetsPath", MAIN_ADDRESS.'/'.CACHE_DIR.'/public/assets');
        $scssHelper->createCss();

        IO::printSuccess("> - successfully compiled SCSS");
    }

    /**
     * @param ModuleCollection $moduleCollection
     * @throws \Exception
     */
    protected function compileJavascript(): void {
        //javascript kompilieren
        IO::printWarning("> compiling JavaScript");

        NpmInstallCommand::addNodeJSToPath();
        $code = 0;
        $webpackDir = ROOT . "/src/npm";
        $output = IO::execInDir("npx webpack --config webpack.config.js --progress", $webpackDir, false, $result, $code);

        if($code != 0) {
            IO::printError(implode(PHP_EOL, $result));
            throw new \Exception('Could not compile javascript with webpack');
        }

        IO::printLine(IO::TAB . '- ' . $output);
        IO::printSuccess("> - successfully compiled JavaScript");
    }

    protected function gatherFiles(ModuleCollection $moduleCollection): void {
        IO::printWarning("> gathering files from modules...");

        /** @var Module $module */
        foreach($moduleCollection->getModuleList() as $module) {
            IO::printLine(IO::TAB . "- " . $module->getName());
        }

        $resourceCollector = new ResourceCollector();
        $resourceCollector->gatherModuleData($moduleCollection);

        IO::printSuccess("> - Successfully gathered files");
    }

}