<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Studio;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    // METHOD MENAMPILKAN SEMUA FASILITAS YANG DIMILIKI
    public function show()
    {
        $studio = auth()->user()->studio;
        if ($studio == null) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum menambahkan Studio!',
            ]);
        }
        $data = $studio->fasilitas;
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    // METHOD MENAMPILKAN DETAIL FASILITAS YANG DIMILIKI
    public function detail($id)
    {   
        $user = auth()->user();
        $studio = $user->studio; 
        //return Fasilitas::all()->where('studio_id',$studio->id)->firstWhere('id',$id);
        return $studio->fasilitas;
   
    }

    // METHOD MENAMBAHKAN FASILITAS
    public function add(Request $request)
    {
        $user_id = auth()->user()->id;
        $studio = Studio::all()->firstWhere('user_id', $user_id);
        if ($studio == null) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum menambahkan Studio!',
            ]);
        }
        $studio_id = $studio->id;
        $request['studio_id'] = $studio_id;
        $validateData = $request->validate([
            'studio_id' => 'required',
            'nama_fasilitas' => 'required',
            'tarif' => 'required|integer',
        ]);
        Fasilitas::create($validateData);
        return response()->json([
            'success' => true,
            'fasilitas' => $studio->fasilitas,
            'message' => 'Fasilitas berhasil ditambahkan!',
        ]);
    }

    // METHOD MENGUODATE FASILITAS YANG DIMILIKI
    public function update(Request $request,$id)
    {
        $user = auth()->user();
        $studio = $user->studio;
        //$fasilitas = Fasilitas::all()->where('studio_id',$studio->id)->firstWhere('id',$id);
        $fasilitas = $studio->fasilitas->find($id);
        $request['studio_id'] = $studio->id;
        $validateData = $request->validate([
            'studio_id' => 'required',
            'nama_fasilitas' => 'required',
            'tarif' => 'required',
        ]);
        $fasilitas->update($validateData);
        Fasilitas::all()->where('studio_id',$studio->id)->firstWhere('id',$id);
        return response()->json([
            'success' => true,
            'data' => Fasilitas::all()->where('studio_id',$studio->id)->firstWhere('id',$id),
            'message' => 'Update Successfully!'
        ]);

    }

    // MENGHAPUS FASILITAS YANG DIMILIKI
    public function delete($id)
    {
        $user = auth()->user();
        //Fasilitas::all()->where('studio_id', $user->studio->id)->find($id)->delete();
        $user->studio->fasilitas->find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete Successfully!'
        ]);
    }
}
