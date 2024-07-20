<?php

namespace App\Http\Controllers;

use App\Models\StandarIsi;
use App\Models\StandarKompetensiLulusan;
use App\Models\StandarPembiayaan;
use App\Models\StandarPendidikDanTenpen;
use App\Models\StandarPengelolaan;
use App\Models\StandarPenilaian;
use App\Models\StandarProses;
use App\Models\StandarSaranaDanPra;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $model_name = $request->input('model_name');

        $models = [
            'StandarIsi' => StandarIsi::class,
            'StandarKompetensiLulusan' => StandarKompetensiLulusan::class,
            'StandarPembiayaan' => StandarPembiayaan::class,
            'StandarPendidikDanTenpen' => StandarPendidikDanTenpen::class,
            'StandarPengelolaan' => StandarPengelolaan::class,
            'StandarPenilaian' => StandarPenilaian::class,
            'StandarProses' => StandarProses::class,
            'StandarSaranaDanPra' => StandarSaranaDanPra::class
        ];

        $reports = collect();

        if ($model_name && isset($models[$model_name])) {
            $query = $models[$model_name]::query();
            if ($user_id) {
                $query->where('user_id', $user_id);
            }
            $reports = $query->with('user')->get();
        } else {
            foreach ($models as $model) {
                $query = $model::query();
                if ($user_id) {
                    $query->where('user_id', $user_id);
                }
                $data = $query->with('user')->get();
                $reports = $reports->concat($data);
            }
        }

        $users = User::all();

        return view('pageadmin.laporan.index', compact('reports', 'users', 'user_id', 'model_name', 'models'));
    }
}
