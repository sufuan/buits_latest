<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/settings/frontend') ? 'active' : '' }}"
                href="{{ route('admin.settings.frontend') }}">Fixed Data</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/settings/frontend/promotional-section*') ? 'active' : '' }}"
                href="{{ route('promotional-section') }}">Promotional Section</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/settings/frontend/feature-list*') ? 'active' : '' }}"
                href="{{ route('feature-list') }}">Feature List</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/settings/frontend/testimonials*') ? 'active' : '' }}"
                href="{{ route('testimonials') }}">Testimonials</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/settings/frontend/contact-us') ? 'active' : '' }}"
                href="{{ route('contact-us') }}">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/settings/frontend/about-us') ? 'active' : '' }}"
                href="{{ route('adminAbout-us') }}">About Us</a>
            </li>
           
        </ul>
        <!-- End Nav -->
    </div>  
</div>
