<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityMethodology;
use App\Models\ActivityMonitoring;
use App\Models\BoardDee;
use App\Models\Meeting;
use App\Models\Objective;
use App\Models\Office;
use App\Models\PartnerEntity;
use App\Models\ProjectDescription;
use App\Models\ProjectProposal;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStep;
use App\Models\User;
use App\Models\Element;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
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

        $this->call(UserSeeder::class);



        Office::factory(5)->create();


        ProjectProposal::factory(10)->create([
            'office_id' => Office::all()->random()->id
        ]);

        Objective::factory(15)->create([
            'projectproposal_id' => ProjectProposal::all()->random()->id
        ]);

        Activity::factory(30)->create([
            'objective_id' => Objective::all()->random()->id
        ]);
        ActivityMonitoring::factory(10)->create([
            'projectproposal_id' => ProjectProposal::all()->random()->id
        ]);
        ActivityMethodology::factory(15)->create([
            'projectproposal_id' => ProjectProposal::all()->random()->id
        ]);

        PartnerEntity::factory(8)->create([
            'projectproposal_id' => ProjectProposal::all()->random()->id
        ]);

        ProjectDescription::factory(10)->create([
            'projectproposal_id' => ProjectProposal::all()->random()->id
        ]);

        Meeting::factory(10)->create();

        BoardDee::factory(10)->create([
            'meeting_id' => Meeting::all()->random()->id
        ]);
        Project::factory(10)->create();
        Task::factory(10)->create();
        TaskStep::factory(10)->create();
        Element::factory(10)->create();
    }
}
