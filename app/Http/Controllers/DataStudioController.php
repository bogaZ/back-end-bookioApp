<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\ImageStudio;
use App\Models\Studio;
use Illuminate\Http\Request;

class DataStudioController extends Controller
{
    //
    public function index(){
        return view('dataStudio',[
            'title' => 'Data Studio',
            'studios' => Studio::all(),
        ]);
    }

    public function detailMyStudio($id){
        return view('detailStudio',[
            'title' => 'Detail Studio',
            'studio' => Studio::all()->find($id),
            'fasilitas' => Fasilitas::all()->where('studio_id',$id),
            'foto_studios' => ImageStudio::all()->where('studio_id',$id),
        ]);
    }

    public function updateStatusTerverifikasi(Request $request, $id){
        $validateData = $request->validate([]);

        $validateData['status_tempat'] = 'Terverifikasi';

        $validateData['status_transaksi'] = 'Aktif';
        
        Studio::all()->find($id)->update($validateData);

        return redirect("/detailStudio/".$id);
    }

    public function updateStatusBelumTerverifikasi(Request $request, $id){
        $validateData = $request->validate([]);

        $validateData['status_tempat'] = 'Belum Terverifikasi';

        $validateData['status_transaksi'] = 'Nonaktif';
        
        Studio::all()->find($id)->update($validateData);

        return redirect("/detailStudio/".$id);
    }

    public function updateTransaksiNonaktif(Request $request, $id){
        $validateData = $request->validate([]);

        $validateData['status_transaksi'] = 'Nonaktif';

        $validateData['status_tempat'] = 'Belum Terverifikasi';
        
        Studio::all()->find($id)->update($validateData);

        return redirect("/detailStudio/".$id);
    }

    public function updateTransaksiAktif(Request $request, $id){
        $validateData = $request->validate([]);

        $validateData['status_transaksi'] = 'Aktif';

        $validateData['status_tempat'] = 'Terverifikasi';
        
        Studio::all()->find($id)->update($validateData);

        return redirect("/detailStudio/".$id);
    }
}
