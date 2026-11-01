<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Theme;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(Request $request): View
    {
        $setting = $request->user()->settings ?? UserSetting::firstOrCreate(
            ['user_id' => $request->user()->id],
            [
                'ukuran_font_arab' => 28,
                'tampilkan_latin' => true,
                'tampilkan_terjemahan' => true,
                'tema' => Theme::SISTEM,
            ]
        );

        return view('akun.pengaturan', compact('setting'));
    }

    public function update(UpdateSettingRequest $request)
    {
        $setting = $request->user()->settings ?? new UserSetting(['user_id' => $request->user()->id]);
        $setting->fill($request->validated());
        $setting->save();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pengaturan tampilan berhasil disimpan.',
                'data' => $setting,
            ]);
        }

        return redirect()->route('pengaturan.edit')->with('status', 'Pengaturan berhasil diperbarui.');
    }
}
