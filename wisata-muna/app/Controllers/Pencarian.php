<?php

namespace App\Controllers;

use App\Libraries\Dijkstra;

class Pencarian extends BaseController
{
    public function index()
    {
        $db    = \Config\Database::connect();
        $nodes = $db->table('node')->orderBy('kode_node')->get()->getResultArray();
        $edges = $db->table('jarak')->get()->getResultArray();

        $byId = [];
        foreach ($nodes as $n) {
            $byId[(int) $n['id']] = $n;
        }

        $dj = new Dijkstra();
        foreach ($edges as $e) {
            $dj->addEdge((int) $e['id_node_asal'], (int) $e['id_node_tujuan'], (float) $e['jarak']);
        }

        $start = (int) ($this->request->getGet('start') ?: 21); // default Kota Raha
        $end   = (int) $this->request->getGet('end');

        $route = [];
        $total = null;
        $pesan = null;

        if ($this->request->getGet('start') !== null || $end) {
            if (!$end) {
                $pesan = 'Titik tujuan belum dipilih.';
            } elseif ($start === $end) {
                $pesan = 'Titik awal dan tujuan tidak boleh sama.';
            } else {
                $hasil = $dj->findShortestPath($start, $end);

                if (empty($hasil['path'])) {
                    $pesan = 'Rute tidak ditemukan.';
                } else {
                    $total = $hasil['distance'];
                    foreach ($hasil['path'] as $i => $id) {
                        $route[] = [
                            'kode'   => $byId[$id]['kode_node'],
                            'nama'   => $byId[$id]['nama_node'],
                            'lat'    => (float) $byId[$id]['latitude'],
                            'lng'    => (float) $byId[$id]['longitude'],
                            'segmen' => $i > 0 ? $hasil['segments'][$i - 1] : null,
                        ];
                    }
                }
            }
        }

        return view('pencarian', [
            'nodes' => $nodes,
            'start' => $start,
            'end'   => $end,
            'route' => $route,
            'total' => $total,
            'pesan' => $pesan,
        ]);
    }
}