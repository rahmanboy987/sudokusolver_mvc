<?php

namespace App\Models;

use CodeIgniter\Model;

class BacktrackingModel extends Model
{
    private $grid;

    public function __construct($grid)
    {
        $this->grid = $grid;
    }
    public function solve()
    {
        $empty = $this->findEmptyCell();
        if (!$empty) {
            return true; // Grid sudah terisi semua
        }

        list($row, $col) = $empty;
        for ($num = 1; $num <= 9; $num++) {
            if ($this->isValid($row, $col, $num)) {
                $this->grid[$row][$col] = $num;
                if ($this->solve()) {
                    return true; // Jika berhasil menyelesaikan, kembalikan true
                }
                $this->grid[$row][$col] = 0; // Jika gagal, ulangi loop
            }
        }
        return false; // Tidak ada solusi yang ditemukan
    }

    public function printGrid()
    {
        $c = 0;
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $solved[$c] = $this->grid[$i][$j];
                $c++;
            }
        }
        $_SESSION["solved"] = implode($solved);
    }

    private function findEmptyCell()
    {
        for ($row = 0; $row < 9; $row++) {
            for ($col = 0; $col < 9; $col++) {
                if ($this->grid[$row][$col] == 0) {
                    return array($row, $col); // Return posisi baris dan kolom dari cell kosong
                }
            }
        }
        return null; // Tidak ada cell kosong
    }

    private function isValid($row, $col, $num)
    {
        // Cek apakah $num sudah ada pada baris $row
        for ($i = 0; $i < 9; $i++) {
            if ($this->grid[$row][$i] == $num) {
                return false;
            }
        }

        // Cek apakah $num sudah ada pada kolom $col
        for ($i = 0; $i < 9; $i++) {
            if ($this->grid[$i][$col] == $num) {
                return false;
            }
        }

        // Cek apakah $num sudah ada pada kotak 3x3
        $boxRow = floor($row / 3) * 3;
        $boxCol = floor($col / 3) * 3;
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->grid[$boxRow + $i][$boxCol + $j] == $num) {
                    return false;
                }
            }
        }

        return true; // Jika lolos semua pengecekan, kembalikan true
    }
}
