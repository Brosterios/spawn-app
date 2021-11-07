<?php

namespace spawnApp\Database\AdministratorTable;

use spawn\Core\Base\Database\Definition\TableDefinition\DefaultColumns\BooleanColumn;
use spawn\Core\Base\Database\Definition\TableDefinition\DefaultColumns\CreatedAtColumn;
use spawn\Core\Base\Database\Definition\TableDefinition\DefaultColumns\JsonColumn;
use spawn\Core\Base\Database\Definition\TableDefinition\DefaultColumns\StringColumn;
use spawn\Core\Base\Database\Definition\TableDefinition\DefaultColumns\UpdatedAtColumn;
use spawn\Core\Base\Database\Definition\TableDefinition\DefaultColumns\UuidColumn;
use spawn\system\Core\Base\Database\Definition\TableDefinition\AbstractTable;

class AdministratorTable extends AbstractTable {

    public const TABLE_NAME = 'spawn_administrator';

    public function getTableColumns(): array
    {
        return [
            new UuidColumn('id', null),
            new StringColumn('username', false, '', true, 1024),
            new StringColumn('password', false, '', false, 1024),
            new StringColumn('email', false, '', true, 1024),
            new BooleanColumn('active', true),
            new UpdatedAtColumn(),
            new CreatedAtColumn()
        ];
    }

    public function getTableName(): string
    {
        return self::TABLE_NAME;
    }
}