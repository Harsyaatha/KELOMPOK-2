<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Node extends BaseController
{
    public function index()
    {
        $nodes = db_connect()->table('node')->orderBy('kode_node')->get()->getResultArray();
        return view('admin/node_index', ['nodes' => $nodes]);
    }

    public function create()
    {
        return view('admin/node_form', ['node' => null, 'action' => '/admin/node/store', 'judul' => 'Tambah Node']);
    }

    public function store()
    {
        return $this->simpan(null);
    }

    public function edit($id)
    {
        $node = db_connect()->table('node')->where('id', $id)->get()->getRowArray();
        if (! $node) {
            return redirect()->to('/admin/node')->with('error', 'Node tidak ditemukan.');
        }
        return view('admin/node_form', ['node' => $node, 'action' => '/admin/node/update/' . $id, 'judul' => 'Ubah Node']);
    }

    public function update($id)
    {
        return $this->simpan((int) $id);
    }

    public function delete($id)
    {
        $db = db_connect();
        // hapus dulu semua jarak yang memakai node ini (foreign key)
        $db->table('jarak')->where('id_node_asal', $id)->orWhere('id_node_tujuan', $id)->delete();
        $db->table('node')->where('id', $id)->delete();

        return redirect()->to('/admin/node')->with('success', 'Node dan jarak terkait berhasil dihapus.');
    }

    private function simpan(?int $id)
    {
        $unique = $id ? "is_unique[node.kode_node,id,$id]" : 'is_unique[node.kode_node]';

        $rules = [
            'kode_node' => "required|max_length[10]|$unique",
            'nama_node' => 'required|max_length[100]',
            'latitude'  => 'required|numeric|greater_than_equal_to[-90]|less_than_equal_to[90]',
            'longitude' => 'required|numeric|greater_than_equal_to[-180]|less_than_equal_to[180]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'kode_node' => strtoupper(trim($this->request->getPost('kode_node'))),
            'nama_node' => trim($this->request->getPost('nama_node')),
            'latitude'  => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
        ];

        $builder = db_connect()->table('node');
        if ($id) {
            $builder->where('id', $id)->update($data);
            $pesan = 'Node berhasil diperbarui.';
        } else {
            $builder->insert($data);
            $pesan = 'Node berhasil ditambahkan.';
        }

        return redirect()->to('/admin/node')->with('success', $pesan);
    }
}