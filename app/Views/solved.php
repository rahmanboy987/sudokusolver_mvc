<?= $this->extend('template.php'); ?>

<?= $this->section('content'); ?>

<div class="p-5 bg-light rounded-3">
    <div class="container">
        <h1 class="display-5 fw-bold text-center">Sudoku Solver</h1>
        <p class="col fs-4 text-center">Solve Sudoku Puzzle Online</p>

        <div class="row justify-content-center">
            <div class="col-auto">
                <table class="table table-responsive">
                    <table id="grid">
                        <?php
                        $b = 0;
                        $limit = 0;
                        for ($a = 0; $a < 9; $a++) : ?>
                            <tr>
                                <?php
                                $limit = $limit + 9;
                                for ($b; $b < $limit; $b++) : ?>
                                    <td><input id="cell-<?= $b; ?>" name="cell-<?= $b; ?>" type="text" pattern="\d*" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="off" <?php if (isset($_POST["cell-$b"])) :
                                                                                                                                                                                                                    echo "value='" . $_POST["cell-$b"] . "'";
                                                                                                                                                                                                                endif; ?> <?php if (isset($_SESSION["isnull"]) && in_array("$b", $_SESSION['isnull'])) : echo "style='color:blue;'";
                                                                                                                                                                                                                                endif ?>></td>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </table>
                </table>
                <div class="text-center mt-3">
                    <a class="btn btn-primary btn-lg" href="<?= base_url(); ?>" onclick="yakin?">Reset</a>
                    <button class="btn btn-warning btn-lg" id="check" name="check" type="submit" <?php if ($_SESSION['solved']) : echo 'disabled';
                                                                                                    endif ?>>Check</button>
                    <a class="btn btn-success btn-lg <?php if (!$_SESSION['enable']) : echo 'disabled';
                                                        endif ?>" href="<?= base_url(); ?>home/solve/<?php if (isset($data['sudoku'])) :
                                                                                                                echo implode("", $data['sudoku']);;
                                                                                                            endif; ?>">Solve</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>