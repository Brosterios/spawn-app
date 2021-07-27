<?php

namespace spawnApp\Controller\Backend;

use spawn\system\Core\Base\Controller\AbstractBackendController;
use spawn\system\Core\Base\Database\DatabaseConnection;
use spawn\system\Core\Base\Database\Definition\TableDefinition\ColumnDefinition;
use spawn\system\Core\Helper\UUID;

class BaseBackendController extends AbstractBackendController {

    public static function getSidebarMethods(): array
    {
        return [
            'Home' => [ //Kategory
                'title' => "Home", //Kategory title
                'color' => "#ff0000", //Kategory color
                'actions' => [ //Kategory actions
                    [
                        'controller' => '%self.key%',
                        'action' => 'homeAction', //action
                        'title' => 'Home Link' //action title
                    ]
                ]
            ]
        ];
    }


    public function homeAction() {


        $this->twig->assign('content_file', 'backend/contents/home/content.html.twig');
    }
}