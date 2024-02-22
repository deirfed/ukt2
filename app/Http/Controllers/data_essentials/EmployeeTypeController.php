<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\EmployeeType;
use Illuminate\Http\Request;

class EmployeeTypeController extends Controller
{
    public function index()
    {
        $employee_type = EmployeeType::all();
        return view('admin.masterdata.data_essentials.employee_type.index', compact(['employee_type']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.employee_type.create');
    }

    public function store(Request $request)
    {
        EmployeeType::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return redirect()->route('employee-type.index')->withNotify('Data berhasil ditambah!');
    }

    public function show(string $uuid)
    {
        $employee_type = EmployeeType::where('uuid', $uuid)->first();
        if(!$employee_type)
        {
            return back()->withNotifyerror('Something went wrong!');
        }
        return view('admin.masterdata.data_essentials.employee_type.edit', compact(['employee_type']));
    }

    public function edit(string $uuid)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $employee_type = EmployeeType::findOrFail($id);
        $employee_type->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return redirect()->route('employee-type.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $employee_type = EmployeeType::findOrFail($request->id);
        $employee_type->delete();
        return redirect()->route('employee-type.index')->withNotify('Data berhasil dihapus!');
    }
}
