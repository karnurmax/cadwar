<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Employee;
use \App\EmployeeFile;

class EmployeesController extends Controller
{
    public function upload(Request $request, $id)
    {
        //public_path()- получение пути к public :)
        $files = $_FILES["files"];
        $fnames = $files["name"];

        $savedFiles = [];
        for ($i = 0; $i < count($fnames); $i++) {
            $tmpPath = $files["tmp_name"][$i];
            $parent = dirname($_SERVER['DOCUMENT_ROOT']);
            $parent .= "\\uploads\\";

            $guid = \App\Helpers\Randomizer::GetString(20);
            mkdir("../uploads/$guid");
            $newPath = "../uploads/$guid/$fnames[$i]";
            $moved = move_uploaded_file($tmpPath, $newPath);
            if (!$moved) {
                continue;
            }
            $empFile = new EmployeeFile;
            $empFile->employee_id = $id;
            $empFile->guid = $guid;
            $empFile->filename = $fnames[$i];
            $empFile->filepath = $newPath;
            $empFile->save();
            array_push($savedFiles, $empFile->toJson());

        }
        return $savedFiles;
    }
    public function removeFile(Request $request, $id)
    {
        $ef = EmployeeFile::findOrFail($id);
        try {
            $removed = unlink(public_path($ef->filepath));
            if ($removed) {
                $ef->delete();
            }
        } catch (Exception $ex) {
            return response($ex->getMessage(), 500);
        }
        return "OK";
    }
    public function getWithFiles()
    {
        return Employee::with('files')->get();
    }
    public function downloadFile(Request $request, $id)
    {
        $ef = EmployeeFile::find($id);

        return response()->download(public_path($ef->filepath));
    }
}
