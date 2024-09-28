<?php
declare(strict_types=1);

require_once 'C.php'; // Nhúng class C

class A extends C {
    public function a1(): void {
        echo "This is function a1 from class A.\n";
    }
}
