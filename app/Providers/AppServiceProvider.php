<?php

namespace App\Providers;

use App\Events\LastActivityEvent;
use App\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;
use Modules\Chat\Entities\Status;
use Modules\CourseSetting\Entities\Category;
use Modules\FrontendManage\Entities\HeaderMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Schema::defaultStringLength(191);
        $this->commands([
            InstallCommand::class,
            ClientCommand::class,
            KeysCommand::class,
        ]);

        try {
            if (isModuleActive('Chat')) {
                $datatable = DB::connection()->getDatabaseName();
                if ($datatable) {
                    if (Schema::hasTable('chat_notifications')) {
                        view()->composer([
                            'backend.partials.menu',
                            theme('partials._dashboard_master'),
                            theme('partials._dashboard_menu'),
                            theme('pages.fullscreen_video'),
                        ], function ($view) {
                            $notifications = DB::table('chat_notifications')->where('notifiable_id', auth()->id())
                                ->where('read_at', null)
                                ->get();

                            foreach ($notifications as $notification) {
                                $notification->data = json_decode($notification->data);
                            }
                            $notifications = $notifications->sortByDesc('created_at');

                            $view->with(['notifications_for_chat' => $notifications]);
                        });
                    }

                    view()->composer('*', function ($view) {

                        $seed = session()->get('user_status_seedable');
                        if (isModuleActive('Chat') && auth()->check() && is_null($seed)) {
                            $users = User::all();
                            foreach ($users as $user) {
                                if (Schema::hasTable('chat_statuses')) {
                                    Status::firstOrCreate([
                                        'user_id' => $user->id,
                                    ], [
                                        'user_id' => $user->id,
                                        'status' => 0
                                    ]);
                                }

                            }

                            session()->put('user_status_seedable', 'false');
                        }
                    });

                    view()->composer('*', function ($view) {
                        if (auth()->check()) {
                            $this->app->singleton('extend_view', function ($app) {
                                if (auth()->user()->role_id == 3) {
                                    return theme('layouts.dashboard_master');
                                } else {
                                    return 'backend.master';
                                }
                            });
                        }
                    });

                }
            }

            if (Settings('frontend_active_theme')) {
                $this->app->singleton('topbarSetting', function () {
                    $topbarSetting = DB::table('topbar_settings')
                        ->first();
                    return $topbarSetting;
                });
            }


            View::composer([
                theme('partials._dashboard_menu'),
                theme('pages.fullscreen_video'),
                theme('pages.index'),
                theme('pages.courses'),
                theme('pages.courses_new'),
                theme('pages.free_courses'),
                theme('partials._menu'),
                theme('pages.quizzes'),
                theme('pages.classes'),
                theme('pages.search'),
                theme('components.home-page-course-section')
            ], function ($view) {

                $data['categories'] = Cache::rememberForever('categories', function () {
                    return Category::select('id', 'name', 'title', 'description', 'image', 'thumbnail', 'parent_id')
                        ->where('status', 1)
                        ->whereNull('parent_id')
                        ->withCount('courses')
                        ->orderBy('categories.name', 'ASC')->with('activeSubcategories', 'childs', 'subcategories')
                        ->get();
                });

                $data['languages'] = Cache::rememberForever('languages', function () {
                    return DB::table('languages')->select('id', 'name', 'code', 'rtl', 'status', 'native')
                        ->where('status', 1)
                        ->get();
                });
                $data['menus'] = Cache::rememberForever('menus', function () {
                    return HeaderMenu::orderBy('position', 'asc')
                        ->select('id', 'type', 'element_id', 'title', 'link', 'parent_id', 'position', 'show', 'is_newtab')
                        ->with('childs')
                        ->get();
                });
                $view->with($data);
            });

            View::composer([
                theme('*')
            ], function ($view) {
                $data['frontendContent'] = $data['homeContent'] = app('getHomeContent');
                $view->with($data);
            });


        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

    }
}