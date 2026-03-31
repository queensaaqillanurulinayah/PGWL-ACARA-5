<?php

namespace App\Http\Controllers;

use App\Models\polygonsModel;
use Illuminate\Http\Request;

class PolygonsController extends Controller
{

    protected $polygons;

    public function __construct()
    {
        $this->polygons = new polygonsModel();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'geometry_polygon' => 'required',
                'nama' => 'required|string|max:255',
            ],
            [
                'geometry_polygon.required' => 'Field geometry polygon harus diisi.',
                'nama.required' => 'Field nama harus diisi.',
                'nama.string' => 'Field nama harus berupa string.',
                'nama.max' => 'Field nama tidak boleh lebih dari 255 karakter.',
            ]
        );
        $data = [
            'geom' => $request->geometry_polygon,
            'nama' => $request->nama,
            'description' => $request->description,
        ];

        $this->polygons->create($data);
        if (!$this->polygons->create($data)) {
            return redirect()->route('peta')->with('error', 'Gagal menyimpan data
    polygon.');
        }

        return redirect()->route('peta')->with('success', 'Berhasil menyimpan data
    disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
