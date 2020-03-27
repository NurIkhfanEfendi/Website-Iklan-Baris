<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Iklan;   
use Illuminate\Support\Facades\Validator;

class IklanController extends Controller
{
    public function index()
    {
        try{
	        $data["count"] = Iklan::count();
	        $iklan = array();

	        foreach (Iklan::all() as $p) {
	            $item = [
	                "id"          => $p->id,
	                "judul"       => $p->judul,
	                "harga"       => $p->harga,
                    "deskripsi"   => $p->deskripsi,
                    "foto"    	  => $p->foto,
	                "created_at"  => $p->created_at,
	                "updated_at"  => $p->updated_at
	            ];

	            array_push($iklan, $item);
	        }
	        $data["iklan"] = $iklan;
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }
    public function getAll($limit = 10, $offset = 0)
    {
    	try{
	        $data["count"] = Iklan::count();
	        $iklan = array();

	        foreach (Iklan::take($limit)->skip($offset)->get() as $p) {
	            $item = [
	                "id"          => $p->id,
	                "judul"       => $p->judul,
	                "harga"       => $p->harga,
                    "deskripsi"   => $p->deskripsi,
                    "foto"    	  => $p->foto,
	                "created_at"  => $p->created_at,
	                "updated_at"  => $p->updated_at
	            ];

	            array_push($iklan, $item);
	        }
	        $data["iklan"] = $iklan;
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }
    public function store(Request $request)
    {
        try{
    		$validator = Validator::make($request->all(), [
    			'judul'      => 'required|string|max:255',
				'harga'		 => 'required|string|max:255',
                'deskripsi'	 => 'required|string|max:255',
                'foto'       => 'required|string',
    		]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
    		}

    		$data = new Iklan();
	        $data->judul = $request->input('judul');
	        $data->harga = $request->input('harga');
	        $data->deskripsi = $request->input('deskripsi');
	        $data->foto = $request->input('foto');
	        $data->save();

    		return response()->json([
    			'status'	=> '1',
    			'message'	=> 'Data iklan berhasil ditambahkan!'
    		], 201);

        } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'judul'      => 'required|string|max:255',
				'harga'		 => 'required|string|max:255',
                'deskripsi'	 => 'required|string|max:255',
                'foto'       => 'required|string',
            ]);
  
            if($validator->fails()){
                return response()->json([
                    'status'	=> '0',
                    'message'	=> $validator->errors()
                ]);
            }
  
            //proses update data
            $data = Iklan::where('id', $id)->first();
            $data->judul = $request->input('judul');
	        $data->harga = $request->input('harga');
	        $data->deskripsi = $request->input('deskripsi');
	        $data->foto = $request->input('foto');
            $data->save();
  
            return response()->json([
                'status'	=> '1',
                'message'	=> 'Data iklan berhasil diubah'
            ]);
          
        } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
    }
    public function destroy($id)
    {
        try{

            $delete = Iklan::where("id", $id)->delete();

            if($delete){
              return response([
              	"status"	=> 1,
                  "message"   => "Data iklan berhasil dihapus."
              ]);
            } else {
              return response([
                "status"  => 0,
                  "message"   => "Data iklan gagal dihapus."
              ]);
            }
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }
}
