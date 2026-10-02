<?php
//model/abstract/ AbstractManager.php
declare(strict_types=1);

namespace model\abstract;

use model\interface\ManagerInterface;
use PDO;

abstract class AbstractManager implements ManagerInterface
{
    protected PDO $connect;

    public function __construct(PDO $connect)
    {
        $this->connect = $connect;
    }
}
