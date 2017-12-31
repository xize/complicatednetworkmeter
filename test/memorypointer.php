<?php
class Bad {
    
    private $array;
    private $sword1;
    private $sword2;

    public function __construct() {
        $this->array = array();
        $this->sword1 = new SpecialMagicalSword(1, "KYLE");
        $this->sword2 = new SpecialMagicalSword(10, "ALDUIN");
    }

    public function getSword1() {
        return $this->sword1;
    }

    public function getSword2() {
        return $this->sword2;
    }

    public function setSwordDamage(SpecialMagicalSword $sword, int $dmg) {
        $sword->setDMG($dmg);
    }

}

class Good {
    private $array;
    private $sword1;
    private $sword2;

    public function __construct() {
        $this->array = array();
        $this->sword1 = new SpecialMagicalSword(1, "KYLE");
        $this->sword2 = new SpecialMagicalSword(10, "ALDUIN");
    }

    public function getSword1() {
        return $this->sword1;
    }

    public function getSword2() {
        return $this->sword2;
    }

    public function setSwordDamage(SpecialMagicalSword &$sword, int $dmg) {
        $sword->setDMG($dmg);
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

    public function setDMG(int $dmg) {
        $this->sworddmg = $dmg;
    }
}

$bad = new Bad();
echo "<p>[bad sword]</p>";
echo "<p>default sword dmg: ".$bad->getSword1()->getDMG()."</p>";
echo "<p>... now we change the damage of this sword! (*wooo!* magic sounds appear) ...</p>";

$bad->setSwordDamage($bad->getSword1(), 100);

echo "<p>the new damage of this sword is: ". $bad->getSword1()->getDMG() ."</p>";
echo "</br>";

$good = new Good();
echo "<p>[good sword]</p>";
echo "<p>default sword dmg: ".$good->getSword1()->getDMG()."</p>";
echo "<p>... now we change the damage of this sword! (*wooo!* magic sounds appear) ...</p>";

$good->setSwordDamage($good->getSword1(), 100);

echo "<p>the new damage of this sword is: ". $good->getSword1()->getDMG() ."</p>";
echo "</br>";