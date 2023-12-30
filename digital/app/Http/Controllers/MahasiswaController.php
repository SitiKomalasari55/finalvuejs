<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index()
    {
        //get data from table posts
        $mahasiswa = Mahasiswa::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data mahasiswa',
            'data'    => $mahasiswa  
        ], 200);

    }

    public function show($id)
    {
        //find post by ID
        $mahasiswa = Mahasiswa::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data mahasiswa',
            'data'    => $mahasiswa
        ], 200);

    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required',
        ]);
        
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $mahasiswa = Mahasiswa::create([
            'nama'     => $request->nama,
            'jurusan'   => $request->jurusan,
            'angkatan'   => $request->angkatan
        ]);

        //success save to database
        if($mahasiswa) {

            return response()->json([
                'success' => true,
                'message' => 'Mahasiwa berhasil di Tambahkan',
                'data'    => $mahasiswa 
            ], 201);

        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Mahasiswa Gagal di Tambahkan',
        ], 409);

    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $mahasiswa = Mahasiswa::findOrFail($mahasiswa->id);

        if($mahasiswa) {

            //update post
            $mahasiswa->update([
                'nama'     => $request->nama,
                'jurusan'   => $request->jurusan,
                'angkatan'   => $request->angkatan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa di Perbaharui',
                'data'    => $mahasiswa 
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Mahasiswa Tidak ada',
        ], 404);

    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find post by ID
        $mahasiswa = Mahasiswa::findOrfail($id);

        if($mahasiswa) {

            //delete post
            $mahasiswa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa Di Hapus',
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Mahasiswa Tidak ada',
        ], 404);
    }
}

