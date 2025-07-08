<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <img style="width: 35px;" src="{{ asset('logo.png') }}" alt="">
            <span class="demo menu-text fw-bolder ms-2" style="font-size: 20px;">{{ __('messages.panel_name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        @can('user_management_access')
            <li
                class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') || request()->is('admin/roles') || request()->is('admin/roles/*') || request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-user-circle'></i>
                    <div data-i18n="Layouts">User Management</div>
                </a>

                <ul class="menu-sub">
                    @can('permission_access')
                        <li
                            class="menu-item {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Permission</div>
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li
                            class="menu-item {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Roles</div>
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li
                            class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Users</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        <!-- department -->
        @can('department_access')
            <li class="menu-item {{ request()->is('admin/departments') || request()->is('admin/departments/*') ? 'active' : '' }}">
                <a href="{{ route('admin.departments.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-layer'></i>
                    <div data-i18n="Analytics">Department</div>
                </a>
            </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>

        @php
            $thesisActive = Request::is('thesis-management/*') ? 'active open' : '';
        @endphp
        @can('thesis_management_access')
            <li class="menu-item {{ $thesisActive }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-graduation'></i>
                    <div data-i18n="Account Settings">Thesis Management</div>
                </a>
                <ul class="menu-sub">
                    @php
                        $departments = \App\Models\Department::select('id', 'name', 'slug')->get();
                    @endphp

                    @foreach ($departments as $department)
                        @can('ec_thesis_access')
                            <li
                                class="menu-item {{ request()->is('thesis-management/'.$department->slug.'/thesis') || (request()->is('thesis-management/thesis/create') && request()->query('department') === $department->slug) ? 'active' : '' }}">
                                <a href="{{ route('thesis-management.thesis_by_department', ['department' => $department->slug]) }}" class="menu-link">
                                    {{ $department->name }}
                                </a>
                            </li>
                        @endcan
                    @endforeach
                </ul>
            </li>
        @endcan

        {{-- content  --}}
        @php
            $contentActive = Request::is('content-management/*') ? 'active open' : '';
        @endphp

        @can('content_management_access')
            <li class="menu-item {{ $contentActive }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-folder'></i>
                    <div data-i18n="Account Settings">Content Management</div>
                </a>
                <ul class="menu-sub">
                    @can('image_slider_access')
                        <li class="menu-item {{ request()->is('content-management/image-sliders') || request()->is('content-management/image-sliders/*') ? 'active open' : '' }}">
                            <a href="{{route('content-management.image-sliders.index')}}" class="menu-link">
                                <div data-i18n="Connections">Image Sliders</div>
                            </a>
                        </li>
                    @endcan
                    @can('announcement_access')
                        <li class="menu-item {{ request()->is('content-management/announcements') || request()->is('content-management/announcements/*') ? 'active open' : '' }}">
                            <a href="{{route('content-management.announcements.index')}}" class="menu-link">
                                <div data-i18n="Connections">Announcements</div>
                            </a>
                        </li>
                    @endcan
                    @can('news_event_access')
                        <li class="menu-item {{ request()->is('content-management/news-events') || request()->is('content-management/news-events/*') ? 'active open' : '' }}">
                            <a href="{{route('content-management.news-events.index')}}" class="menu-link">
                                <div data-i18n="Connections">News & Events</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

    </ul>
</aside>
