<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    public function destroy(Request $request)
    {
        if($request->ajax())
        {
            try {
                Storage::delete($request->file_path);

                $changes = [
                    $request->field => null
                ];

                if($request->table == "tasks"){
                    array_push($changes, ['attachment_filename' => null]);
                }

                DB::table($request->table)
                    ->where('id',$request->id)
                    ->update($changes);

                return response()->json(['success' => true]);
            } catch (\Throwable $th) {
                return response()->json(['error' => $th]);
            }
        }
    }
}
