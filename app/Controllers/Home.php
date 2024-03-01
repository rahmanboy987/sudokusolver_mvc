<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $session;
    protected $homeModel;
    public function __construct()
    {
        $this->session = session();
        $this->homeModel = new \App\Models\HomeModel();
    }
    public function index()
    {
        unset($_SESSION['wrong']);
        $_SESSION['enable'] = false;
        $_SESSION['solved'] = false;

        if ($this->request->getVar('check') !== null) {

            $_SESSION['sudoku'] = $this->homeModel->convert1d($this->request->getVar());
            $_SESSION['sudoku'] = $this->homeModel->check($_SESSION['sudoku']);

            if ($_SESSION['wrong']) {
                $_SESSION['enable'] = false;
            }
        }
        $data = [
            'title' => "Home | SudokuSolver"
        ];
        return view('home', $data);
    }
    public function solve($sudoku)
    {
        if ($sudoku !== null) {
            $sudoku = $this->homeModel->convert2d($sudoku);
            $backtrackingModel = new \App\Models\BacktrackingModel($sudoku);

            if ($backtrackingModel->solve()) {
                $backtrackingModel->printGrid();
                $newURL = base_url('solved');
                header("Location: $newURL");
                die;
            } else {
                $_SESSION['enable'] = false;
                $newURL = base_url();
                header("Location: $newURL");
                die;
            }
        }
    }

    public function solved()
    {
        $_SESSION['enable'] = false;
        $temp = str_split($_SESSION["solved"]);
        for ($i = 0; $i < 81; $i++) {
            $_POST['cell-' . $i] = $temp[$i];
        }

        $data = [
            'title' => "Solved | SudokuSolver"
        ];
        return view('solved', $data);
    }
}
