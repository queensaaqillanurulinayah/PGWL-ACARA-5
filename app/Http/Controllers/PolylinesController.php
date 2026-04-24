<?php

namespace App\Http\Controllers;

use App\Models\polylinesModel;
use Illuminate\Http\Request;

class PolylinesController extends Controller
{
    protected $polylines;

    public function __construct()
    {
        $this->polylines = new polylinesModel();
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
                'geometry_polyline' => 'required',
                'nama' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'geometry_polyline.required' => 'Field geometry polyline harus diisi.',
                'nama.required' => 'Field nama harus diisi.',
                'nama.string' => 'Field nama harus berupa string.',
                'nama.max' => 'Field nama tidak boleh lebih dari 255 karakter.',
                'image.image' => 'File harus berupa gambar!',
                'image.mimes' => 'Format gambar tidak valid!',
                'image.max' => 'Ukuran gambar terlalu besar!',
            ]
        );

        //Create directory for images if it doesn't exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        //Get the upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geometry_polyline,
            'nama' => $request->nama,
            'description' => $request->description,
            'image' => $name_image,
        ];

        $this->polylines->create($data);
        if (!$this->polylines->create($data)) {
            return redirect()->route('peta')->with('error', 'Gagal menyimpan data polyline.');
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
