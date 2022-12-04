<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
     // METHODD NOTIFIKASI OTOMATIS SAAT BERHASIL MELAKUKAN PEMESANAN
     public function sendNotification(Request $request, $user, $judul,$deskripsi,$link)
     {
         $request['user_id'] = $user->id;
         $request['judul'] = $judul;
         $request['deskripsi'] = $deskripsi;
         $request['link'] = $link;
         $validateData = $request->validate([
             'user_id' => 'required',
             'judul' => 'required',
             'deskripsi' => 'required',
             'link' => 'required',
         ]);
         Notification::create($validateData);
     }
}
