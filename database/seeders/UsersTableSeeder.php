<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];

        for ($i = 1; $i <= 101; $i++) {
            if ($i == 1) {
                $user_name = "admin";
                $role = "A";
            } elseif ($i <= 51) {
                $user_name = "test" . ($i - 1);
                $role = "U";
            } else {
                $user_name = "nutri" . ($i - 51);
                $role = "N";
            }

            $users[] = [
                'name' => $user_name,
                'email' => $user_name . '@gmail.com',
                'password' => Hash::make($user_name),
                'avatar' => 'iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAIAAAAiOjnJAAAG9klEQVR4nO3Yb2xVdx3H8c/v3PZe+i9Q2qlQ1sJqF4bAWGCKmyILGIksGnUqMUtYlj0hLro90GiyR26amfgnEmPCJFnmn+gyGQlui2ao3RbmlKkLDBwbE0GkbFD6l97S9p6fD9q0F9b1wvCT9rL361Fze3q/J/e+z6+/c4JWbhPw/5ZM9wngykRYsCAsWBAWLAgLFoQFC8KCBWHBgrBgQViwICxYEBYsCAsWhAULwoIFYcGCsGBBWLAgLFgQFiwICxaEBQvCggVhwYKwYEFYsCAsWBAWLAgLFoQFC8KCBWHBgrBgQViwICxYEBYsCAsWhAULwoIFYcGCsGBBWLAgLFgQFiwICxaEBQvCggVhwYKwYEFYsCAsWBAWLAgLFoQFC8KCBWHBgrBgQViwICxYEBYsCAsWhAULwoIFYcGCsGBBWLAgLFgQFiwICxaEBQvCggVhwYKwYEFYsCAsWBAWLAgLFoQFC8KCBWHBgrBgQViwICxYEBYsCAsWhAULwoIFYcGCsGBBWLAgLFgQ1jt0763J9i2ZyoxxREOdWq4KxgFOhDVDtc0L92/KNDdO93m8U4Q1QzXUKVsx3SdxGQgLFmV5Udy9IXn/vPC1nxU2fSS5sTWkUa/8N+78a/pG98QxVVltXJmsuibMqVVfXi8dibteTPvyEwfUVelTq5LrF4bZ1erNa9/RuGtv2jNwCSOKlRx3gXtvTT5wddjyUGG4MPZKdU5b78y8dCT++HfpXeuT1W1B0ua1yea1uu9XhZNvM3fGKsuwRt1xS/KhtrG97arWsLgp8+DOsS+gOqdvfCYzv37syPoa3bI0LGvOfOfxQm9ekubW6pufzdTXTBzwsSVhxcLMgzsLp3ovakSxkuPehco1rJqcblgUfv5Muvf1OLtaX7wpWdocvnBTsvWpVNJtq5P59frLa/HJv8dTPXFOjdYtS9YvD5tuTh7anUq6fU1SX6PXOuKjz8eOrvi+OeHzHw6Lm8Lmtcn3dqUXM6JYyXGXavvu9OVj4a51ySPt6XP/jJf3UU2Pct1jhaAdL6TPHIwD59TRpZ/8Pu3q19LmUJNTRaLV14b/dMbtu9MTZ+JwQad69es96cHjcVVryFWqdpaWtYSeAf3oyfTfb8Zzwzp6Km59Ku3s0+Km0FhXekSxkuPencp1xZL0/KGJS3loRPuPxTVLQlNDyJ9TtkJXN4SfbpnkKVPT3JCtUJD2HY2Dwyp+h38cieuXhwWN4XRfnHrEqycmXp9XH6Ye9683ynLJuUzlGlZ+SPmh817pHpCkqqymfqRYnVNFRpK6zl74q+6zUQrjN/lTjLjgDaced5HK9Uno2yjXsGZlVZnR+C2VpNGdeH9eI6kk7T0ctz09+f5mcVMYP75YfW2QdHaw9Ihio8veFOMmFaMkJYlUdFd4JSnbPZa0YuHERZ6r1PKWMFzQ8TOxoysWUl23INRVTf63xztjlJa3hFlFG6BshW5YFCR1dMWSI4rfreS4SY3W31A38f7XLbii1qxyDUvSlz6arLwmVGXVNDd8eUMyu1p7D8dzwxoa0Yuvx9pZumdjcu38kK1QdU43toYf3pHZememKqv+Qe0/GmdX66sbk4XvCblKNTeGr3wymVurQyfimf7SI4qVHDep0Ycam24ODXXKVeqDbeG21UlatOSN/jy/PiTl2Vu5/iuUdLI7bvnExIVxulc7Xhj7Zh7dk7a+N9NyVfj6pye+lhj18J/S0W3TL59LmxszbfPCfZ+bOKBnQI+0n/fvbIoRxUqOe6s/H4rrloYlC8J3bx/b8j97MC5rOe9kJH38+rBmSeaBHYWOrqk/jBmnjFes7X9I97wSB4fVfVbtB+K3Hy+MPzfvzeuBHYWn98XTfSqk6hnQ/mPx+79Nx+/yOvt0/28K7QdiV79GUnX26Y8vx289Vniz52JHFCs57q2OnY4/eCI9fDIOjahnQE/8Lf7i2fOSfbUjth+I+SGlUY115bdqBa3cNt3ncMnu3pCsWBTuebjQP1j64Bk74spWxisWZjLCggVhwaIs91iY+VixYEFYsCAsWBAWLAgLFoQFC8KCBWHBgrBgQViwICxYEBYsCAsWhAULwoIFYcGCsGBBWLAgLFgQFiwICxaEBQvCggVhwYKwYEFYsCAsWBAWLAgLFoQFC8KCBWHBgrBgQViwICxYEBYsCAsWhAULwoIFYcGCsGBBWLAgLFgQFiwICxaEBQvCggVhwYKwYEFYsCAsWBAWLAgLFoQFC8KCBWHBgrBgQViwICxYEBYsCAsWhAULwoIFYcGCsGBBWLAgLFgQFiwICxaEBQvCggVhwYKwYEFYsCAsWBAWLAgLFoQFC8KCBWHBgrBgQViwICxYEBYsCAsWhAULwoIFYcHifz2AWPH8K4sLAAAAAElFTkSuQmCC',  // 画像データは省略
                'role' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $this->user->insert($users);

    }
}
