<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // Form tambah jadwal
    public function create()
    {
        return view('admin.schedules.create');
    }

    // Simpan jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'plane_name' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure' => 'required|date',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Schedule::create($request->all());
        return redirect('/dashboard')->with('success', 'Jadwal penerbangan baru berhasil ditambahkan!');
    }

    // Form edit jadwal
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('admin.schedules.edit', compact('schedule'));
    }

    // Update jadwal
    public function update(Request $request, $id)
    {
        $request->validate([
            'plane_name' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure' => 'required|date',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());
        return redirect('/dashboard')->with('success', 'Jadwal "' . $schedule->plane_name . '" berhasil diperbarui!');
    }

    // Hapus jadwal
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $name = $schedule->plane_name;
        $schedule->delete();
        return redirect('/dashboard')->with('success', 'Jadwal "' . $name . '" berhasil dihapus.');
    }
}