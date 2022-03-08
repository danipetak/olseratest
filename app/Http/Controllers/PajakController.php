<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PajakController extends Controller
{
    public function index(Request $request)
    {
        $data   =   Item::where(function($query) use ($request) {
                        if ($request->id) {
                            $query->where('id', $request->id) ;
                        }
                    })
                    ->get() ;

        $arr    =   [] ;
        foreach ($data as $row) {
            $arr[]  =   [
                'id'    =>  $row->id,
                'nama'  =>  $row->nama,
                'pajak' =>  $row->pajak
            ] ;
        }

        if (COUNT($data)) {
            $result['data'] =   $arr ;
        } else {
            $result['data'] =   'Data tidak ditemukan' ;
        }

        return response()->json($result, 200) ;
    }


    public function store(Request $request)
    {
        // Proses tambah data item
        if ($request->add_data  == 'item') {
            if (!$request->nama) {
                $result['status']   =   400 ;
                $result['message']  =   'Nama tidak boleh kosong' ;
                return response()->json($result, $result['status']);
            }

            DB::beginTransaction() ;

            $item           =   new Item ;
            $item->nama     =   $request->nama ;
            if (!$item->save()) {
                $result['status']   =   400;
                $result['message']  =   'Proses gagal';
                return response()->json($result, $result['status']);
            }

            DB::commit() ;

            $result['status']   =   200;
            $result['message']  =   'Tambah item berhasil';
            $result['data']     =   $item ;
            return response()->json($result, $result['status']);
        } else

        // Proses tambah data pajak
        if ($request->add_data  == 'pajak') {
            if (!$request->id_item) {
                $result['status']   =   400;
                $result['message']  =   'Item ID tidak boleh kosong';
                return response()->json($result, $result['status']);
            }

            $item   =   Item::find($request->id_item) ;
            if (!$item) {
                $result['status']   =   400;
                $result['message']  =   'Item ID tidak ditemukan';
                return response()->json($result, $result['status']);
            }

            if (!$request->nama) {
                $result['status']   =   400;
                $result['message']  =   'Nama pajak tidak boleh kosong';
                return response()->json($result, $result['status']);
            }

            if (!$request->rate) {
                $result['status']   =   400;
                $result['message']  =   'Rate tidak boleh kosong';
                return response()->json($result, $result['status']);
            }

            DB::beginTransaction() ;

            $pajak              =   new Pajak ;
            $pajak->item_id     =   $item->id ;
            $pajak->nama        =   $request->nama ;
            $pajak->rate        =   $request->rate ;
            if (!$pajak->save()) {
                $result['status']   =   400;
                $result['message']  =   'Proses gagal';
                return response()->json($result, $result['status']);
            }

            DB::commit();

            $result['status']   =   200;
            $result['message']  =   'Tambah pajak berhasil';
            $result['data']     =   $pajak;
            return response()->json($result, $result['status']);

        } else {
            // Jika field add_data tidak diisikan
            $result['status']   =   400;
            $result['message']  =   'Proses gagal';
            return response()->json($result, $result['status']);
        }
    }


    public function update(Request $request)
    {
        // Proses ubah data item
        if ($request->update_data  == 'item') {
            if (!$request->id_item) {
                $result['status']   =   400 ;
                $result['message']  =   'Item ID tidak boleh kosong' ;
                return response()->json($result, $result['status']);
            }

            $item   =   Item::find($request->id_item) ;
            if (!$item) {
                $result['status']   =   400;
                $result['message']  =   'Item ID tidak ditemukan';
                return response()->json($result, $result['status']);
            }

            if (!$request->nama) {
                $result['status']   =   400 ;
                $result['message']  =   'Nama tidak boleh kosong' ;
                return response()->json($result, $result['status']);
            }

            DB::beginTransaction() ;

            $item->nama     =   $request->nama ;
            if (!$item->save()) {
                $result['status']   =   400;
                $result['message']  =   'Proses gagal';
                return response()->json($result, $result['status']);
            }

            DB::commit() ;

            $result['status']   =   200;
            $result['message']  =   'Ubah data item berhasil';
            $result['data']     =   $item ;
            return response()->json($result, $result['status']);
        } else

        // Proses ubah data pajak
        if ($request->update_data  == 'pajak') {
            if (!$request->id_pajak) {
                $result['status']   =   400;
                $result['message']  =   'Pajak ID tidak boleh kosong';
                return response()->json($result, $result['status']);
            }

            $pajak  =   Pajak::find($request->id_pajak) ;
            if (!$pajak) {
                $result['status']   =   400;
                $result['message']  =   'Pajak ID tidak ditemukan';
                return response()->json($result, $result['status']);
            }

            if (!$request->nama) {
                $result['status']   =   400;
                $result['message']  =   'Nama pajak tidak boleh kosong';
                return response()->json($result, $result['status']);
            }

            if (!$request->rate) {
                $result['status']   =   400;
                $result['message']  =   'Rate tidak boleh kosong';
                return response()->json($result, $result['status']);
            }

            DB::beginTransaction() ;

            $pajak->nama        =   $request->nama ;
            $pajak->rate        =   $request->rate ;
            if (!$pajak->save()) {
                $result['status']   =   400;
                $result['message']  =   'Proses gagal';
                return response()->json($result, $result['status']);
            }

            DB::commit();

            $result['status']   =   200;
            $result['message']  =   'Ubah data pajak berhasil';
            $result['data']     =   $pajak;
            return response()->json($result, $result['status']);

        } else {
            // Jika field update_data tidak diisikan
            $result['status']   =   400;
            $result['message']  =   'Proses gagal';
            return response()->json($result, $result['status']);
        }
    }


    public function destroy(Request $request)
    {
        // Proses ubah data item
        if ($request->hapus_data  == 'item') {
            if (!$request->id_item) {
                $result['status']   =   400 ;
                $result['message']  =   'Item ID tidak boleh kosong' ;
                return response()->json($result, $result['status']);
            }

            $item   =   Item::find($request->id_item) ;
            if (!$item) {
                $result['status']   =   400;
                $result['message']  =   'Item ID tidak ditemukan';
                return response()->json($result, $result['status']);
            }

            $item->delete() ;

            $result['status']   =   200;
            $result['message']  =   'Hapus data item berhasil';
            $result['data']     =   $item ;
            return response()->json($result, $result['status']);
        } else

        // Proses ubah data pajak
        if ($request->hapus_data  == 'pajak') {
            if (!$request->id_pajak) {
                $result['status']   =   400;
                $result['message']  =   'Pajak ID tidak boleh kosong';
                return response()->json($result, $result['status']);
            }

            $pajak  =   Pajak::find($request->id_pajak) ;
            if (!$pajak) {
                $result['status']   =   400;
                $result['message']  =   'Pajak ID tidak ditemukan';
                return response()->json($result, $result['status']);
            }

            $pajak->delete() ;

            $result['status']   =   200;
            $result['message']  =   'Hapus data pajak berhasil';
            $result['data']     =   $pajak;
            return response()->json($result, $result['status']);

        } else {
            // Jika field hapus_data tidak diisikan
            $result['status']   =   400;
            $result['message']  =   'Proses gagal';
            return response()->json($result, $result['status']);
        }
    }
}
