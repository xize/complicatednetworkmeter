<?php
class Bad {
    
    private $array;

    public function __construct() {
        $this->array = array();
    }

    public function setInArray(SpecialMagicalSword $sword1, SpecialMagicalSword $sword2) {
        $this->array[] = $sword1;
        $this->array[] = $sword2;
    }

    public function showContents() {
        foreach($this->array as $sword) {
            echo "<p>".$sword->getName()."</p>";
            echo "<p>".$sword->getDMG()."</p>";
            echo "</br>";
        }
    }

}

class Good {
    private $array;

    public function __construct() {
        $this->array = array();
    }

    public function setInArray(SpecialMagicalSword &$sword1, SpecialMagicalSword &$sword2) {
        $this->array[] = $sword1;
        $this->array[] = $sword2;
    }

    public function showContents() {
        foreach($this->array as $sword) {
            echo "<p>".$sword->getName()."</p>";
            echo "<p>".$sword->getDMG()."</p>";
            echo "</br>";
        }
    }
}

class SpecialMagicalSword {

    private $sworddmg;
    private $name;

    public function __construct(int $sworddmg, string $name) {
        $this->sworddmg = $sworddmg;
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getDMG() {
        return $this->sworddmg;
    }
}

$bad = new Bad();
$bad->setInArray(new SpecialMagicalSword(10, "ALDUIN"), new SpecialMagicalSword(1, "KYLE"));
$bad->showContents();

$good = new Good();
$good->setInArray(new SpecialMagicalSword(10, "ALDUIN"), new SpecialMagicalSword(1, "KYLE"));
$good->showContents();