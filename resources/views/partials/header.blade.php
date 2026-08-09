@php
    $np = config('captcha.routes.web.name_prefix', 'mca.captcha.');
@endphp
<header class="mca-ui-shell" id="mcaUiShell">
    <div class="mca-ui-shell__wrap">
        <div class="mca-ui-shell__inner">
            <a href="{{ route($np.'index') }}" class="mca-ui-brand">
                <span class="mca-ui-brand__mark" aria-hidden="true">
                    @include('mca-captcha::partials.icon', ['name' => 'shield'])
                </span>
                <span>{{ $mcaCapTitle ?? mca_cap('app.brand') }}</span>
            </a>

            <button type="button"
                    class="mca-ui-menu-btn"
                    id="mcaUiMenuBtn"
                    aria-expanded="false"
                    aria-controls="mcaUiNav"
                    aria-label="{{ mca_cap('app.nav_aria') }}">
                @include('mca-captcha::partials.icon', ['name' => 'menu'])
            </button>
        </div>

        <nav class="mca-ui-nav" id="mcaUiNav" aria-label="{{ mca_cap('app.nav_aria') }}">
            @if(Route::has('mca.hub.index'))
                <a href="{{ route('mca.hub.index') }}" class="mca-ui-nav__link">
                    @include('mca-captcha::partials.icon', ['name' => 'grid', 'class' => 'mca-ui-icon mca-ui-icon--sm'])
                    {{ mca_cap('nav.back_mca') }}
                </a>
            @endif

            <a href="{{ route($np.'index') }}"
               class="mca-ui-nav__link mca-ui-nav__link--active">
                {{ mca_cap('nav.settings') }}
            </a>
        </nav>
    </div>
</header>
