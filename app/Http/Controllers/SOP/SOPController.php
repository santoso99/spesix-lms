<?php

namespace App\Http\Controllers\SOP;

use App\Http\Controllers\Controller;
use App\StandardOperationProcedure;
use App\Http\Requests\SOPFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SOPController extends Controller
{

    public function index()
    {
        $sops = StandardOperationProcedure::with('user')->get();

        return view('admin.sop.index', compact('sops'));
    }

    public function store(SOPFormRequest $request)
    {
        $this->completeRequestData($request);
        StandardOperationProcedure::create($request->all());

        return redirect('admin/sops')->with('status', __('messages.sop_file_created'));
    }

    public function edit(StandardOperationProcedure $sop)
    {
        return view('admin.sop.edit', compact('sop'));
    }

    public function update(SOPFormRequest $request, StandardOperationProcedure $sop)
    {
        if($request->file != null)
        {
            if($sop->file_path != null){
                Storage::delete($sop->file_path);
            }
    
            $this->completeRequestData($request);
        }

        $sop->update($request->all());
        return redirect('admin/sops')->with('status',__('messages.sop_file_updated'));
    }

    public function destroy(Request $request)
    {
        $sop_ids = $request->sop_id;
        if($sop_ids == null){
            return back();
        }

        $file_path = StandardOperationProcedure::whereIn('id', $sop_ids)->pluck('file_path')->all();

        for($i=0;$i<count($file_path);$i++)
        {
            if($file_path[$i] != null)
            {
                Storage::delete($file_path[$i]);
            }
        }

        StandardOperationProcedure::whereIn('id', $sop_ids)->delete();

        return redirect('/admin/sops')->with('status', __('messages.sop_file_deleted'));
    }

    private function completeRequestData(SOPFormRequest $request)
    {
        $file_path = $this->getUploadedPath($request);
        
        $request->request->add([
            'file_path' => $file_path,
            'user_id' => Auth::id(),
        ]);
    }

    private function getUploadedPath(SOPFormRequest $request)
    {
        $sop = $request->validated()['file'];
        $ext = $sop->extension();
        $name = pathinfo($sop->getClientOriginalName(), PATHINFO_FILENAME).'-'.uniqid().'.'.$ext;
        $file_path = $sop->storeAs('uploads/sop-files', $name);

        return $file_path;
    }

}
