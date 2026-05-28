<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Theater;
use App\Models\Play;
use App\Models\Performance;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@teatro.com',
            'password' => Hash::make('password'),
            'role' => 1, // Admin
        ]);
        
        $manager = User::create([
            'name' => 'Theater Manager',
            'email' => 'manager@teatro.com',
            'password' => Hash::make('password'),
            'role' => 2, // Manager
        ]);
        
        $customer = User::create([
            'name' => 'Juan Perez',
            'email' => 'juan@example.com',
            'password' => Hash::make('password'),
            'role' => 3, // Customer
        ]);
        
        // 2. Create a Theater
        $theater = Theater::create([
            'user_id' => $manager->id,
            'name' => 'Teatro Gran Rex',
            'address' => 'Av. Corrientes 857, CABA',
            'verification_status' => 'verified',
            'max_capacity' => 3000,
            'bio' => 'One of the most iconic theaters in Buenos Aires.',
        ]);
        
        // 3. Create a Play
        $play = Play::create([
            'title' => 'Esperando la Carroza',
            'description' => 'A classic Argentine comedy about family dynamics and a missing grandmother.',
            'theater_id' => $theater->id,
            'ticket_price' => 15000.00,
            'cover_photo' => 'https://placehold.co/600x400',
            'duration' => 90,
            'is_published' => true,
            'status' => 'verified', // Verified so it shows up on your site!
        ]);
        
        // 4. Create a few Performances (Showtimes)
        Performance::create([
            'play_id' => $play->id,
            'start_time' => now()->addDays(7)->setHour(20)->setMinute(0),
            'status' => 'scheduled',
        ]);
        
        Performance::create([
            'play_id' => $play->id,
            'start_time' => now()->addDays(8)->setHour(21)->setMinute(30),
            'status' => 'scheduled',
            'price_override' => 18000.00, // Weekend special price
        ]);

        Profile::create([
            'user_id' => $admin->id,
            'bio' => 'General Administrator and theater enthusiast with 10 years of experience.',
            'image' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Admin',
        ]);

        // 2. Profile for the Theater Manager
        Profile::create([
            'user_id' => $manager->id,
            'bio' => 'Manager of Teatro Gran Rex. Focused on bringing high-quality circus arts to the stage.',
            'image' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Manager',
            ]);

        // 3. Profile for the Customer/Actor (The one you'll use for staff tagging tests)
        Profile::create([
            'user_id' => $customer->id,
            'bio' => 'Professional Acrobat and Stage Actor specializing in aerial silke.',
            'image' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Juan',
            ]);

            $this->call([
                PurchaseSeeder::class,
            ]);
    }
}
