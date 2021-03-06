<?php


class DemandAndSupply
{
    private $demand;
    private $supply;
    private $sumDemand;
    private $position;

    public function __construct($demand, $supply)
    {
        $this->demand = $demand;
        $this->supply = $supply;
        $this->sumDemand();
    }

    /**
     * @return mixed
     */
    public function getDemand($index = null)
    {
        if ($index === null) {
            return $this->demand;
        }
        return $this->demand[$index];
    }

    /**
     * @return mixed
     */
    public function getSupply($index = null)
    {
        if ($index === null) {
            return $this->supply;
        }
        return $this->supply[$index];
    }

    public function findRow($value)
    {
        foreach ($this->supply as $sup) {
            if ($value === $sup) {
                return true;
            }
        }
        return false;
    }

    public function findColumn($value)
    {
        foreach ($this->demand as $de) {
            if ($value === $de) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param mixed $demand
     */
    public function setDemand($index, $demand)
    {
        $this->demand[$index] = $demand;
    }

    /**
     * @param mixed $supply
     */
    public function setSupply($index, $supply)
    {
        $this->supply[$index] = $supply;
    }



    private function sumDemand() {
        $this->sumDemand = array_sum($this->demand);
    }


    private function checkSupplyMoreDemand() {
        // supply > demand ทั้ง 2 ค่าเลยหรือไม่
        $bool = true;

        foreach ($this->supply as $item => $value) {
            $bool &= $value > $this->sumDemand;

        }
        return $bool;
    }


    private function checkSupplyHasTwo()
    {
//        echo 'count :: Supply > demand<br>';
        $start = 0;
        foreach ($this->supply as $item => $value) {
            if ($value > 0) {
                $start++;
            }
        }
        return $start === 2;
    }

    private function checkDemandHasTwo(){
//        echo 'count :: Supply < demand<br>';
        $start = 0;
        foreach ($this->demand as $item => $value) {
            if ($value > 0) {
                $start++;
            }
        }
        return $start === 2;
    }

    public function isDemandOrSupplyEqualZero() {
        if ((array_sum($this->demand) === 0) || (array_sum($this->supply) === 0)) {
            return true;
        }
        return false;
    }

    public function process($positionMinZero, $min) {
        $this->sumDemand();

//        if ($this->checkSupplyHasTwo()){

            // yes จะดูที่ค่า input แรก
            echo 'yes จะดูที่ค่า input แรก';
            echo '<br>min index : ' . $min;

            $positionMinZero = $positionMinZero[$min];

//        }


//        if ($this->checkDemandHasTwo()) {
            // no เลือกตำแหน่งที่ supply > demand
//            echo 'no เลือกตำแหน่งที่ supply > demand';

//            foreach ($positionMinZero as $item => $value) {
//                if ($value['row'] == $this->position) {
//                    $positionMinZero = $positionMinZero[$item];
//                }
//            }
//        }

        echo '<br>';
        return $positionMinZero;
    }
}