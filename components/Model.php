<?php

namespace app\components;

abstract class Model
{
    abstract public static function getTableName();

    public function getAll(\PDO $link)
    {
        $tableName = self::getTableName();
        return $link->query('select * from $tableName' . $tableName)->fetchAll();
    }
}