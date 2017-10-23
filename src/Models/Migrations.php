<?php

namespace Sahakavatar\Modules\Models;

use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;

/**
 * Created by PhpStorm.
 * User: Sahak
 * Date: 10/3/2016
 * Time: 10:44 PM
 */
class Migrations
{
    protected $increments = [
        'bigIncrements' => [
            'Type' => 'bigint(20) unsigned',
            'Null' => 'NO',
            'Key' => 'PRI',
            'Default' => null,
            'Extra' => 'auto_increment'
        ],
        'increments' => [
            'Type' => 'int(10) unsigned',
            'Null' => 'NO',
            'Key' => 'PRI',
            'Default' => null,
            'Extra' => 'auto_increment'
        ]];

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function migrate($data)
    {
        $table = $data['name'];
        $columns = $data['column'];
        try {
            \Schema::create($table, function (Blueprint $table) use ($data) {
                $columns = $data['column'];
                $table->engine = self::engine()[$data['engine_type']];
                $types = self::types();
                foreach ($columns as $column) {
                    $type = $types[$column['type']];
                    $name = $column['name'];
                    $lenght = self::formate($type, $column['lenght']);
                    if ($type == 'decimal' || $type == 'double') {
                        $at = $table->$type($name, isset($lenght[0]) ? $lenght[0] : null, isset($lenght[1]) ? $lenght[1] : 0);

                    } else {
                        $at = $table->$type($name, $lenght);
                    }

                    $attributes = self::unsets($column);
                    foreach ($attributes as $k => $v) {
                        if ($k == 'unique') $v = null;
                        if ($k != 'default' and !empty($v)) {
                            $at->{$k}($v);
                        } elseif ($k == 'default' and !empty($v)) {
                            $at->{$k}($v);
                        }
                    }
                }
                if (isset($data['timestamps']) and $data['timestamps']) $table->timestamps();
            });
        } catch (QueryException $e) {
            return \Response::json(['error' => true, 'message' => $e->getMessage()]);
        } catch (\Psy\Exception\FatalErrorException $e) {
            return \Response::json(['error' => true, 'message' => $e->getMessage()]);
        }
        return \Response::json(['error' => false]);
    }

    /**
     * @return array
     */
    public static function engine()
    {
        return array('MyISAM', 'InnoDB');
    }

    /**
     * @return array
     */
    public static function types()
    {
        return [
            'bigIncrements',
            'bigInteger',
            'binary',
            'boolean',
            'char',
            'date',
            'dateTime',
            'dateTimeTz',
            'decimal',
            'double',
            'enum',
            'float',
            'increments',
            'integer',
            'ipAddress',
            'json',
            'jsonb',
            'longText',
            'macAddress',
            'mediumIncrements',
            'mediumInteger',
            'mediumText',
            'morphs',
            'nullableTimestamps',
            'rememberToken',
            'smallIncrements',
            'smallInteger',
            'softDeletes',
            'string',
            'text',
            'time',
            'timeTz',
            'tinyInteger',
            'timestamp',
            'timestampTz',
            'uuid',
        ];
    }

    /**
     * @param $type
     * @param $length
     * @return array
     */
    public static function formate($type, $length)
    {
        switch ($type) {
            case 'enum':
                return explode(',', $length);
                break;
            case 'double':
                return explode(',', $length);
                break;

            default:
                return $length;

        }

    }

    /**
     * @param $column
     * @return mixed
     */
    public static function unsets($column)
    {
        $type = self::types()[$column['type']];
        $key = $column['type'];
        unset($column['type']);
        unset($column['name']);
        unset($column['lenght']);
        $usetes = self::unsetble($type);
        if (is_array($usetes)) {
            foreach ($usetes as $unset) {
                if (isset($column[$unset])) unset($column[$unset]);
            }
        }
        return $column;


    }

    /**
     * @param $key
     * @return mixed
     */
    private static function unsetble($key)
    {
        $array = [
            'bigIncrements' => ['default', 'null'],
            'bigInteger' => [],
            'binary' => [],
            'boolean' => [],
            'char' => [],
            'date' => [],
            'dateTime' => [],
            'dateTimeTz' => [],
            'decimal' => [],
            'double' => [],
            'enum' => [],
            'float' => [],
            'increments' => ['default', 'null'],
            'integer' => [],
            'ipAddress' => [],
            'json' => [],
            'jsonb' => [],
            'longText' => [],
            'macAddress' => [],
            'mediumIncrements' => ['default', 'null'],
            'mediumInteger' => [],
            'mediumText' => [],
            'morphs' => [],
            'nullableTimestamps' => [],
            'rememberToken' => [],
            'smallIncrements' => [],
            'smallInteger' => [],
            'softDeletes' => [],
            'string' => [],
            'text' => ['default'],
            'time' => [],
            'timeTz' => [],
            'tinyInteger' => [],
            'timestamp' => [],
            'timestampTz' => [],
            'uuid' => [],
        ];
        return $array[$key];

    }

