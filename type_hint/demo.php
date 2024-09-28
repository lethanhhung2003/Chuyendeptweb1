<?php
declare(strict_types=1);

require_once 'A.php'; // Nhúng class A
require_once 'B.php'; // Nhúng class B
require_once 'C.php'; // Nhúng class C
require_once 'I.php'; // Nhúng interface I

// Tạo lớp Demo với phương thức run
class Demo {
    public function run(?I $X, ?C $Y): void {
        if ($X !== null) {
            echo "Calling method f() from interface I or its implementation:\n";
            $X->f();
        } else {
            echo "X is null.\n";
        }

        if ($Y !== null) {
            echo "Calling method f() from class C or its children:\n";
            $Y->f();
        } else {
            echo "Y is null.\n";
        }
    }
}

// Tạo đối tượng demo từ lớp Demo
$demo = new Demo();

// Tạo các đối tượng từ class A, B, C
$a = new A();
$b = new B();
$c = new C();

// Gọi phương thức run() từ đối tượng demo với các đối tượng khác nhau
echo "=== Demo with objects A and C ===\n";
$demo->run($a, $c);

echo "\n=== Demo with object B and null ===\n";
$demo->run($b, null);

echo "\n=== Demo with null and object B ===\n";
$demo->run(null, $b);