<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Employee;
use \App\EmployeeFile;

class EmployeesController extends Controller
{
    public function upload(Request $request, $iin)
    {
        //public_path()- получение пути к public :)
        if (!isset($_FILES["files"])) {
            return [];
        }
        $files = $_FILES["files"];
        $fnames = $files["name"];

        $savedFiles = [];
        $folderToUpload = "../uploads/$iin";
        if (!file_exists($folderToUpload)) {
            mkdir($folderToUpload, 0777, true);
        }
        for ($i = 0; $i < count($fnames); $i++) {
            $tmpPath = $files["tmp_name"][$i];

            $newPath = "$folderToUpload/$fnames[$i]";
            $moved = move_uploaded_file($tmpPath, $newPath);
            if (!$moved) {
                continue;
            }
            $empFile = new EmployeeFile;
            $empFile->iin = $iin;
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
            $removed = unlink(public_path($ef->guid));
            if ($removed) {
                $ef->delete();
            }
        } catch (Exception $ex) {
            return response($ex->getMessage(), 500);
        }
        return "OK";
    }

    public function removeFileList(Request $request)
    {
        $data = $request->all();
        $ids = $data["ids"];
        $efList = EmployeeFile::whereIn('id', $ids)->get();
        foreach ($efList as $ef) {
            $removed = unlink(public_path($ef->filepath));
            $ef->delete();
        }
        return "OK";
    }

    public function getWithFiles()
    {
        return Employee::with('files')->with('citizenships')->with('positions')->with('statuses')->get();
    }
    public function downloadFile(Request $request, $id)
    {
        $ef = EmployeeFile::find($id);

        return response()->download(public_path($ef->filepath));
    }
}
