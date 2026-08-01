<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Theater;
use App\Models\Play;
use App\Models\Performance;
use App\Models\Profile;
use App\Models\Purchase;
use App\Models\Payment;
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
        // USUARIOS
        $user1 = User::create([
            'name' => 'Nacho Lopez',
            'email' => 'nacho@lopez.com',
            'password' => Hash::make('asdasd'),
            'role' => 1,
        ]);
        
        $user2 = User::create([
            'name' => 'Juan Perez',
            'email' => 'juan.perez@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
            'mercadopago_user_id' => config('services.mercadopago.seed_user_id'),
            'mercadopago_access_token' => config('services.mercadopago.seed_access_token'),
            'mercadopago_refresh_token' => config('services.mercadopago.seed_refresh_token'),
            'mercadopago_connected_at' => config('services.mercadopago.seed_connected_at'),
        ]);

        $user3 = User::create([
            'name' => 'Maria Gonzalez',
            'email' => 'maria.gonzalez@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user4 = User::create([
            'name' => 'Carlos Rodriguez',
            'email' => 'carlos.rodriguez@example.com',
            'password' => Hash::make('password'),
            'role' => 2,
        ]);

        $user5 = User::create([
            'name' => 'Lucia Fernandez',
            'email' => 'lucia.fernandez@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user6 = User::create([
            'name' => 'Martin Lopez',
            'email' => 'martin.lopez@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
            'mercadopago_user_id' => config('services.mercadopago.seed_user_id'),
            'mercadopago_access_token' => config('services.mercadopago.seed_access_token'),
            'mercadopago_refresh_token' => config('services.mercadopago.seed_refresh_token'),
            'mercadopago_connected_at' => config('services.mercadopago.seed_connected_at'),
        ]);

        $user7 = User::create([
            'name' => 'Valeria Martinez',
            'email' => 'valeria.martinez@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user8 = User::create([
            'name' => 'Diego Romero',
            'email' => 'diego.romero@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user9 = User::create([
            'name' => 'Sofia Herrera',
            'email' => 'sofia.herrera@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user10 = User::create([
            'name' => 'Federico Castro',
            'email' => 'federico.castro@example.com',
            'password' => Hash::make('password'),
            'role' => 2,
        ]);

        $user11 = User::create([
            'name' => 'Camila Torres',
            'email' => 'camila.torres@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user12 = User::create([
            'name' => 'Nicolas Diaz',
            'email' => 'nicolas.diaz@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user13 = User::create([
            'name' => 'Agustina Ruiz',
            'email' => 'agustina.ruiz@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user14 = User::create([
            'name' => 'Joaquin Alvarez',
            'email' => 'joaquin.alvarez@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user15 = User::create([
            'name' => 'Florencia Medina',
            'email' => 'florencia.medina@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
            'mercadopago_user_id' => config('services.mercadopago.seed_user_id'),
            'mercadopago_access_token' => config('services.mercadopago.seed_access_token'),
            'mercadopago_refresh_token' => config('services.mercadopago.seed_refresh_token'),
            'mercadopago_connected_at' => config('services.mercadopago.seed_connected_at'),
        ]);

        $user16 = User::create([
            'name' => 'Gabriel Vega',
            'email' => 'gabriel.vega@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user17 = User::create([
            'name' => 'Paula Rios',
            'email' => 'paula.rios@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user18 = User::create([
            'name' => 'Leonardo Morales',
            'email' => 'leonardo.morales@example.com',
            'password' => Hash::make('password'),
            'role' => 2,
        ]);

        $user19 = User::create([
            'name' => 'Julieta Silva',
            'email' => 'julieta.silva@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user20 = User::create([
            'name' => 'Matias Acosta',
            'email' => 'matias.acosta@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        $user21 = User::create([
            'name' => 'Carolina Benitez',
            'email' => 'carolina.benitez@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);

        //TEATROS
        $theater1 = Theater::create([
            'user_id' => $user4->id,
            'name' => 'Espacio Escena Sur',
            'address' => '1428, Av. Caseros, CABA',
            'latitude' => '-34.6338',
            'longitude' => '-58.3955',
            'verification_status' => 'verified',
            'max_capacity' => 180,
            'bio' => 'Sala independiente orientada al teatro contemporáneo, con una programación diversa que combina dramaturgia nacional, ciclos de formación y espectáculos experimentales.',
        ]);

        $theater2 = Theater::create([
            'user_id' => $user10->id,
            'name' => 'La Candileja Teatro',
            'address' => '356, Gascón, CABA',
            'latitude' => '-34.6048',
            'longitude' => '-58.4201',
            'verification_status' => 'verified',
            'max_capacity' => 120,
            'bio' => 'Espacio cultural dedicado a la producción de obras emergentes y proyectos de investigación escénica. Cuenta con una sala íntima ideal para propuestas de cercanía con el público.',
        ]);

        $theater3 = Theater::create([
            'user_id' => $user18->id,
            'name' => 'Teatro El Umbral',
            'address' => '987, Virrey Arredondo, CABA',
            'latitude' => '-34.5734',
            'longitude' => '-58.4457',
            'verification_status' => 'verified',
            'max_capacity' => 250,
            'bio' => 'Centro teatral ubicado en el corazón de la ciudad, especializado en producciones independientes, festivales y ciclos dedicados a nuevas voces de la escena argentina.',
        ]);

        // OBRAS
        // Solo estos usuarios tienen MercadoPago conectado (ver arriba), por eso son
        // los únicos candidatos a 'publicante' (user_id) de una obra.
        $mpUsers = [$user2->id, $user6->id, $user15->id];

        $play1 = Play::create([
            'title' => 'Las Horas Quietas',
            'description' => 'Un drama íntimo sobre los vínculos familiares y los secretos que atraviesan generaciones.',
            'theater_id' => $theater1->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 12000.00,
            'cover_photo' => 'Mns59QgCyQzyUYok9ZwjSaLylw10VZRzbGbdwIqv.jpg',
            'duration' => 85,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play2 = Play::create([
            'title' => 'La Última Función',
            'description' => 'Una compañía teatral se enfrenta a su despedida definitiva.',
            'theater_id' => $theater1->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 14000.00,
            'cover_photo' => 'zfmi3oUcyXuUw2hgZ7lTdJTcYQL4pqwYmzZ4S1F1.webp',
            'duration' => 100,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play3 = Play::create([
            'title' => 'Habitación 23',
            'description' => 'Suspenso psicológico ambientado en un viejo hotel porteño.',
            'theater_id' => $theater1->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 13000.00,
            'cover_photo' => 'cUwy83AnEUYBPxjoFa8khydyC9T1dGVYm6B8DwHf.jpg',
            'duration' => 95,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play4 = Play::create([
            'title' => 'El Silencio de las Cosas',
            'description' => 'Una obra poética sobre la memoria y el paso del tiempo.',
            'theater_id' => $theater1->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 11000.00,
            'cover_photo' => 'mggV6i0i4UhappRYmBhpF9WJc3wTd4XL4FSocV7d.jpg',
            'duration' => 75,
            'is_published' => true,
            'status' => 'pending',
        ]);

        $play5 = Play::create([
            'title' => 'Crónicas de un Ascensor',
            'description' => 'Historias cruzadas de vecinos atrapados en un edificio.',
            'theater_id' => $theater1->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 12500.00,
            'cover_photo' => 'siNj1RWgAX3REY9S1hhEdjAzPh1O9CLHOGDDgX7K.jpg',
            'duration' => 80,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play6 = Play::create([
            'title' => 'Manual para Perderse',
            'description' => 'Comedia contemporánea sobre la búsqueda de identidad.',
            'theater_id' => $theater2->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 10000.00,
            'cover_photo' => 'KUJIkwZh5SJVhG5JBAIesupOHbMWfnVBk1t6dtR9.jpg',
            'duration' => 70,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play7 = Play::create([
            'title' => 'Después del Ensayo',
            'description' => 'Las tensiones de un elenco salen a la luz tras una función.',
            'theater_id' => $theater2->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 11500.00,
            'cover_photo' => 'pR8GsV7xjFMMgrnnKtseGgL8JAKudUuwila0uncD.jpg',
            'duration' => 85,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play8 = Play::create([
            'title' => 'El Club de los Martes',
            'description' => 'Cinco desconocidos comparten historias inesperadas.',
            'theater_id' => $theater2->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 10500.00,
            'cover_photo' => 'esEKl6cOD1RKhfxKc8Q2fgTcqgTC5QZr68nQzAjd.webp',
            'duration' => 90,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play9 = Play::create([
            'title' => 'Pequeñas Catástrofes',
            'description' => 'Comedia negra sobre las crisis cotidianas de una familia.',
            'theater_id' => $theater2->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 12000.00,
            'cover_photo' => 'jMnHWncuoxilsQ39OD6kdpQ6ZzLP41sf6KjIRU7Z.webp',
            'duration' => 95,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play10 = Play::create([
            'title' => 'La Noche del Meteorito',
            'description' => 'Una historia fantástica ambientada en un barrio porteño.',
            'theater_id' => $theater2->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 13000.00,
            'cover_photo' => 'KvQxL3fS0Np6ip7hFgWa7YmJKOfsz5QKFesoWJ7M.jpg',
            'duration' => 100,
            'is_published' => true,
            'status' => 'pending',
        ]);

        $play11 = Play::create([
            'title' => 'Bajo la Misma Lluvia',
            'description' => 'Drama coral sobre encuentros y despedidas.',
            'theater_id' => $theater3->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 13500.00,
            'cover_photo' => '8eMye5jiEAArnQJwEmmzfFBw736Z6epOBg2GBxQq.jpg',
            'duration' => 95,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play12 = Play::create([
            'title' => 'Los Días de Invierno',
            'description' => 'Un relato sensible sobre amistades que sobreviven al tiempo.',
            'theater_id' => $theater3->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 12500.00,
            'cover_photo' => 'VnYQQUsGJBtCwEWCpE29eQvVGZ7cVQNWLZV82X63.webp',
            'duration' => 85,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play13 = Play::create([
            'title' => 'El Inventor de Recuerdos',
            'description' => 'Ficción dramática sobre la memoria y la imaginación.',
            'theater_id' => $theater3->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 14500.00,
            'cover_photo' => '217nNAM5szmSgrRa9B1lff2jxSDlqqlJklBViZzu.jpg',
            'duration' => 100,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play14 = Play::create([
            'title' => 'La Ciudad Invisible',
            'description' => 'Una mirada fantástica sobre la vida urbana.',
            'theater_id' => $theater3->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 15000.00,
            'cover_photo' => 'n121R6HKQCG7pQJAV0oLWTDy5MSkLzqLC7gh0FgG.webp',
            'duration' => 110,
            'is_published' => true,
            'status' => 'verified',
        ]);

        $play15 = Play::create([
            'title' => 'Final de Temporada',
            'description' => 'Comedia dramática sobre un grupo de artistas en crisis.',
            'theater_id' => $theater3->id,
            'user_id' => fake()->randomElement($mpUsers),
            'ticket_price' => 12000.00,
            'cover_photo' => 'WmVy7FmqzJPOgZKlrrJi7G2421LaluFwEAaFZYRL.jpg',
            'duration' => 90,
            'is_published' => true,
            'status' => 'verified',
        ]);

        // USUARIOS PARA OBRAS
        $play1->users()->attach([
            $user4->id => ['role' => 'director'],
            $user2->id => ['role' => 'actor'],
            $user3->id => ['role' => 'actor'],
            $user5->id => ['role' => 'actor'],
        ]);

        $play2->users()->attach([
            $user4->id => ['role' => 'director'],
            $user6->id => ['role' => 'actor'],
            $user7->id => ['role' => 'actor'],
            $user8->id => ['role' => 'actor'],
        ]);

        $play3->users()->attach([
            $user4->id => ['role' => 'director'],
            $user2->id => ['role' => 'actor'],
            $user9->id => ['role' => 'actor'],
        ]);

        $play4->users()->attach([
            $user4->id => ['role' => 'director'],
            $user5->id => ['role' => 'actor'],
            $user7->id => ['role' => 'actor'],
            $user8->id => ['role' => 'actor'],
        ]);

        $play5->users()->attach([
            $user4->id => ['role' => 'director'],
            $user3->id => ['role' => 'actor'],
            $user6->id => ['role' => 'actor'],
            $user9->id => ['role' => 'actor'],
        ]);


        $play6->users()->attach([
            $user10->id => ['role' => 'director'],
            $user11->id => ['role' => 'actor'],
            $user12->id => ['role' => 'actor'],
            $user13->id => ['role' => 'actor'],
        ]);

        $play7->users()->attach([
            $user10->id => ['role' => 'director'],
            $user14->id => ['role' => 'actor'],
            $user15->id => ['role' => 'actor'],
        ]);

        $play8->users()->attach([
            $user10->id => ['role' => 'director'],
            $user11->id => ['role' => 'actor'],
            $user13->id => ['role' => 'actor'],
            $user16->id => ['role' => 'actor'],
        ]);

        $play9->users()->attach([
            $user10->id => ['role' => 'director'],
            $user12->id => ['role' => 'actor'],
            $user15->id => ['role' => 'actor'],
            $user17->id => ['role' => 'actor'],
        ]);

        $play10->users()->attach([
            $user10->id => ['role' => 'director'],
            $user11->id => ['role' => 'actor'],
            $user14->id => ['role' => 'actor'],
        ]);

        $play11->users()->attach([
            $user18->id => ['role' => 'director'],
            $user19->id => ['role' => 'actor'],
            $user20->id => ['role' => 'actor'],
            $user21->id => ['role' => 'actor'],
        ]);

        $play12->users()->attach([
            $user18->id => ['role' => 'director'],
            $user19->id => ['role' => 'actor'],
            $user20->id => ['role' => 'actor'],
        ]);

        $play13->users()->attach([
            $user18->id => ['role' => 'director'],
            $user21->id => ['role' => 'actor'],
            $user2->id => ['role' => 'actor'],
            $user6->id => ['role' => 'actor'],
        ]);

        $play14->users()->attach([
            $user18->id => ['role' => 'director'],
            $user3->id => ['role' => 'actor'],
            $user12->id => ['role' => 'actor'],
            $user20->id => ['role' => 'actor'],
        ]);

        $play15->users()->attach([
            $user18->id => ['role' => 'director'],
            $user5->id => ['role' => 'actor'],
            $user14->id => ['role' => 'actor'],
            $user21->id => ['role' => 'actor'],
        ]);

        // PERFORMANCES
        $schedules = [
            $play1->id => [
                ['Friday', 20, 0],
                ['Saturday', 20, 0],
            ],
            $play2->id => [
                ['Saturday', 21, 0],
            ],
            $play3->id => [
                ['Friday', 22, 0],
                ['Sunday', 19, 0],
            ],
            $play4->id => [
                ['Thursday', 21, 0],
            ],
            $play5->id => [
                ['Saturday', 18, 30],
                ['Sunday', 18, 30],
            ],
            $play6->id => [
                ['Friday', 21, 0],
            ],
            $play7->id => [
                ['Saturday', 20, 30],
            ],
            $play8->id => [
                ['Thursday', 20, 0],
                ['Friday', 20, 0],
            ],
            $play9->id => [
                ['Sunday', 20, 0],
            ],
            $play10->id => [
                ['Saturday', 22, 0],
            ],

            $play11->id => [
                ['Friday', 20, 30],
                ['Saturday', 20, 30],
            ],
            $play12->id => [
                ['Wednesday', 21, 0],
            ],
            $play13->id => [
                ['Thursday', 21, 30],
                ['Sunday', 19, 30],
            ],
            $play14->id => [
                ['Saturday', 19, 0],
            ],
            $play15->id => [
                ['Friday', 21, 0],
                ['Sunday', 18, 0],
            ],
        ];

        $performancesByPlay = [];
        foreach ($schedules as $playId => $slots) {

            $performancesByPlay[$playId] = [];

            foreach ($slots as [$day, $hour, $minute]) {

                $firstDate = now()->next($day);
                for ($i = -2; $i < 8; $i++) {

                    $performance = Performance::create([
                        'play_id' => $playId,
                        'start_time' => $firstDate
                            ->copy()
                            ->addWeeks($i)
                            ->setHour($hour)
                            ->setMinute($minute),
                        'status' => 'scheduled',
                    ]);

                    $performancesByPlay[$playId][] = $performance;
                }
            }
        }

        // PURCHASES Y PAYMENTS
        // (Sin Tickets: la creación real de tickets genera también un QR en
        // storage/app/public/tickets/, ver PaymentController@webhook. Sin esa
        // imagen generada, un ticket seedeado quedaría con el QR roto.)
        $buyerUserIds = [
            $user1->id, $user2->id, $user3->id, $user4->id, $user5->id,
            $user6->id, $user7->id, $user8->id, $user9->id, $user10->id,
            $user11->id, $user12->id, $user13->id, $user14->id, $user15->id,
            $user16->id, $user17->id, $user18->id, $user19->id, $user20->id,
            $user21->id,
        ];
        $paymentStatusByPurchaseStatus = [
            'pending' => 'pending',
            'confirmed' => 'approved',
            'cancelled' => 'cancelled',
            'expired' => 'rejected',
        ];
        $plays = [
            $play1, $play2, $play3, $play4, $play5,
            $play6, $play7, $play8, $play9, $play10,
            $play11, $play12, $play13, $play14, $play15,
        ];

        foreach ($plays as $play) {
            $performances = collect($performancesByPlay[$play->id])->random(min(3, count($performancesByPlay[$play->id])));

            foreach ($performances as $performance) {
                $isPast = $performance->start_time->isPast();

                $ticketAmount = rand(1, 4);
                $subtotal = $ticketAmount * $play->ticket_price;
                $feeRate = 10;
                $feeAmount = $feeRate * $subtotal / 100;
                $totalAmount = $subtotal + $feeAmount;

                $status = $isPast
                    ? 'confirmed'
                    : fake()->randomElement(['pending', 'confirmed', 'cancelled', 'expired']);

                $purchase = Purchase::create([
                    'user_id' => fake()->randomElement($buyerUserIds),
                    'guest_id' => null,
                    'performance_id' => $performance->id,
                    'ticket_amount' => $ticketAmount,
                    'subtotal' => $subtotal,
                    'platform_fee_rate' => $feeRate,
                    'platform_fee_amount' => $feeAmount,
                    'total_amount' => $totalAmount,
                    'status' => $status,
                ]);

                Payment::create([
                    'purchase_id' => $purchase->id,
                    'provider' => 'mercadopago',
                    'external_id' => 'MP-' . fake()->unique()->numberBetween(100000000, 999999999),
                    'status' => $paymentStatusByPurchaseStatus[$status],
                    'amount' => $totalAmount,
                    'metadata' => ['seeded' => true],
                ]);
            }
        }

        // PROFILES
        Profile::create([
            'user_id' => $user1->id,
            'bio' => 'General Administrator and theater enthusiast with 10 years of experience.',
        ]);

        Profile::create([
            'user_id' => $user2->id,
            'bio' => 'Amante del teatro independiente y de las propuestas experimentales. Disfruto descubrir nuevas obras y espacios culturales de la ciudad.',
        ]);
        
        Profile::create([
            'user_id' => $user3->id,
            'bio' => 'Espectadora habitual de comedias y musicales. Siempre estoy buscando recomendaciones para mi próxima salida teatral.',
        ]);
        
        Profile::create([
            'user_id' => $user4->id,
            'bio' => 'Productor teatral con experiencia en espectáculos de pequeño y mediano formato. Apasionado por conectar artistas con nuevas audiencias.',
        ]);
        
        Profile::create([
            'user_id' => $user5->id,
            'bio' => 'Actriz aficionada y estudiante de artes escénicas. Me interesa conocer proyectos innovadores y talentos emergentes.',
        ]);
        
        Profile::create([
            'user_id' => $user6->id,
            'bio' => 'Fanático del teatro clásico y contemporáneo. Disfruto compartir opiniones y reseñas sobre las obras que veo.',
        ]);
        
        Profile::create([
            'user_id' => $user7->id,
            'bio' => 'Gestora cultural con interés en promover espacios artísticos accesibles para toda la comunidad.',
        ]);
        
        Profile::create([
            'user_id' => $user8->id,
            'bio' => 'Asisto regularmente a funciones de teatro independiente y circo. Siempre dispuesto a apoyar nuevas producciones.',
        ]);
        
        Profile::create([
            'user_id' => $user9->id,
            'bio' => 'Docente y espectadora frecuente. Considero al teatro una herramienta fundamental para la reflexión y el encuentro.',
        ]);
        
        Profile::create([
            'user_id' => $user10->id,
            'bio' => 'Director y productor teatral con varios años de experiencia organizando espectáculos en salas independientes.',
        ]);
        
        Profile::create([
            'user_id' => $user11->id,
            'bio' => 'Apasionada por las artes escénicas y los eventos culturales. Me encanta descubrir propuestas originales.',
        ]);
        
        Profile::create([
            'user_id' => $user12->id,
            'bio' => 'Estudiante universitario y consumidor habitual de actividades culturales. Busco experiencias que sorprendan y emocionen.',
        ]);
        
        Profile::create([
            'user_id' => $user13->id,
            'bio' => 'Interesada en el teatro físico, la danza y las expresiones artísticas contemporáneas. Siempre abierta a nuevas experiencias.',
        ]);
        
        Profile::create([
            'user_id' => $user14->id,
            'bio' => 'Actor en formación y entusiasta de los festivales de teatro. Disfruto conocer el trabajo de compañías emergentes.',
        ]);
        
        Profile::create([
            'user_id' => $user15->id,
            'bio' => 'Amante de las historias bien contadas. Frecuento salas alternativas y espacios culturales de distintos barrios.',
        ]);
        
        Profile::create([
            'user_id' => $user16->id,
            'bio' => 'Espectador curioso que disfruta tanto de los clásicos como de las propuestas más arriesgadas de la cartelera.',
        ]);
        
        Profile::create([
            'user_id' => $user17->id,
            'bio' => 'Vinculada al ámbito cultural desde hace años. Me interesa apoyar proyectos independientes y de creación colectiva.',
        ]);
        
        Profile::create([
            'user_id' => $user18->id,
            'bio' => 'Productor de espectáculos y coordinador de eventos artísticos. Creo en el poder transformador del teatro.',
        ]);
        
        Profile::create([
            'user_id' => $user19->id,
            'bio' => 'Disfruto asistir a funciones con amigos y descubrir nuevas salas. Siempre atento a las novedades de la cartelera.',
        ]);
        
        Profile::create([
            'user_id' => $user20->id,
            'bio' => 'Aficionado al teatro, el cine y la literatura. Valoro especialmente las obras con propuestas originales y arriesgadas.',
        ]);
        
        Profile::create([
            'user_id' => $user21->id,
            'bio' => 'Participante activo de la comunidad teatral local. Me gusta difundir eventos y apoyar a artistas emergentes.',
        ]);

    }
}
