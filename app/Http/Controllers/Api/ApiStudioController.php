<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiJadwalController;
use App\Http\Controllers\Controller;
use App\Models\ImageStudio;
use App\Models\Studio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiStudioController extends Controller
{
    public function create(Request $request)
    {
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $check = Studio::all()->firstWhere('user_id', $user_id);
        if ($check !=  null) {
            return response()->json([
                'message' => 'Anda sudah menambahkan Studio!',
            ]);
        }
        $request['user_id'] = $user_id;
        $validateData = $request->validate([
            'user_id' => 'required|unique:studios',
            'nama_studio' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'tarif_minimal' => 'required',
            'tarif_maksimal' => 'required'
        ]);
        Studio::create($validateData);
        $apiJadwalController = new ApiJadwalController();
        $apiJadwalController->add($request);
        return response()->json([
            'success' => true,
            'data' => $user->studio,
            'message' => 'Studio berhasil ditambahkan',
        ]);
    }

    public function show()
    {
        $idUser = auth()->user()->id;
        $user = auth()->user();
        $check = Studio::all()->firstWhere('user_id', $idUser);
       
        
        if ($check == null) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum menambahkan Studio!',
            ]);
        }
        $data = Studio::all()->firstWhere('user_id', $idUser);
        if(ImageStudio::all()->where('studio_id',  $check->id ) == null){
            return response()->json([
                'success' => true,
                'data' => $data,
                'image_data' => [],
                'fasilitas' => Studio::all()->firstWhere('user_id', $idUser)->fasilitas,
                'jadwal' => Studio::all()->firstWhere('user_id', $idUser)->jadwal
                
            ]);
        }else{
            $imageStudio = $user->studio->imageStudio;
            return response()->json([
                'success' => true,
                'data' => $data,
                'image_data' => $imageStudio,
                'fasilitas' => Studio::all()->firstWhere('user_id', $idUser)->fasilitas,
                'jadwal' => Studio::all()->firstWhere('user_id', $idUser)->jadwal
                
            ]);
        }
        
    }

    

    public function update(Request $request)
    {

        $idUser = auth()->user()->id;

        $check = Studio::all()->firstWhere('user_id', $idUser);

        if ($check == null) {
            return response()->json([
                'message' => 'Belum menambahkan Studio!',
            ]);
        }
        $validateData = $request->validate([
            'nama_studio' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'tarif_minimal' => 'required',
        ]);

        Studio::all()->firstWhere('user_id', $idUser)->update($validateData);
        return response()->json([
            'success' => true,
            'data' => auth()->user()->studio,
            'message' => 'Update data berhasil!',
        ]);
    }

    // GET all STUDIO yg sudah terverifikasi
    public function allStudio(){
        $studio = Studio::all();
        
            return response()->json([
                'success' => true,
                'data' => $studio,
                'image_data' => ImageStudio::all()
            ]);
        
        
    }

    // GET all STUDIO
    public function allShow(){
        $studio = Studio::all();
        return response()->json([
            'success' => true,
            'data' => $studio,
            'image_data' => ImageStudio::all()
        ]);
    }

    // GET Detail studio
    public function showDetail($id){
        $studio = Studio::all()->find($id);
        $jadwal = $studio->jadwal;
        $fasilitas = $studio->fasilitas;
        return response()->json([
            'success' => true,
            'studio' => Studio::all()->find($id),
            'jadwal' => $jadwal,
            'fasilitas' => $fasilitas,
            'image_data' => $studio->imageStudio
        ]);
    }

    // Add image studio
    public function addImage(Request $request){
        $user = auth()->user();
        $studio = $user->studio;

        $validateData = $request->validate([
            'studio_id' => 'required',
            'image' => 'required|image',
        ]);
        
        $validateData['image'] = $request->file('image')->store('foto-studio');
        ImageStudio::create($validateData);

        return response()->json([
            'success' => true,
            'data' => $validateData['image'],
        ]);
        

    }

    public function deleteImage($id){
        $user = auth()->user();
        $studio = $user->studio;
        $imageStudio = $studio->imageStudio->find($id);
        Storage::delete($imageStudio->image);
        $imageStudio->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus image sukses',
        ]);
    }
}
