<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    private $data = [];

    public function __construct()
    {
        $this->data = [
            [
                'name'              => 'Test 1',
                'email'             => 'test1@test.pl',
                'password'          => '$2y$10$ldG.s5UxkSzvQjgxa1CxOOkPStEdq.pdQ4j0Px250OC3HIWJa1z3y',
                'active'            => 1,

                'profile'           => [
                    'firstname'         => 'Imie1',
                    'lastname'          => 'Nazwisko1',
                    'status'            => 1
                ],
                'events'            => [
                    [
                        'title'             => 'Pierwsze wydarzenie',
                        'slug'              => 'pierwsze-wydarzenie',
                        'description'       => 'Lorem lipsum sit dolorem...',
                        'event_from'        => '2016-05-01',
                        'event_to'          => '2016-05-20',
                        'event_span'        => 2,
                        'place_id'          => rand(1, 3),
                        'budget_id'         => rand(1, 3),
                        'intensities_id'    => rand(1, 3),
                        'status'            => 'open',
                        'users_limit'       => 5,
                        'scoring'           => [
                            'activity_id'   => 1,
                            'tribes'        => '101010',
                            'place'         => 'Polska'
                        ]
                    ]
                ]
            ],
            [
                'name'              => 'Test 2',
                'email'             => 'test2@test.pl',
                'password'          => '$2y$10$fQBhwcNqt5y.iN2HOAtAtODgxa2C3EDqR2VVLZI4CXoocPVvLYiHC',
                'active'            => 1,

                'profile'           => [
                    'firstname'         => 'Imie2',
                    'lastname'          => 'Nazwisko2',
                    'status'            => 1
                ],
                'events'            => [
                    [
                        'title'             => 'Drugie wydarzenie',
                        'slug'              => 'drugie-wydarzenie',
                        'description'       => 'Lorem lipsum sit dolorem...',
                        'event_from'        => '2016-06-05',
                        'event_to'          => '2016-06-15',
                        'event_span'        => 7,
                        'place_id'          => rand(1, 3),
                        'budget_id'         => rand(1, 3),
                        'intensities_id'    => rand(1, 3),
                        'status'            => 'open',
                        'users_limit'       => 1,
                        'scoring'           => [
                            'activity_id'   => 1,
                            'tribes'        => '101010',
                            'place'         => 'Polska'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->setForeignKeyCheck(false);
        $this->clearTables(['users', 'profiles', 'events', 'events_activities', 'events_comments', 'events_members', 'events_messages', 'events_routes', 'events_time_line', 'events_scoring']);
        $this->execute($this->data);
        $this->setForeignKeyCheck(true);

        Model::reguard();
    }

    /**
     * @param array $data
     */
    private function execute(array $data)
    {
        /**
         * User
         */
        foreach($data as $user) {
            $profile        = $user['profile'];
            $events         = $user['events'];

            unset($user['profile'], $user['events']);

            $user_data  = \Flocc\User::create($user);
            $user_id    = $user_data->getId();

            /**
             * User profile
             */
            $profile['user_id'] = $user_id;

            \Flocc\Profile::create($profile);

            /**
             * User events
             */
            foreach($events as $event) {
                $scoring = $event['scoring'];

                unset($event['scoring']);

                $event['user_id'] = $user_id;

                $event = \Flocc\Events\Events::create($event);

                /**
                 * Event activities
                 */
                \Flocc\Events\Activities::create(['event_id' => $event->getId(), 'activity_id' => rand(1, 3)]);

                /**
                 * Event members
                 */
                \Flocc\Events\Members::create([
                    'event_id'      => $event->getId(),
                    'user_id'       => $user_id,
                    'status'        => 'member'
                ]);

                /**
                 * Add scoring
                 */
                $scoring['event_id'] = $event->getId();

                \Flocc\Events\Scoring::create([$scoring]);
            }

            /**
             * Mail label
             */
            \Flocc\Mail\Labels::create(['user_id' => $user_id, 'name' => 'Skrzynka odbiorcza', 'type' => 'inbox']);
            \Flocc\Mail\Labels::create(['user_id' => $user_id, 'name' => 'Kosz', 'type' => 'trash']);
            \Flocc\Mail\Labels::create(['user_id' => $user_id, 'name' => 'Archiwum', 'type' => 'archive']);
        }
    }

    /**
     * @param array $tables
     */
    private function clearTables(array $tables)
    {
        foreach($tables as $table) {
            \DB::table($table)->truncate();
        }
    }

    /**
     * @param bool $checks
     *
     * @return mixed
     */
    private function setForeignKeyCheck($checks)
    {
        if($checks === true) {
            return \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        return \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }
}
