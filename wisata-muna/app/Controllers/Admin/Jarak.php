<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Jarak extends BaseController
{
    private function semuaNode(): array
    {
        return db_connect()->table('node')->orderBy('kode_node')->get()->getResultArray();
    }

    public function index()
    {
        $rows = db_connect()->table('jarak j')
            ->select('j.id, a.kode_node AS kode_asal, a.nama_node AS nama_asal, t.kode_node AS kode_tujuan, t.nama_node AS nama_tujuan, j.jarak')
            ->join('node a', 'a.id = j.id_node_asal')
            ->join('node t', 't.id = j.id_node_tujuan')
            ->orderBy('j.id')
            ->get()->getResultArray();

        return view('admin/jarak_index', ['rows' => $rows]);
    }

    public function create()
    {
        return view('admin/jarak_form', [
            'row' => null, 'nodes' => $this->semuaNode(),
            'action' => '/admin/jarak/store', 'judul' => 'Tambah Jarak',
        ]);
    }

    public function store()
    {
        return $this->simpan(0);
    }

    public function edit($id)
    {
        $row = db_connect()->table('jarak')->where('id', $id)->get()->getRowArray();
        if (! $row) {
            return redirect()->to('/admin/jarak')->with('error', 'Data tidak ditemukan.');
        }
        return view('admin/jarak_form', [
            'row' => $row, 'nodes' => $this->semuaNode(),
            'action' => '/admin/jarak/update/' . $id, 'judul' => 'Ubah Jarak',
        ]);
    }

    public function update($id)
    {
        return $this->simpan((int) $id);
    }

    public function delete($id)
    {
        db_connect()->table('jarak')->where('id', $id)->delete();
        return redirect()->to('/admin/jarak')->with('success', 'Jarak berhasil dihapus.');
    }

    private function simpan(int $id)
    {
        $rules = [
            'id_node_asal'   => 'required|is_natural_no_zero',
            'id_node_tujuan' => 'required|is_natural_no_zero|differs[id_node_asal]',
            'jarak'          => 'required|numeric|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $a = (int) $this->request->getPost('id_node_asal');
        $t = (int) $this->request->getPost('id_node_tujuan');

        // cegah sisi ganda (A-B dan B-A dianggap sama karena graf tidak berarah)
        $cek = db_connect()->table('jarak')
            ->groupStart()
                ->groupStart()->where('id_node_asal', $a)->where('id_node_tujuan', $t)->groupEnd()
                ->orGroupStart()->where('id_node_asal', $t)->where('id_node_tujuan', $a)->groupEnd()
            ->groupEnd();
        if ($id) {
            $cek->where('id !=', $id);
        }
        if ($cek->get()->getRow()) {
            return redirect()->back()->withInput()->with('errors', ['Hubungan antara kedua node ini sudah ada.']);
        }

        $data = ['id_node_asal' => $a, 'id_node_tujuan' => $t, 'jarak' => $this->request->getPost('jarak')];

        $builder = db_connect()->table('jarak');
        if ($id) {
            $builder->where('id', $id)->update($data);
            $pesan = 'Jarak berhasil diperbarui.';
        } else {
            $builder->insert($data);
            $pesan = 'Jarak berhasil ditambahkan.';
        }

        return redirect()->to('/admin/jarak')->with('success', $pesan);
    }
}