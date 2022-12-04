<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Studio;
use Illuminate\Http\Request;

class ApiJadwalController extends Controller
{
    // MENAMPILKAN JADWAL
    public function show(){
        $user = auth()->user();
        $jadwal = $user->studio->jadwal;
        return $jadwal;
    }

    // MENAMBAH JADWAL OPERASIONAL
    public function add(Request $request){
        $hari = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        $request['studio_id'] = auth()->user()->studio->id;
        $validateData = $request->validate([
            'studio_id' => 'required|integer',
        ]);
        for($i=0;$i < count($hari);$i++){
            $validateData['nama_hari'] = $hari[$i];
            Jadwal::create($validateData);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan Jadwal!',
        ]);
    }

    // EDIT JADWAL OPERASIONAL
    public function edit(Request $request,$id){
        $user = auth()->user();
        $studio = Studio::all()->firstWhere('user_id',$user->id);
        $validateData = $request->validate([
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'status' => 'required',
        ]);
        Jadwal::all()->where('studio_id',$studio->id)->find($id)->update($validateData);
        return response()->json([
            'success' => true,
            'data' => Jadwal::all()->where('studio_id',$studio->id)->find($id),
            'message' => 'Update successfully!',
        ]);
    }
}
