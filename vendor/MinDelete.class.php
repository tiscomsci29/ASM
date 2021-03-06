<?php


class MinDelete
{
    private $arr;
    private $row;
    private $column;
    private $block;
    private $minRowArr;
    private $minColumnArr;
    private $show;

    public function __construct($arr, BlockRCClass $blockRCClass)
    {
        $this->arr = $arr;
        $this->row = count($arr);
        $this->column = count($arr[0]);
        $this->block = $blockRCClass;
        $this->show = new OutputMyArrays();
    }

    /**
     * @param mixed $arr
     */
    public function setArr($arr)
    {
        $this->arr = $arr;
    }



    public function getOutput() {
        $this->minRowArr = [];
        $this->minColumnArr = [];
        // process

        // row
        $this->minValueRow();
        $this->show->show('min value : row ', $this->minRowArr);
        $this->deleteValue($this->minRowArr);
        $this->show->show('delete value : row ', $this->arr);

        // column
        $this->minValueColumn();
        $this->show->show('min value : col ', $this->minColumnArr);
        $this->deleteValue($this->minColumnArr, false);
        $this->show->show('delete value : col ', $this->arr);


        return $this->arr;
    }


    private function minValueRow() {

        for ($i = 0; $i < $this->row; $i++) {
            $a1 = array();

            for ($j = 0; $j < $this->column ; $j++) {
                if (!in_array($j, $this->block->getColumnBlock(), true) && !in_array($i, $this->block->getRowBlock(), true)) {

                    $a1[] = $this->arr[$i][$j];

                }
            }

            if (!in_array($j, $this->block->getColumnBlock(), true) && !in_array($i, $this->block->getRowBlock(), true)) {
                $this->minRowArr[] = @min($a1);
            } else {
                $this->minRowArr[] = 0;
            }

        }
    }



    private function minValueColumn()
    {
        $outTranspose = Transpose::transpose($this->arr);
        for ($j = 0; $j < $this->column; $j++) {
            $a1 = array();
            for ($i = 0; $i < $this->row ; $i++) {
                if (!in_array($i, $this->block->getRowBlock(), true) && !in_array($j, $this->block->getColumnBlock(), true)) {
                    $a1[] = $outTranspose[$j][$i];
                }
            }
            if (!in_array($i, $this->block->getRowBlock(), true) && !in_array($j, $this->block->getColumnBlock(), true)) {
                $this->minColumnArr[] = @min($a1);
            } else {
                $this->minColumnArr[] = 0;
            }
        }
        unset($outTranspose);
    }



    private function deleteValue($arrInput, $Deleterow = true) {

        for ($i = 0; $i < $this->row; $i++)
        {
            for ($j = 0; $j < $this->column; $j++)
            {
                if (!in_array($j, $this->block->getColumnBlock(), true) && !in_array($i, $this->block->getRowBlock(), true)) {
                    if ($Deleterow) {
                        $this->arr[$i][$j] -= $arrInput[$i];
                    } else {
                        $this->arr[$i][$j] -= $arrInput[$j];
                    }
                }
            }
        }

    }
}