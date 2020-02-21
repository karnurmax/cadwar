<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadDbController extends Controller
{
    public function csv(Request $request)
    {
        if (isset($_FILES["files"]["tmp_name"][0])) {
            $filepath = $_FILES["files"]["tmp_name"][0];
            $lines = file($filepath);
            $data = [];
            foreach ($lines as $l) {
                $r = $this->getValuesArray($l);
                $iin = $r[2];
                if (preg_match('/^\d{12}$/', $iin) != 1) {
                    continue;
                }

                $fio = $r[1];
                $position = $r[3];
                $citizenship = $r[4];
                $status = $r[5];
                $phone = $r[6];
                $dateOfEmployment = $r[7];
                $dateOfDismissal = $r[8];
                $reasonForDismissal = $r[9];
                $comments = $r[10];
                $fio = array_filter(explode(' ', $fio));
                $e = [];
                $e["name"] = isset($fio[1]) ? $fio[1] : '';
                $e["surname"] = isset($fio[0]) ? $fio[0] : '';
                $e["lastname"] = isset($fio[2]) ? $fio[2] : '';
                $e["iin"] = $iin;
                $e['position'] = isset($position) ? $position : '';
                $e['citizenship'] = isset($citizenship) ? $citizenship : '';
                $e['status'] = isset($status) ? $status : '';
                $e['phone'] = isset($phone) ? $phone : '';
                $e['dateOfEmployment'] = strlen($dateOfEmployment) > 0 ? $dateOfEmployment : null;
                $e['dateOfDismissal'] = strlen($dateOfDismissal) > 0 ? $dateOfDismissal : null;
                $e['reasonForDismissal'] = isset($reasonForDismissal) ? $reasonForDismissal : '';
                $e['comments'] = isset($comments) ? $comments : '';
//5     6    Дата приема     Дата увольнения     Причина увольнения     Комментарии
                array_push($data, $e);
            }
            array_shift($data);
            $this->insertOrUpdate($data, "employees");

            return $data;
        } else {
            return 0;
        }
    }
    private function getValuesArray($row)
    {
        $vals = [];
        while (strlen($row) > 0) {
            if ($row[0] === '"') {
                $idx = strpos($row, '",');
                if ($idx < 0) {
                    array_push($vals, $row);
                    return $vals;
                }
                array_push($vals, substr($row, 1, $idx));
                $row = substr($row, $idx + 2);
            } else {
                $idx = strpos($row, ',');
                if ($idx < 0) {
                    array_push($vals, $row);
                    return $vals;
                }
                array_push($vals, substr($row, 0, $idx));
                $row = substr($row, $idx + 1);
            }
        }
        return $vals;
    }
    private function insertOrUpdate(array $rows, $table)
    {
        $first = reset($rows);

        $columns = implode(',',
            array_map(function ($value) {return "$value";}, array_keys($first))
        );

        $values = implode(',', array_map(function ($row) {
            return '(' . implode(',',
                array_map(function ($value) {return '"' . str_replace('"', '""', $value) . '"';}, $row)
            ) . ')';
        }, $rows)
        );

        $updates = implode(',',
            array_map(function ($value) {return "$value = VALUES($value)";}, array_keys($first))
        );

        $sql = "INSERT INTO {$table}({$columns}) VALUES {$values} ON DUPLICATE KEY UPDATE {$updates}";
        $sql = str_replace("'null'", "null", $sql);
        $sql = str_replace('""', 'null', $sql);
        return \DB::statement($sql);
    }
}
