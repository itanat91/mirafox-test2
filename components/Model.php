<?php

namespace app\components;

abstract class Model
{
    abstract public static function getTableName();
    public function getAll(\PDO $link)
    {
        $tableName = self::getTableName();
        $sql = $link->query('select * from $tableName' . $tableName);
        $link->prepare($sql);
    }
}