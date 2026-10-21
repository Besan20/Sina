<?php

namespace App\Console\Commands;

use App\Models\MedpixCase;
use App\Models\Module;
use Illuminate\Console\Command;

class AssignModulesToMedpixCases extends Command
{
    protected $signature = 'medpix:assign-modules';
    protected $description = 'توزيع حالات MedPix على الموديولات حسب location';

    public function handle()
    {
        $locationToModule = [
            'Cardiovascular' => 'Cardiovascular System',
            'Vascular' => 'Cardiovascular System',
            'Chest, Pulmonary' => 'Respiratory System',
            'Brain and Neuro' => 'Neurology',
            'Nerve, central' => 'Neurology',
            'Nerve, peripheral' => 'Neurology',
            'Genitourinary' => 'Nephrology',
            'Gastrointestinal' => 'Gastroenterology',
            'Abdomen' => 'Gastroenterology',
            'Endocrine' => 'Endocrinology',
            'Hematopoietic' => 'Hematology',
            'Musculoskeletal' => 'Orthopedics',
            'Spine' => 'Orthopedics',
            'Eye and Orbit' => 'Ophthalmology',
            'Ophthalmology' => 'Ophthalmology',
            'Breast and Mammography' => 'Breast / Mammography',
            'Dental, Oral, or Tooth' => 'Dentistry',
            'Head and Neck' => 'ENT (Ear, Nose, Throat)',
        ];

        $modules = Module::pluck('id', 'name')->toArray();

        $assigned = 0;
        $unassigned = 0;

        $this->info('🔄 جاري توزيع الحالات...');
        $total = MedpixCase::count();
        $progress = $this->output->createProgressBar($total);
        $progress->start();

        foreach (MedpixCase::with('images')->cursor() as $case) {
            $location = $case->images->first()->location ?? null;

            if ($location && isset($locationToModule[$location])) {
                $moduleName = $locationToModule[$location];
                if (isset($modules[$moduleName])) {
                    $case->update(['module_id' => $modules[$moduleName]]);
                    $assigned++;
                } else {
                    $unassigned++;
                }
            } else {
                $unassigned++;
            }

            $progress->advance();
        }

        $progress->finish();
        $this->newLine();

        // تحديث total_cases
        $this->info('📊 تحديث total_cases...');
        foreach (Module::all() as $module) {
            $module->update(['total_cases' => $module->medpixCases()->count()]);
        }

        $this->newLine();
        $this->info("✅ تم توزيع: {$assigned} حالة");
        $this->warn("⚠️  بدون module: {$unassigned} حالة");
    }
}