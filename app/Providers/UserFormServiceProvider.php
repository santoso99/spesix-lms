<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Grade;
use App\Subject;
use App\LearningTopic;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cache;

class UserFormServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['admin.user.form','admin.student.form','admin.school-staff.form'], function($view){
            $view->with('grades', Grade::select('id','name')->orderBy('grade_level')->orderBy('name')->get());
            $view->with('roles', Role::select('id','name')->get());
        });

        View::composer(['frontpage.learning-topic.index','frontpage.learning-topic.collection.index','frontpage.learning-topic.show','frontpage.task.show','frontpage.sop.index','frontpage.exam.index','frontpage.exam.unlock', 'frontpage.contact'], function($view){
            $view->with('subjects', Cache::remember('subjects', config('cache.duration.long'), function(){
                return Subject::select('id','name')->get();
            }));
            $view->with('grade_levels', Grade::select('grade_level')->orderBy('grade_level')->distinct()->pluck('grade_level'));
        });

        View::composer(['frontpage.learning-topic.index'], function($view) {
            $view->with('school_years', LearningTopic::distinct()->pluck('school_year'));
        });
    }
}
