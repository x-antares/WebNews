<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('home') }}" class="brand-link">
        <img src="https://previews.123rf.com/images/vectorgalaxy/vectorgalaxy1807/vectorgalaxy180701699/104947780-news-logo-icon-vector-isolated-on-white-background-for-your-web-and-mobile-app-design-news-logo-logo.jpg"
             alt="WebNewsLogo"
             class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.admin.menu')
            </ul>
        </nav>
    </div>

</aside>