    public static function addcolumn($table, $data)
    {
        $columns = $data['column'];
        try {
            \Schema::table($table, function (Blueprint $table) use ($data) {
                $columns = $data['column'];
                $types = self::types();
                foreach ($columns as $column) {
                    $type = $types[$column['type']];
                    $name = $column['name'];
                    $lenght = self::formate($type, $column['lenght']);
                    if ($type == 'decimal' || $type == 'double') {
                        $at = $table->$type($name, isset($lenght[0]) ? $lenght[0] : null, isset($lenght[1]) ? $lenght[1] : 0)->after($data['after_column']);

                    } else {
                        $at = $table->$type($name, $lenght)->after($data['after_column']);
                    }

                    $attributes = self::unsets($column);
                    foreach ($attributes as $k => $v) {
                        if ($k == 'unique') $v = null;
                        if ($k != 'default' and !empty($v)) {
                            $at->{$k}($v);
                        } elseif ($k == 'default' and !empty($v)) {
                            $at->{$k}($v);
                        }
                    }
                }
                if (isset($data['timestamps']) and $data['timestamps']) $table->timestamps();
            });
        } catch (QueryException $e) {
            return \Response::json(['error' => true, 'message' => $e->getMessage()]);
        } catch (\Psy\Exception\FatalErrorException $e) {
            return \Response::json(['error' => true, 'message' => $e->getMessage()]);
        }
        return \Response::json(['error' => false]);
    }

    public static function editMigrated($table, $column_old, $data)
    {
        $columns = $data['column'];
        try {
            $table_name = $table;
            if (!isset($columns[0]['unique'])) {
                \Schema::table($table, function (Blueprint $table) use ($column_old, $table_name) {
                    $key = $table_name . '_' . $column_old . '_unique';
                    $keyExists = \DB::select(\DB::raw("SHOW KEYS FROM " . $table_name . " WHERE Key_name='" . $key . "' "));

                    if ($keyExists)
                        $table->dropUnique($table_name . '_' . $column_old . '_unique')->change();
                });
            }
            if ($columns[0]['name'] != $column_old) {
                \Schema::table($table, function (Blueprint $table) use ($columns, $column_old) {
                    $name = $columns[0]['name'];
                    $table->renameColumn($column_old, $name)->change();
                });
            }

            \Schema::table($table, function (Blueprint $table) use ($data, $column_old, $table_name) {
                $columns = $data['column'];
                $types = self::types();
                foreach ($columns as $column) {
                    $type = $types[$column['type']];
                    $name = $column['name'];
                    if ($name != $column_old) {
                    }
                    $lenght = self::formate($type, $column['lenght']);
                    if ($type == 'decimal' || $type == 'double') {
                        $at = $table->$type($name, isset($lenght[0]) ? $lenght[0] : null, isset($lenght[1]) ? $lenght[1] : 0);

                    } else {
                        $at = $table->$type($name, $lenght);
                    }

                    $attributes = self::unsets($column);
                    if (!isset($attributes['nullable'])) {
                        $attributes['nullable'] = false;
                    };
                    foreach ($attributes as $k => $v) {
                        if ($k == 'unique') $v = null;
                        if ($k == 'nullable') {
                            $at->$k($v);
                        }
                        if ($k != 'default' and !empty($v)) {
                            $at->$k($v);
                        } elseif ($k == 'default' and !empty($v)) {
                            $at->$k($v);
                        }

                    }
                    $at->change();

                }
                \App\Models\Fields::where('table_name', $table_name)
                    ->where('column_name', $column_old)
                    ->update(['column_name' => $data['column'][0]['name']]);
                if (isset($data['timestamps']) and $data['timestamps']) $table->timestamps();
            });
        } catch (QueryException $e) {
            return \Response::json(['error' => true, 'message' => $e->getMessage()]);
        } catch (\Psy\Exception\FatalErrorException $e) {
            return \Response::json(['error' => true, 'message' => $e->getMessage()]);
        }
        return \Response::json(['error' => false, 'redirect' => url("/admin/modules/tables/edit-column/$table", $data['column'][0]['name'])]);
    }

    public static function getLendth($column_info)
    {
        $detects = self::detect($column_info->DATA_TYPE);
        if ($detects == 'COLUMN_TYPE') return self::enumer($column_info);
        if ($detects) {
            $rez = null;
            foreach ($detects as $detect) {
                $rez .= $column_info->{$detect} . ',';
            }
            return trim($rez, ",");
        }
    }

