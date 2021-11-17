<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ActivityLog;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminUpdateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentandOrganizationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\InformationKioskController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OSAArchivedPostController;
use App\Http\Controllers\OSAFAQsController;
use App\Http\Controllers\OSAOrganizationController;
use App\Http\Controllers\OSATelDirectoryController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SchoolOfficialsController;
use App\Http\Controllers\UniversityInfoController;
use App\Http\Controllers\UserActivityLog;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserMemberController;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {

    Route::group(['prefix' => 'admin'], function (){
        Route::post('login', [AdminAuthController::class, 'login']);
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::post('update', [AdminAuthController::class, 'update']);
        Route::post('userUpdate/{id}', [AccountController::class, 'update']);
        Route::post('change_password', [AdminAuthController::class, 'changePassword']);
        Route::post('me', [AdminAuthController::class, 'me']);
    });

    Route::group(['prefix' => 'user'], function (){
        Route::get('permission', [UserAuthController::class, 'permissions']);
        Route::post('store', [UserAuthController::class, 'store']);
        Route::post('login', [UserAuthController::class, 'login']);
        Route::post('logout', [UserAuthController::class, 'logout']);
        Route::post('update', [UserAuthController::class, 'update']);
        Route::post('change_password', [UserAuthController::class, 'changePassword']);
        Route::post('me', [UserAuthController::class, 'me']);
        Route::post('uploadUserImage', [UserAuthController::class, 'uploadUserImage']);
    });
});

