<?php

namespace spawnApp\Services\Commands;

use bin\spawn\IO;
use spawn\system\Core\Custom\AbstractCommand;

class PrintSpawnCommand extends AbstractCommand {

    public static function getCommand(): string
    {
        return 'spawn:print:title';
    }

    public static function getShortDescription(): string
    {
        return 'Prints out the Title of the S.P.A.W.N. Project';
    }

    protected static function getParameters(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function execute(array $parameters): int
    {
        IO::print('', IO::BLUE_BG);
        IO::print('', IO::LIGHT_CYAN_TEXT);
        IO::printLine(PHP_EOL);
        IO::printLine(IO::TAB . "   _____   ____    ___   _       __  _   __");
        IO::printLine(IO::TAB . "  / ___/  / __ \  /   | | |     / / / | / /");
        IO::printLine(IO::TAB . "  \__ \  / /_/ / / /| | | | /| / / /  |/ / ");
        IO::printLine(IO::TAB . " ___/ / / ____/ / ___ |_| |/ |/ / / /|  /  ");
        IO::printLine(IO::TAB . "/____(_)_/   (_)_/  |_(_)__/|__(_)_/ |_(_) ");
        IO::printLine(IO::TAB . "-> Standard PHP Application without Norms <-");
        IO::printLine(IO::TAB . "-> A Framework made by Fabian Holzwarth   <-");
        IO::endLine();
        IO::reset();

        return 0;
    }
}