<?php
//model/abstract/ AbstractManager.php
declare(strict_types=1);

namespace model\abstract;

use model\interface\ManagerInterface;
use model\MyPDO;

abstract class AbstractManager implements ManagerInterface
{
    protected MyPDO $connect;

    public function __construct(MyPDO $connect)
    {
        $this->connect = $connect;
    }
}
