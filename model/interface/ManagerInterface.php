<?php
//model/interface/ManagerInterface.php
declare(strict_types=1);

namespace model\interface;

use PDO;

interface ManagerInterface
{
    public function __construct(PDO $connect);
}
