<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return Doctor::all();
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'speciality' => 'required'
        ]);


       // image uploading

        $image =  $request->image;
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('upload'),$imageName);

        Doctor::create([
            'image' => $imageName,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'speciality' => $request->speciality
        ]);

        return response('Data Stored', status:200);
    }


    public function show(Doctor $doctor)
    {
        return $doctor;
    }


    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'speciality' => 'required'
        ]);

        if($request->image) {
            $image = $request->image;
            $imgName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload'), $imgName);

            $doctor->update([
                'image' => $imgName,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'speciality' => $request->speciality
            ]);
            return response('Data Updated', status:204);
        } else {
            $doctor->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'speciality' => $request->speciality
            ]);
            return response('Data Updated', status:204);
        }

    }


    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return response('Data Deleted', status:204);
    }
}
