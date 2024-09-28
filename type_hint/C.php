<?php
declare(strict_types=1);

require_once 'I.php'; // Nhúng interface I

class C implements I {
    public function f(): void {
        echo "This is function f from class C.\n";
    }
}
