<?php

namespace App\Libraries;

class Dijkstra
{
    private array $graph = [];

    public function addEdge($a, $b, float $w): void
    {
        $this->graph[$a][$b] = $w;
        $this->graph[$b][$a] = $w; // graf tidak berarah
    }

    public function findShortestPath($start, $end): array
    {
        $kosong = ['path' => [], 'distance' => null, 'segments' => []];

        if (!isset($this->graph[$start], $this->graph[$end])) {
            return $kosong;
        }

        $dist = []; $prev = []; $visited = [];
        foreach (array_keys($this->graph) as $n) {
            $dist[$n] = INF;
            $prev[$n] = null;
            $visited[$n] = false;
        }
        $dist[$start] = 0;

        while (true) {
            // pilih node belum dikunjungi dengan jarak terkecil
            $u = null;
            $min = INF;
            foreach ($dist as $n => $d) {
                if (!$visited[$n] && $d < $min) {
                    $min = $d;
                    $u = $n;
                }
            }
            if ($u === null || $u === $end) break;

            $visited[$u] = true;

            // relaksasi
            foreach ($this->graph[$u] as $v => $w) {
                if ($dist[$u] + $w < $dist[$v]) {
                    $dist[$v] = $dist[$u] + $w;
                    $prev[$v] = $u;
                }
            }
        }

        // rekonstruksi jalur
        $path = [];
        for ($c = $end; $c !== null; $c = $prev[$c]) {
            array_unshift($path, $c);
        }
        if ($path[0] !== $start) {
            return $kosong;
        }

        // jarak per segmen
        $segments = [];
        for ($i = 0; $i < count($path) - 1; $i++) {
            $segments[] = $this->graph[$path[$i]][$path[$i + 1]];
        }

        return [
            'path'     => $path,
            'distance' => round($dist[$end], 1),
            'segments' => $segments,
        ];
    }
}