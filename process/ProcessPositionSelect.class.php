<?php


class ProcessPositionSelect
{
    private $r;
    private $c;
    private $dm;
    private $block;

    public function __construct($positionMinZero = null, DemandAndSupply $demandAndSupply = null, BlockRCClass $blockRCClass = null)
    {
        if ($positionMinZero !== null) {
            $this->setPositionMinZero($positionMinZero);
        }
        if ($demandAndSupply !== null) {
            $this->dm = $demandAndSupply;
        }
        if ($blockRCClass !== null) {
            $this->block = $blockRCClass;
        }

    }

    /**
     * @param mixed $c
     */
    public function setPositionMinZero($positionMinZero)
    {
        $this->r = $positionMinZero['row'];
        $this->c = $positionMinZero['column'];
    }

    /**
     * @param DemandAndSupply $dm
     */
    public function setDm(DemandAndSupply $dm)
    {
        $this->dm = $dm;
    }

    /**
     * @param BlockRCClass $block
     */
    public function setBlock(BlockRCClass $block)
    {
        $this->block = $block;
    }



    public function process($output) {

        // เช็คค่า supply กับ demand ตรงที่ตำแหน่งค่าที่น้อยที่สุดอยู่
        if($this->isEqual()){
            // supply > demand
            // เอาค่า demand มาใส่ตรงที่ค่าน้อยจากตำแหน่งผลบวกของ 0
            $output[$this->r][$this->c] = $this->dm->getDemand($this->c);

            // แทนค่า
            $this->dm->setSupply($this->r, 0);
            $this->dm->setDemand($this->c, 0);

            $this->block->addRow($this->r);
            $this->block->addColumn($this->c);

        } else if ($this->isSupplyOverDemand()) {
            // supply > demand
            // เอาค่า demand มาใส่ตรงที่ค่าน้อยจากตำแหน่งผลบวกของ 0
            $output[$this->r][$this->c] = $this->dm->getDemand($this->c);
            // ลบค่า
            $this->dm->setSupply($this->r, $this->dm->getSupply($this->r) - $this->dm->getDemand($this->c));
            $this->dm->setDemand($this->c, 0);

            // แถว หรือ คอลัมน์ ใดที่เป็น 0 จะไม่นำมาคิดต่อไป
            $this->block->addColumn($this->c);
        } else {
            // demand > supply
            // เอาค่า supply มาใส่ตรงที่ค่าน้อยจากตำแหน่งผลบวกของ 0
            $output[$this->r][$this->c] = $this->dm->getSupply($this->r);
            // ลบค่า
            $this->dm->setDemand($this->c, $this->dm->getDemand($this->c) - $this->dm->getSupply($this->r));
            $this->dm->setSupply($this->r, 0);

            // แถว หรือ คอลัมน์ ใดที่เป็น 0 จะไม่นำมาคิดต่อไป
            $this->block->addRow($this->r);
        }
        return $output;
    }

    private function isSupplyOverDemand() {
        return $this->dm->getSupply($this->r) > $this->dm->getDemand($this->c);
    }

    private function isEqual() {
        return $this->dm->getSupply($this->r) == $this->dm->getDemand($this->c);
    }

    private function addRowCol($row, $column) {
        // row is supply
        if ($this->dm->findRow($row)) {
            $this->block->addRow($row);
        }

        // column is demand
        if ($this->dm->findRow($column)) {
            $this->block->addRow($column);
        }
    }
}