    private static function detect($key)
    {
        $array = [
            'int' => ['NUMERIC_PRECISION'],
            'binary' => ['NUMERIC_PRECISION'],
            'boolean' => ['NUMERIC_PRECISION'],
            'char' => ['CHARACTER_MAXIMUM_LENGTH'],
            'date' => false,
            'dateTime' => false,
            'dateTimeTz' => false,
            'decimal' => ['NUMERIC_PRECISION', 'NUMERIC_SCALE'],
            'double' => ['NUMERIC_PRECISION', 'NUMERIC_PRECISION'],
            'enum' => 'COLUMN_TYPE',
            'float' => ['NUMERIC_PRECISION', 'NUMERIC_SCALE'],
            'ipAddress' => false,
            'json' => false,
            'jsonb' => false,
            'longText' => false,
            'macAddress' => false,
            'mediumIncrements' => ['NUMERIC_PRECISION'],
            'mediumInteger' => ['NUMERIC_PRECISION'],
            'mediumText' => false,
            'morphs' => false,
            'nullableTimestamps' => false,
            'rememberToken' => false,
            'smallIncrements' => ['NUMERIC_PRECISION'],
            'smallInteger' => ['NUMERIC_PRECISION'],
            'softDeletes' => false,
            'varchar' => ['CHARACTER_MAXIMUM_LENGTH'],
            'text' => false,
            'email' => false,
            'time' => false,
            'timeTz' => false,
            'tinyInteger' => ['NUMERIC_PRECISION'],
            'timestamp' => false,
            'timestampTz' => false,
            'uuid' => false,
        ];
        return isset($array[$key]) ? $array[$key] : false;

    }

    public static function enumer($column_info)
    {
        return (self::before(')', self::after('enum(', $column_info->COLUMN_TYPE)));
    }

    protected static function before($key, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $key));
    }

    protected static function after($key, $inthat)
    {
        if (!is_bool(strpos($inthat, $key)))
            return substr($inthat, strpos($inthat, $key) + strlen($key));
    }

    public static function getDataType($column_info)
    {
        if ($column_info->EXTRA == "auto_increment") {
            return self::increments($column_info->DATA_TYPE, $column_info->NUMERIC_PRECISION);
        }
        if ($column_info->DATA_TYPE == 'varchar') {
            return array_search('string', self::types());
        }
        if ($column_info->DATA_TYPE == 'text') {
            return array_search('text', self::types());
        }
        if ($column_info->DATA_TYPE == 'longtext') {
            return array_search('longText', self::types());
        }
        if ($column_info->DATA_TYPE == 'timestamp') {
            return array_search('timestamp', self::types());
        }
        if ($column_info->DATA_TYPE == 'int') {
            return self::ints($column_info->NUMERIC_PRECISION);
        }
        if ($column_info->DATA_TYPE == 'tinyInteger') {
            return array_search('tinyint', self::types());
        }
    }

    public static function increments($type, $lendt)
    {
        switch ($lendt > 11) {
            case true:
                return array_search('bigIncrements', self::types());
                break;
            case false:
                return array_search('increments', self::types());
                break;
        }
    }

    public static function ints($length)
    {
        if ($length <= 11) {
            return array_search('integer', self::types());
        } else {
            return array_search('bigInteger', self::types());
        }
    }

    public static function deleteColumn($table, $column)
    {
        \Schema::table($table, function ($table) use ($column) {
            $table->dropColumn($column);
        });
    }

    public function seperator($obj)
    {
        if ($obj->Extra == 'auto_increment') {
            $type = $this->editData();
        }
    }

    public function editData()
    {
        $array = [
            'bigIncrements' => [
                'Type' => 'bigint(20) unsigned',
                'Null' => 'NO',
                'Key' => 'PRI',
                'Default' => null,
                'Extra' => 'auto_increment'
            ],
            'bigInteger' => [],
            'binary' => [],
            'boolean' => [],
            'char' => [],
            'date' => [],
            'dateTime' => [],
            'dateTimeTz' => [],
            'decimal' => [],
            'double' => [],
            'enum' => [],
            'float' => [],
            'increments' => [
                'Type' => 'int(10) unsigned',
                'Null' => 'NO',
                'Key' => 'PRI',
                'Default' => null,
                'Extra' => 'auto_increment'
            ],
            'integer' => [],
            'ipAddress' => [],
            'json' => [],
            'jsonb' => [],
            'longText' => [],
            'macAddress' => [],
            'mediumIncrements' => ['default', 'null'],
            'mediumInteger' => [],
            'mediumText' => [],
            'morphs' => [],
            'nullableTimestamps' => [],
            'rememberToken' => [],
            'smallIncrements' => [],
            'smallInteger' => [],
            'softDeletes' => [],
            'string' => [],
            'text' => ['default'],
            'time' => [],
            'timeTz' => [],
            'tinyInteger' => [],
            'timestamp' => [],
            'timestampTz' => [],
            'uuid' => [],
        ];
    }
}