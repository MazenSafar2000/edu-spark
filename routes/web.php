<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Manager\ExamAttemptsController;
use App\Http\Controllers\manager\ExamController;
use App\Http\Controllers\manager\HomeworkController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\manager\OnlineClassController;
use App\Http\Controllers\manager\PromotionController;
use App\Http\Controllers\Manager\SectionExamContrller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        // Post routes for handling login submission
        Route::post('/login-student', [CustomLoginController::class, 'loginStudent'])->name('login.student');
        Route::post('/login-parent', [CustomLoginController::class, 'loginParent'])->name('login.parent');
        Route::post('/login-teacher', [CustomLoginController::class, 'loginTeacher'])->name('login.teacher');
        Route::post('/login-manager', [CustomLoginController::class, 'loginManager'])->name('login.manager');
        // Route::get('/', [HomeController::class, 'index'])->name('loginpage');
        Route::get('/', [HomeController::class, 'landingPage'])->name('landingPage');
        // Route::get('aboutUs', [HomeController::class, 'about'])->name('aboutUs');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        // Route::middleware('auth')->group(function () {
        //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        // });

        Route::get('/login/student&parent', [CustomLoginController::class, 'showStudentParentLogin'])->name('login.student_parent');
        Route::get('/school', [CustomLoginController::class, 'showTeacherManagerLogin'])->name('login.teacher_manager');


        Route::middleware(['auth', 'role:manager'])->group(function () {
            Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');

            Route::group(['namespace' => 'App\Http\Controllers\Manager'], function () {

                Route::get('manager/profile', [ManagerController::class, 'profile'])->name('manager.profile');
                Route::resource('Manager', 'ManagerController');

                Route::resource('Students', 'StudentController');
                Route::get('Download_attachment/{studentsname}/{filename}', 'ImageController@Download_attachment')->name('Download_attachment');

                Route::resource('Teachers', 'TeacherController');
                Route::get('Teachers/Classes/{id}', 'TeacherController@TeacherClasses')->name('TeachersClasses');
                Route::get('/section-materials/{teacherId}/{sectionId}', 'TeacherController@showSectionMaterials')
                    ->name('teacher.section.data');
                Route::resource('Grades', 'GradeController');
                Route::resource('Classrooms', 'ClassroomController');
                Route::resource('Parents', 'ParentController');
                Route::resource('Sections', 'SectionController');
                Route::get('Grades/Sections/Teachers/{id}', 'SectionController@TeachersSection')->name('teachersSection');
                Route::get('Grades/Sections/Students/{id}', 'SectionController@StudentsSection')->name('studentsSection');
                Route::resource('Specializations', 'SpecializationController');
                Route::resource('Subjects', 'SubjectController');
                Route::resource('TeacherSections', 'TeacherSectionController');

                Route::resource('Images', 'ImageController');

                Route::resource('Promotion', 'PromotionController');

                Route::resource('Graduate', 'GraduatedController');
                Route::post('/Graduated/one/{studentId}', 'GraduatedController@graduateOne')->name('Graduated.one');
                Route::post('/promotions/rollback-selected', [PromotionController::class, 'rollbackSelected'])
                    ->name('Promotion.rollbackSelected');

                Route::resource('StudyContent', 'StudyContentController');

                Route::resource('books', 'LibraryController');

                Route::resource('RecordedClasses', 'RecordedClassController');

                Route::resource('Homework', 'HomeworkController');
                Route::get('submissions/{homework}', 'HomeworkController@showSubmissions')->name('Homework.submissions');
                Route::patch('toggle-show-grade/{homework}', [HomeworkController::class, 'toggleShowGrade'])
                    ->name('Homework.toggleShowGrade');
                Route::get('/homework/{homework}/export', [HomeworkController::class, 'export'])
                    ->name('manager.homework.export');
                Route::post('assign-zeros/homework/{homework}', [HomeworkController::class, 'assignZeroForAbsentStudents'])->name('Homework.assignZeros');
                Route::post('Homework/{homework}/grade/{student}', 'HomeworkController@gradeStudent')->name('Homework.grade');

                Route::resource('zoomCLasses', 'OnlineClassController');
                Route::get('zoom/create/indirect', [OnlineClassController::class, 'createIndirect'])->name('zoomCLasses.create.indirect');
                Route::post('zoom/store/indirect', [OnlineClassController::class, 'storeIndirect'])->name('zoomCLasses.store.indirect');

                Route::resource('Exams', 'ExamController');
                Route::put('/{exam}/questions/settings', 'ExamQuestionsController@updateSettings')
                    ->name('Exams.questions.updateSettings');
                Route::delete('/{exam}/question/{question}', 'ExamQuestionsController@removeQuestionFromExam')->name('Exam.remove-question');
                Route::get('/Exam/questions_by_category/{category_id}', 'ExamQuestionsController@getQuestionsByCategory')->name('Exam.questions.byCategory');
                Route::post('/add-from-bank/{exam}', 'ExamQuestionsController@storeFromBank')->name('Exam.questions.storeFromBank');
                Route::post('/add-random/{exam}', 'ExamQuestionsController@storeRandomQuestions')->name('Exam.questions.storeRandom');
                Route::get('/exam/{exam}/results', [ExamController::class, 'showResults'])
                    ->name('Exam.results');
                Route::patch('/exam/{exam}/toggle-show-grade', [SectionExamContrller::class, 'toggleShowGrade'])
                    ->name('Exam.toggleShowGrade');
                Route::get('/teacher/exam/{exam}/export', [ExamController::class, 'exportExamResults'])
                    ->name('manager.exam.export');
                Route::post('/exam/{exam}/assign-zeros', [ExamController::class, 'assignZeroForAbsentStudents'])->name('Exam.assignZeros');
                Route::get('/teacher/exam/{exam}/student/{student}/attempts', 'ExamController@studentAttempts')->name('manager.exam.studentAttempts');
                Route::post('/exam/manual-degree', 'DegreeController@storeManualDegree')->name('manager.manual.degree.store');

                Route::resource('Questions', 'QuestionController');
                Route::resource('QuestionsBank', 'QuestionsBankController');
                Route::resource('QuestionsCategotry', 'QuestionsCategotryController');

                Route::resource('ExamAttempt', ExamAttemptsController::class);
                Route::get(
                    '/manager/exams/{exam}/student/{student}/attempts/{attempt}/answers',
                    [ExamAttemptsController::class, 'showAttemptAnswers']
                )->name('manager.exams.attemptAnswers');
            });
        });

        Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])
            ->middleware('auth')
            ->name('notifications.readAll');

        Route::middleware(['auth'])->group(function () {
            Route::post('/custom/messages', [ChatController::class, 'fetchMessages'])
                ->name('custom.fetchMessages');
            Route::post('/custom/markAsRead', [ChatController::class, 'markAsRead'])->name('custom.markAsRead');
        });
    }
);

require __DIR__ . '/auth.php';
