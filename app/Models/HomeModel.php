<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
    function convert1d($sudoku)
    {
        for ($a = 0; $a < 81; $a++) {
            $grid[$a] = $sudoku["cell-$a"];
        }
        return $grid;
    }
    function convert2d($sudoku)
    {
        // konversi
        $c = 0;
        for ($a = 0; $a < 9; $a++) {
            for ($b = 0; $b < 9; $b++) {
                $grid[$a][$b] = $sudoku[$c];
                $c++;
            }
        }
        return $grid;
    }

    function check($sudoku)
    {
        // tahap pengecekan dengan aturan sudoku
        $_SESSION['wrong'] = [];
        $row_salah = 0;
        $row_check = true;

        // pengecekan 9 baris
        for ($a = 0; $a < 9; $a++) {
            $row_check = true;
            $row = $a + 1;

            for ($cell_a = $a * 9; $cell_a < ($a + 1) * 9; $cell_a++) {
                for ($cell_b = $cell_a; $cell_b < ($a + 1) * 9; $cell_b++) {
                    if ($cell_a != $cell_b && !empty($sudoku[$cell_a])) {
                        if ($sudoku[$cell_a] == $sudoku[$cell_b]) {
                            array_push($_SESSION['wrong'], $cell_a, $cell_b);
                            $row_check = false;
                        }
                    }
                }
            }
        }

        // pengecekan 9 kolom
        for ($a = 0; $a < 9; $a++) {
            $col = $a + 1;
            $col_check = true;

            for ($cell_a = $a; $cell_a < 81; $cell_a += 9) {
                for ($cell_b = $cell_a; $cell_b < 81; $cell_b += 9) {
                    if ($cell_b != $cell_a && !empty($sudoku[$cell_b])) {
                        if (($sudoku[$cell_b] == $sudoku[$cell_a])) {
                            array_push($_SESSION['wrong'], $cell_a, $cell_b);
                            $col_check = false;
                        }
                    }
                }
            }
        }

        // check subgrid
        $if_a = 0;
        $if_b = 3;
        $if_c = 9;
        $if_d = 12;
        $if_e = 18;
        $if_f = 21;
        for ($a = 0; $a < 9; $a++) {
            $subgrid = $a + 1;
            $subgrid_check = true;

            for ($cell_a = 0; $cell_a < 81; $cell_a++) {
                if ((($cell_a >= $if_a && $cell_a < $if_b) || ($cell_a >= $if_c && $cell_a < $if_d) || ($cell_a >= $if_e && $cell_a < $if_f)) && !empty($sudoku[$cell_a])) {
                    for ($cell_b = $cell_a; $cell_b < 81; $cell_b++) {
                        if ((($cell_b >= $if_a && $cell_b < $if_b) || ($cell_b >= $if_c && $cell_b < $if_d) || ($cell_b >= $if_e && $cell_b < $if_f)) && !empty($sudoku[$cell_b])) {
                            if ($cell_b != $cell_a  && !empty($sudoku[$cell_b])) {
                                if (($sudoku[$cell_b] == $sudoku[$cell_a])) {
                                    array_push($_SESSION['wrong'], $cell_a, $cell_b);
                                    $subgrid_check = false;
                                }
                            }
                        }
                    }
                }
            }

            if ($subgrid % 3 == 0) {
                $if_a = $if_a + 21;
                $if_b = $if_b + 21;
                $if_c = $if_c + 21;
                $if_d = $if_d + 21;
                $if_e = $if_e + 21;
                $if_f = $if_f + 21;
            } else {
                $if_a = $if_a + 3;
                $if_b = $if_b + 3;
                $if_c = $if_c + 3;
                $if_d = $if_d + 3;
                $if_e = $if_e + 3;
                $if_f = $if_f + 3;
            }
        }
        if ($row_check && $col_check && $subgrid_check) {
            $_SESSION['enable'] = true;
            for ($a = 0; $a < 81; $a++) {
                if ($sudoku[$a] == "") {
                    $sudoku[$a] = "0";
                }
            }
        }
        return $sudoku;
    }
}
