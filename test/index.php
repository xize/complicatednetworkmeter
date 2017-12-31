<?php
class Test {

    public function foo() {
        $this->say();
    }

    public function say() {
        for($i = 0; $i < 16;$i++) {
            echo "<p>hello</p>";
        }
    }
}

set_time_limit(0);

$testing = new Test();

declare(ticks = 1);

//this for some reason timeouts the thread
register_tick_function([&$testing, 'foo'], true);