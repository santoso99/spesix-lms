<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
    Route::get('/register','Auth\UserRegisterController@showRegisterForm')->middleware('guest');
    Route::post('/register', 'Auth\UserRegisterController@store')->name('register')->middleware('guest');
    Auth::routes(['register'=>false,'verify'=>true]);

    Route::get('/', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::get('/register/admin', 'Auth\AdminRegisterController@showRegisterForm')->middleware('guest');
    Route::post('/register/admin', 'Auth\AdminRegisterController@store')->name('register.admin')->middleware('guest');

    // Frontpage
    Route::get('announcements/date', 'Announcement\AnnouncementController@indexByDate');
    Route::get('announcements/{announcement}', 'Announcement\AnnouncementController@show');
    Route::post('announcements/load-more', 'Announcement\AnnouncementLoadMoreController');
    Route::get('topics','Frontpage\LearningTopicIndexController@index');
    Route::get('topics/filter','Frontpage\LearningTopicIndexController@indexBySubjectSchoolYear');
    Route::get('topics/search','Frontpage\LearningTopicSearchController');
    Route::get('topics/grades/{grade_level}','Frontpage\LearningTopicIndexController@indexByGrade');
    Route::get('topics/subjects/{subject}','Frontpage\LearningTopicIndexController@indexBySubject');
    Route::get('topics/grades/{grade}/subjects/{subject}','Frontpage\LearningTopicIndexController@indexByGradeSubject');
    Route::get('topics/{topic}','Frontpage\LearningTopicController@show')->middleware('topic.access');
    Route::get('exams', 'Frontpage\ExamController@index');
    Route::get('sops', 'Frontpage\SOPController@index');
    Route::get('contacts', 'Frontpage\ContactController@index');

    // Auth Middleware
    Route::middleware(['auth'])->group(function(){
        
        Route::get('/dashboard', 'DashboardController@index');
        Route::get('exams/{exam}/create', 'Frontpage\ExamResultController@create');
        Route::get('exams/{exam}', 'Frontpage\ExamController@show');
        Route::get('exams/{exam}/questions/{question}', 'Frontpage\ExamQuestionController@show');
        Route::get('exams/{exam}/questions/{question}/prev', 'Frontpage\ExamQuestionController@showPrevious');
        Route::get('exams/{exam}/questions/{question}/next', 'Frontpage\ExamQuestionController@showNext');
        Route::get('student/exams/results/{exam_result}/questions/{question}', 'Exam\StudentExamQuestionController@show');
        Route::get('student/exams/results/{exam_result}/questions/{question}/prev', 'Exam\StudentExamQuestionController@showPrevious');
        Route::get('student/exams/results/{exam_result}/questions/{question}/next', 'Exam\StudentExamQuestionController@showNext');
        Route::get('tasks/{task}','Frontpage\TaskController@show');

        Route::middleware(['role:Siswa'])->group(function(){
            Route::get('my-topics', 'Frontpage\StudentLearningTopicCollectionController@index');
            Route::post('my-topics', 'Frontpage\StudentLearningTopicCollectionController@store');
            Route::delete('my-topics/{topic}', 'Frontpage\StudentLearningTopicCollectionController@destroy');
            Route::get('student/topics', 'Learning\StudentTopicController@index');
            Route::get('student/topics/my-topics', 'Learning\StudentTopicController@indexMyTopic');
            Route::get('student/tasks/reports', 'Task\StudentTaskSubmissionController@index');
            Route::get('student/exams', 'Exam\StudentExamController@index');
            Route::get('student/exams/results', 'Exam\StudentExamResultController@index');
            Route::get('student/exams/results/{exam_result}', 'Exam\StudentExamResultController@show');
            Route::post('tasks/submissions','Frontpage\TaskSubmissionController@store');
            Route::patch('tasks/submissions/{submission}','Frontpage\TaskSubmissionController@update');
            Route::get('topics/{topic_id}/tasks', 'Frontpage\TaskController@indexByTopic');
            Route::post('exams/{exam}/unlock', 'Frontpage\ExamResultController@store');
            Route::get('exams/{exam}/start', 'Frontpage\ExamController@start');
            Route::patch('exams/{exam}/finish','Frontpage\ExamController@finish');
            Route::post('exams/{exam}/questions/{question}/submit', 'Frontpage\ExamQuestionController@storeResponse');
        });

        Route::middleware(['role:Wali Siswa'])->group(function(){
            Route::get('parents/students/{student}/tasks/report', 'Parent\StudentTaskSubmissionController@index');
            Route::get('parents/students/{student}/exams', 'Parent\StudentExamController@index');
        });

        Route::prefix('admin')->group(function(){
            
            Route::get('grades', 'Grade\GradeController@index');
            Route::get('subjects', 'Subject\SubjectController@index');

            // Avatar
            Route::get('users/avatar/edit', 'UserAvatarController@edit');
            Route::patch('users/avatar/{user}', 'UserAvatarController@update');
            Route::delete('users/avatar/{user}', 'UserAvatarController@reset');
            
            Route::middleware(['role:Pengajar|Supervisor|Admin'])->group(function(){
                Route::get('students', 'Student\StudentController@index');
                Route::get('teachers', 'Teacher\TeacherController@index');
                Route::get('topics', 'Learning\LearningTopicController@index');
                Route::get('topics/specified', 'Learning\LearningTopicGradeFolderController@getFilteredTopic');
                Route::get('topics/overview', 'Learning\LearningTopicGradeFolderController@index');
                Route::get('topics/{topic}/visitors', 'Learning\LearningTopicVisitorController@index');
                Route::get('topics/grade-semester-label', 'Learning\LearningTopicGradeFolderController@getGradeSemester');
                Route::get('topics/grade-label', 'Learning\LearningTopicGradeFolderController@getGrade');
                Route::get('topics/subject-label', 'Learning\LearningTopicGradeFolderController@getSubject');
                Route::get('tasks', 'Task\TaskController@index')->name('tasks.index');
                Route::get('tasks/{task}/submissions/{grade_id?}', 'Task\TaskSubmissionController@index');
                Route::get('questions', 'Exam\QuestionController@index');
                Route::get('questions/create', 'Exam\QuestionController@create');
                Route::get('questions/subjects/{subject}', 'Exam\QuestionController@indexBySubject');
                Route::get('questions/{question}', 'Exam\QuestionController@show');
                Route::get('exams', 'Exam\ExamController@index');
                Route::get('exams/{exam}/edit', 'Exam\ExamController@edit');
                // Exam Result
                Route::get('exams/{exam}/results', 'Exam\ExamResultController@index');
                Route::get('exams/{exam}/results/grades/{grade}', 'Exam\ExamResultController@indexByGrade');
                Route::get('exams/{exam}/results/responses', 'Exam\ExamResultController@showStudentsResponse');
                Route::get('exams/{exam}/results/responses/grades/{grade}', 'Exam\ExamResultController@showStudentsResponseByGrade');
                Route::delete('exams/{exam}/results', 'Exam\ExamResultController@destroy')->name('exam-results.batch.delete');
                Route::get('exams/results/competencies/score', 'Exam\StudentScorePerCompetencyController')->name('exams.results.competencies.score');
                Route::patch('exams/results/{exam_result}/remedial', 'Exam\RemedialScoreController@input');
                Route::get('exams/results/{exam_result}/remedial', 'Exam\RemedialScoreController@get');
                // Exam Response
                Route::patch('exams/results/{exam_result}/status/change', 'Exam\ExamResultToggleCorrectionStatusController');
                Route::get('exams/results/{exam_result}/responses', 'Exam\ExamResponseController@index');
                Route::patch('exams/results/{exam_result}/responses/{exam_response}', 'Exam\ExamResponseController@update');
                // Exam
                Route::patch('exams/questions/{exam_question}/competencies','Exam\ExamQuestionCompetencyController@update')->name('exam.questions.competenices');
            });

            Route::middleware(['role:Pengajar'])->group(function(){
                
                // File
                Route::delete('file/delete', 'FileController@destroy')->name('file.delete');

                // Learning Topic
                Route::delete('topics/batch-delete', 'Learning\LearningTopicBatchDeleteController')->name('topic.batch.delete');
                Route::get('topics/create', 'Learning\LearningTopicController@create');
                Route::post('topics', 'Learning\LearningTopicController@store');
                Route::get('topics/{topic}', 'Learning\LearningTopicController@show');
                Route::get('topics/{topic}/edit', 'Learning\LearningTopicController@edit');
                Route::patch('topics/{topic}', 'Learning\LearningTopicController@update');
                Route::get('subjects/{subject}/topics', 'Learning\LearningTopicController@getTopicBySubject');
                Route::get('topics/{topic}/tasks', 'Task\LearningTopicTaskIndexController');
                // Learning Phase
                // Route::get('topics/{topic}/steps', 'Learning\LearningPhaseController@index')->name('steps.index');
                // Route::get('topics/{topic}/steps/create', 'Learning\LearningPhaseController@create')->name('steps.create');
                // Route::post('steps', 'Learning\LearningPhaseController@store')->name('steps.store');
                // Route::get('steps/{step}', 'Learning\LearningPhaseController@show')->name('steps.show');
                // Route::get('steps/{step}/edit', 'Learning\LearningPhaseController@edit')->name('steps.edit');
                // Route::patch('steps/{step}', 'Learning\LearningPhaseController@update')->name('steps.update');
                // Route::delete('steps', 'Learning\LearningPhaseController@destroy')->name('steps.batch.delete');
                // Learning Material
                Route::get('topics/{topic}/materials', 'Learning\LearningMaterialController@index')->name('topics.materials');
                Route::post('materials', 'Learning\LearningMaterialController@store')->name('materials.store');
                Route::get('materials/{material}/edit', 'Learning\LearningMaterialController@edit')->name('materials.edit');
                Route::patch('materials/{material}', 'Learning\LearningMaterialController@update')->name('materials.update');
                Route::delete('materials/{material}', 'Learning\LearningMaterialController@destroy')->name('materials.destroy');
                // Task
                Route::get('tasks/create/{topic?}', 'Task\TaskController@create')->name('tasks.create');
                Route::post('tasks', 'Task\TaskController@store')->name('tasks.store');
                Route::get('tasks/{task}/edit', 'Task\TaskController@edit')->name('tasks.edit');
                Route::patch('tasks/{task}', 'Task\TaskController@update')->name('tasks.update');
                Route::delete('tasks', 'Task\TaskController@destroy')->name('tasks.destroy');
                Route::patch('tasks/{task}/status/change', 'Task\TaskToggleStatusController');
                // Task Submission
                Route::get('tasks/submissions/{submission}', 'Task\TaskSubmissionController@show');
                Route::patch('tasks/submissions/{submission}', 'Task\TaskSubmissionController@update');
                Route::delete('tasks/submissions', 'Task\TaskSubmissionController@destroy');
                // Question
                Route::get('exams/{exam}/questions/subjects/{subject}/data', 'Exam\QuestionDataSourceController@fetchDataBySubject')->name('questions.subjects.data');
                Route::post('questions', 'Exam\QuestionController@store');
                Route::get('questions/{question}/edit', 'Exam\QuestionController@edit')->middleware('can:update,question');
                Route::patch('questions/{question}','Exam\QuestionController@update')->middleware('can:update,question');
                Route::delete('questions', 'Exam\QuestionController@destroy')->name('questions.batch.delete');
                // Exam
                Route::get('exams/create', 'Exam\ExamController@create');
                Route::post('exams', 'Exam\ExamController@store');
                Route::patch('exams/{exam}','Exam\ExamController@update');
                Route::delete('exams', 'Exam\ExamController@destroy')->name('exams.batch.delete');
                Route::patch('exams/{exam}/publish/change', 'Exam\ExamTogglePublishStatusController');
                Route::patch('exams/{exam}/status/change', 'Exam\ExamToggleStatusController');
                Route::get('exams/{exam}/questions/create', 'Exam\ExamQuestionController@create');
                Route::post('exams/{exam}/questions', 'Exam\ExamQuestionController@store');
                Route::delete('exams/{exam}/questions', 'Exam\ExamQuestionController@destroy')->name('exam-questions.batch.delete');
                Route::post('exams/{exam}/questions/add', 'Exam\ExamQuestionController@addToExam')->name('exams.questions.add');
                // Basic Competency
                Route::get('competencies/filter','BasicCompetencyController@filterBySubjectGrade')->name('competencies.filter');
                Route::post('competencies','BasicCompetencyController@store')->name('competencies.store');
            });

            Route::middleware(['role:Supervisor|Admin'])->group(function(){

                Route::get('users', 'User\UserController@index');
                Route::get('parents', 'Parent\ParentController@index')->name('parents.index');
                Route::get('students/{student}/parents/create', 'Parent\ParentController@create')->name('parents.create');
                Route::post('students/{student}/parents', 'Parent\ParentController@store')->name('parents.store');;
                Route::get('parents/{parent}/edit', 'Parent\ParentController@edit')->name('parents.edit');;
                Route::patch('parents/{parent}', 'Parent\ParentController@update')->name('parents.update');;
                Route::delete('parents', 'Parent\ParentController@batchDelete')->name('parents.batch.delete');;
                Route::get('announcements', 'Announcement\AnnouncementController@index');
                // SOP
                Route::get('sops', 'SOP\SOPController@index');
                Route::delete('sops', 'SOP\SOPController@destroy');
                Route::post('sops', 'SOP\SOPController@store');
                Route::get('sops/{sop}/edit', 'SOP\SOPController@edit');
                Route::patch('sops/{sop}', 'SOP\SOPController@update');
            });

            Route::middleware(['role:Admin'])->group(function(){

                // Member
                Route::get('members', 'Member\MemberController@index');
                Route::get('members/create', 'Member\MemberController@create');
                Route::post('members/import', 'Member\MemberController@import');
                Route::delete('members', 'Member\MemberController@destroy')->name('members.batch.delete');
                // Route::get('/members/export', 'Member\MemberController@export');
                // User
                Route::delete('users/batch-delete', 'User\UserBatchDeleteController')->name('user.batch.delete');
                Route::get('users/create', 'User\UserController@create');
                Route::post('users', 'User\UserController@store');
                Route::get('users/{user}/edit', 'User\UserController@edit');
                Route::patch('users/{user}', 'User\UserController@update');
                // Grade
                Route::delete('grades/batch-delete', 'Grade\GradeBatchDeleteController')->name('grade.batch.delete');
                Route::post('grades', 'Grade\GradeController@store');
                Route::get('grades/{grade}/edit', 'Grade\GradeController@edit');
                Route::patch('grades/{grade}', 'Grade\GradeController@update');
                // Student
                Route::get('students/promotion', 'Student\StudentPromotionController@index');
                Route::patch('students/promote', 'Student\StudentPromotionController@promote');
                Route::patch('students/set-grade', 'Student\StudentPromotionController@setGrade');
                Route::delete('students/batch-delete', 'Student\StudentBatchDeleteController')->name('student.batch.delete');
                Route::get('students/create', 'Student\StudentController@create');
                Route::post('students', 'Student\StudentController@store');
                Route::get('students/{student}/edit', 'Student\StudentController@edit');
                Route::patch('students/{student}', 'Student\StudentController@update');
                // Teacher
                Route::delete('teachers/batch-delete', 'Teacher\TeacherBatchDeleteController')->name('teacher.batch.delete');
                Route::get('teachers/create', 'Teacher\TeacherController@create');
                Route::post('teachers', 'Teacher\TeacherController@store');
                Route::get('teachers/{teacher}/edit', 'Teacher\TeacherController@edit');
                Route::patch('teachers/{teacher}', 'Teacher\TeacherController@update');
                // Subject
                Route::delete('subjects/batch-delete', 'Subject\SubjectBatchDeleteController')->name('subject.batch.delete');
                Route::post('subjects', 'Subject\SubjectController@store');
                Route::get('subjects/{subject}/edit', 'Subject\SubjectController@edit');
                Route::patch('subjects/{subject}', 'Subject\SubjectController@update');
                // Announcement
                Route::delete('announcements/batch-delete', 'Announcement\AnnouncementBatchDeleteController')->name('announcement.batch.delete');
                Route::get('announcements/create', 'Announcement\AnnouncementController@create');
                Route::post('announcements', 'Announcement\AnnouncementController@store');
                Route::get('announcements/{announcement}/edit', 'Announcement\AnnouncementController@edit');
                Route::post('announcements/{announcement}/notify', 'Announcement\SendAnnouncementNotificationController');
                Route::patch('announcements/{announcement}', 'Announcement\AnnouncementController@update');
            });

        });
    });
});