Route::group(['middleware' => 'api'], function (){

    Route::group(['prefix' => 'admin'], function (){
        Route::post('organization/set/adviser', [OrganizationController::class, 'setAdviser']);
        Route::get('organization/advisers', [OrganizationController::class, 'retrieveAdviser']);
        Route::post('organization/search', [OrganizationController::class, 'searchOrgMembers']);
        Route::apiResource('organization', OrganizationController::class);
        Route::post('search/activity-logs', [ActivityLog::class, 'search']);
        Route::get('activity-logs', [ActivityLog::class, 'index']);

        Route::post('permissions/search', [RolePermissionController::class, 'searchRole']);
        Route::get('permissions/all', [RolePermissionController::class, 'all']);
        Route::apiResource('permissions', RolePermissionController::class);
        Route::apiResource('post', AdminUpdateController::class);
        Route::get('summary', [DashboardController::class, 'summary']);

        // =SCHOOL OFFICIAL
        Route::post('school_officials/search', [UniversityInfoController::class, 'searchOfficial']);
        Route::post('school_officials', [UniversityInfoController::class, 'store']);
        Route::get('school_officials', [UniversityInfoController::class, 'index']);
        Route::put('school_officials/{id}', [UniversityInfoController::class, 'update']);
        Route::delete('school_officials/{id}', [UniversityInfoController::class, 'destroy']);

        Route::get('university_info', [UniversityInfoController::class, 'universityinfo']);
        Route::get('corevalues', [UniversityInfoController::class, 'corevalues']);
        Route::put('mission/{id}', [UniversityInfoController::class, 'updateMission']);
        Route::put('vision/{id}', [UniversityInfoController::class, 'updateVision']);
        Route::put('corevalues/{id}', [UniversityInfoController::class, 'updateCV']);

        Route::get('accounts', [AccountController::class, 'recentAccounts']);
        Route::put('user/{id}', [AccountController::class, 'update']);
        Route::get('all_accounts', [AccountController::class, 'accounts']);

        Route::get('unit_accounts', [AccountController::class, 'unitAccounts']);
        Route::get('approved/unit_accounts', [AccountController::class, 'approvedUnitAccounts']);
        Route::get('pending/unit_accounts', [AccountController::class, 'pendingUnitAccounts']);

        Route::get('org_accounts', [AccountController::class, 'orgAccounts']);
        Route::get('approved/org_accounts', [AccountController::class, 'approvedOrgAccounts']);
        Route::get('pending/org_accounts', [AccountController::class, 'pendingOrgAccounts']);

        Route::delete('accounts/destroy/{id}', [AccountController::class, 'destroy']);
        Route::put('approve_account/{id}', [AccountController::class, 'approveAccount']);

        //ORGANIZATION AND DEPARTMENT ROLES
        Route::post('departments/role', [DepartmentandOrganizationController::class, 'storeDepRole']);
        Route::get('departments/roles', [DepartmentandOrganizationController::class, 'depRoles']);
        Route::post('search/department', [DepartmentandOrganizationController::class, 'searchDepartment']);
        Route::post('search/depAccounts', [AccountController::class, 'searchDepartmentAccounts']);
        Route::post('search/department/role', [DepartmentandOrganizationController::class, 'searchDepartmentRole']);
        Route::put('departments/role/{id}', [DepartmentandOrganizationController::class, 'updateDepRole']);
        Route::post('departments/role/{id}', [DepartmentandOrganizationController::class, 'deleteDepRoles']);
        Route::post('uploadDepartmentImage', [DepartmentandOrganizationController::class, 'uploadDepartmentImage']);
        
        Route::get('organization/all', [DepartmentandOrganizationController::class, 'allOrganizations']);
        Route::post('organizations/role', [DepartmentandOrganizationController::class, 'storeOrgRole']);
        Route::post('search/organization', [DepartmentandOrganizationController::class, 'searchOrganization']);
        Route::post('search/orgAccounts', [AccountController::class, 'searchOrganizationAccounts']);
        Route::post('search/organization/role', [DepartmentandOrganizationController::class, 'searchOrganizationRole']);
        Route::put('organizations/role/{id}', [DepartmentandOrganizationController::class, 'updateOrgRole']);
        Route::get('organizations/roles', [DepartmentandOrganizationController::class, 'orgRoles']);
        Route::post('organizations/role/{id}', [DepartmentandOrganizationController::class, 'deleteOrgRoles']);
        Route::post('uploadOrganizationImage', [DepartmentandOrganizationController::class, 'uploadOrganizationImage']);
        
        //ORGANIZATION AND DEPARTMENTS
        Route::get('department/all', [DepartmentandOrganizationController::class, 'allDepartments']);
        Route::get('departments', [DepartmentandOrganizationController::class, 'department']);
        Route::post('departments', [DepartmentandOrganizationController::class, 'storeDepartment']);
        Route::post('search/department', [DepartmentandOrganizationController::class, 'searchDepartment']);
        Route::post('departments/{id}', [DepartmentandOrganizationController::class, 'deleteDepartment']);
        Route::put('departments/{id}', [DepartmentandOrganizationController::class, 'updateDepartment']);

        Route::get('organizations', [DepartmentandOrganizationController::class, 'organization']);
        Route::post('search/organization', [DepartmentandOrganizationController::class, 'searchOrganization']);
        Route::post('organizations', [DepartmentandOrganizationController::class, 'storeOrganization']);
        Route::post('organizations/{id}', [DepartmentandOrganizationController::class, 'deleteOrganization']);
        Route::put('organizations/{id}', [DepartmentandOrganizationController::class, 'updateOrganization']);

        Route::get('rates', [RateController::class, 'index']);
        

        //FAQS
        Route::get('faqs', [FaqController::class, 'faqs']);
        Route::post('faqs', [FaqController::class, 'storeFaqs']);
        Route::post('search/faqs', [FaqController::class, 'searchFaqs']);
        Route::put('faqs/{id}', [FaqController::class, 'updateFaqs']);
        Route::delete('faqs/destroy/{id}', [FaqController::class, 'deleteFaqs']);

        Route::post('uploadAccountImage', [AccountController::class, 'uploadAccountImage']);

        Route::get('tel_directory', [UniversityInfoController::class, 'telephoneDirectories']);
        Route::post('search/telephone', [UniversityInfoController::class, 'searchTelephoneDirectory']);
        Route::post('new_telephone', [UniversityInfoController::class, 'storeTelephone']);
        Route::put('telephone/{id}', [UniversityInfoController::class, 'updateTelephone']);
        Route::delete('telephone/destroy/{id}', [UniversityInfoController::class, 'deleteTelephone']);

        Route::get('college', [UniversityInfoController::class, 'colleges']);
        Route::post('search/college', [UniversityInfoController::class, 'searchCollege']);
        Route::post('new_college', [UniversityInfoController::class, 'storeCollege']);
        Route::put('college/{id}', [UniversityInfoController::class, 'updateCollege']);
        Route::delete('college/destroy/{id}', [UniversityInfoController::class, 'deleteCollege']);

        Route::get('course', [UniversityInfoController::class, 'courses']);
        Route::post('search/course', [UniversityInfoController::class, 'searchCourse']);
        Route::post('new_course', [UniversityInfoController::class, 'storeCourse']);
        Route::put('course/{id}', [UniversityInfoController::class, 'updateCourse']);
        Route::delete('course/destroy/{id}', [UniversityInfoController::class, 'deleteCourse']);
        
        //TO-DO REMOVE FUNCTIONS ON CONTROLLERS
        // Route::get('courseobjective', [UniversityInfoController::class, 'courseObjectives']);
        // Route::post('search/courseobjective', [UniversityInfoController::class, 'searchCourseObjective']);
        // Route::post('new_course_objective', [UniversityInfoController::class, 'storeCourseObjective']);
        // Route::put('courseobjective/{id}', [UniversityInfoController::class, 'updateCourseObjective']);
        Route::delete('courseobjective/destroy/{id}', [UniversityInfoController::class, 'deleteCourseObjective']);

        Route::get('goal', [UniversityInfoController::class, 'goals']);
        Route::post('search/goal', [UniversityInfoController::class, 'searchGoal']);
        Route::post('new_goal', [UniversityInfoController::class, 'storeGoal']);
        Route::put('goal/{id}', [UniversityInfoController::class, 'updateGoal']);
        Route::delete('goal/destroy/{id}', [UniversityInfoController::class, 'deleteGoal']);

        Route::get('objective', [UniversityInfoController::class, 'objectives']);
        Route::post('search/objective', [UniversityInfoController::class, 'searchObjective']);
        Route::post('new_objective', [UniversityInfoController::class, 'storeObjective']);
        Route::put('objective/{id}', [UniversityInfoController::class, 'updateObjective']);
        Route::delete('objective/destroy/{id}', [UniversityInfoController::class, 'deleteObjective']);
    });

    Route::group(['prefix' => 'user'], function (){
        //LOGS
        Route::post('search/activity-logs', [UserActivityLog::class, 'search']);
        Route::get('activity-logs', [UserActivityLog::class, 'index']);
        Route::get('summary/activity-logs', [UserActivityLog::class, 'summary']);

        //POSTS
        Route::put('post/approve/{id}', [PostController::class, 'approvePost']);
        Route::get('posts', [PostController::class, 'posts']);
        Route::post('post', [PostController::class, 'store']);
        Route::post('search/post', [PostController::class, 'searchPost']);
        Route::put('posts/{id}', [PostController::class, 'updatePost']);
        Route::delete('post/destroy/{id}', [PostController::class, 'deletePost']);
        Route::post('uploadPostImage', [PostController::class, 'uploadPostImage']);
        Route::get('osa/post', [PostController::class, 'OSAPostSummary']);
        Route::post('setSchedule', [PostController::class, 'setSchedule']);
        Route::post('getSchedule', [PostController::class, 'getSchedule']);

        //DASHBOARD
        Route::get('accountSummary', [UserDashboardController::class, 'accountMembers']);
        Route::get('summary', [UserDashboardController::class, 'summary']);

        //MEMBERS
        Route::post('search/members', [UserMemberController::class, 'searchMember']);
        // Route::get('members', [UserMemberController::class, 'accounts']);
        Route::apiResource('members', UserMemberController::class);
        // Route::get('posts', [UserMemberController::class, 'accPosts']);
        Route::put('approveMember/{id}', [UserMemberController::class, 'approveMember']);
        Route::put('approveOrgMember/{id}', [UserMemberController::class, 'approveOrgMember']);

        //FAQS - OSA
        Route::get('faqs', [OSAFAQsController::class, 'faqs']);
        Route::post('faqs', [OSAFAQsController::class, 'storeFaqs']);
        Route::post('search/faqs', [OSAFAQsController::class, 'searchFaqs']);
        Route::put('faqs/{id}', [OSAFAQsController::class, 'updateFaqs']);
        Route::delete('faqs/destroy/{id}', [OSAFAQsController::class, 'deleteFaqs']);


        //TEL DIRECTORY - OSA
        Route::get('tel_directory', [OSATelDirectoryController::class, 'telephoneDirectories']);
        Route::post('search/telephone', [OSATelDirectoryController::class, 'searchTelephoneDirectory']);
        Route::post('new_telephone', [OSATelDirectoryController::class, 'storeTelephone']);
        Route::put('telephone/{id}', [OSATelDirectoryController::class, 'updateTelephone']);
        Route::delete('telephone/destroy/{id}', [OSATelDirectoryController::class, 'deleteTelephone']);

        //ORGANIZATIONS - OSA
        Route::apiResource('osa/organizations', OSAOrganizationController::class);
        Route::apiResource('osa/archived', OSAArchivedPostController::class);
    });

});

Route::get('depandorg', [DepartmentandOrganizationController::class, 'index']);

//INFO KIOSK
Route::get('faqs', [InformationKioskController::class, 'faqs']);
Route::get('departments', [InformationKioskController::class, 'departments']);
Route::get('organizations', [InformationKioskController::class, 'organizations']);
Route::get('missionvision', [InformationKioskController::class, 'missionvision']);
Route::get('corevalues', [InformationKioskController::class, 'corevalues']);
Route::get('schoolofficials', [InformationKioskController::class, 'schoolofficials']);
Route::get('teldirectories', [InformationKioskController::class, 'teldirectories']);
Route::get('courses', [InformationKioskController::class, 'courses']);
Route::get('posts', [InformationKioskController::class, 'posts']);
Route::post('requestOrgPost', [InformationKioskController::class, 'requestOrgPost']);
Route::post('requestDepPost', [InformationKioskController::class, 'requestDepPost']);
Route::post('review', [RateController::class, 'store']);
Route::post('request/account/reset', [UserAuthController::class, 'reset']);
Route::post('request/check/reset', [UserAuthController::class, 'checkResetRequest']);
Route::post('request/reset/password', [UserAuthController::class, 'saveResetRequest']);