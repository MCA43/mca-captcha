@php
    $np = config('captcha.routes.web.name_prefix', 'mca.captcha.');
    $drivers = ['none', 'recaptcha', 'hcaptcha', 'turnstile'];
    $tab = in_array($activeTab, $drivers, true) ? $activeTab : ($settings['driver'] ?? 'none');
@endphp
@extends(\Mca\Captcha\Support\McaCaptchaView::layout())

@section('title', mca_cap('pages.index_title'))

@section('content')
    <div class="mca-cap-toolbar">
        <div>
            <h1 class="mca-perm-title">{{ mca_cap('pages.index_title') }}</h1>
            <p class="mca-perm-help">{{ mca_cap('pages.help') }}</p>
        </div>
    </div>

    <div class="mca-cap-tabs">
        @foreach ($drivers as $d)
            <button type="button"
                    class="mca-cap-tabs__link {{ $tab === $d ? 'is-active' : '' }}"
                    data-mca-cap-tab="{{ $d }}">
                {{ mca_cap('drivers.'.$d) }}
                @if (($settings['driver'] ?? 'none') === $d)
                    <span class="mca-cap-tabs__badge">✓</span>
                @endif
            </button>
        @endforeach
    </div>

    <form method="post" action="{{ route($np.'update') }}" class="mca-perm-card mca-cap-form" id="mcaCapForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="driver" id="mcaCapDriver" value="{{ $tab }}">

        <div class="mca-perm-card__body">
            <div class="mca-cap-panel {{ $tab === 'none' ? 'is-active' : '' }}" data-mca-cap-panel="none">
                <p class="mca-perm-help">{{ mca_cap('drivers.none') }} — captcha widget and verification will be skipped.</p>
            </div>

            <div class="mca-cap-panel {{ $tab === 'recaptcha' ? 'is-active' : '' }}" data-mca-cap-panel="recaptcha">
                <div class="mca-cap-grid">
                    <label class="mca-perm-field">
                        <span>{{ mca_cap('fields.site_key') }}</span>
                        <input type="text" name="recaptcha_site_key" class="mca-perm-input"
                               value="{{ old('recaptcha_site_key', $settings['recaptcha']['site_key'] ?? '') }}">
                    </label>
                    <label class="mca-perm-field">
                        <span>{{ mca_cap('fields.secret_key') }}</span>
                        <input type="password" name="recaptcha_secret_key" class="mca-perm-input" autocomplete="new-password"
                               placeholder="{{ ($settings['recaptcha']['secret_set'] ?? false) ? '••••••••' : '' }}"
                               value="">
                        <span class="mca-perm-help">{{ mca_cap('fields.secret_keep') }}</span>
                    </label>
                    <label class="mca-perm-field">
                        <span>{{ mca_cap('fields.version') }}</span>
                        <select name="recaptcha_version" class="mca-perm-input">
                            @foreach (['v2', 'v3'] as $ver)
                                <option value="{{ $ver }}" @selected(old('recaptcha_version', $settings['recaptcha']['version'] ?? 'v2') === $ver)>{{ $ver }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="mca-perm-field">
                        <span>{{ mca_cap('fields.score') }}</span>
                        <input type="number" step="0.1" min="0" max="1" name="recaptcha_score_threshold" class="mca-perm-input"
                               value="{{ old('recaptcha_score_threshold', $settings['recaptcha']['score_threshold'] ?? '0.5') }}">
                        <span class="mca-perm-help">{{ mca_cap('fields.score_help') }}</span>
                    </label>
                </div>
            </div>

            <div class="mca-cap-panel {{ $tab === 'hcaptcha' ? 'is-active' : '' }}" data-mca-cap-panel="hcaptcha">
                <div class="mca-cap-grid">
                    <label class="mca-perm-field">
                        <span>{{ mca_cap('fields.site_key') }}</span>
                        <input type="text" name="hcaptcha_site_key" class="mca-perm-input"
                               value="{{ old('hcaptcha_site_key', $settings['hcaptcha']['site_key'] ?? '') }}">
                    </label>
                    <label class="mca-perm-field">
                        <span>{{ mca_cap('fields.secret_key') }}</span>
                        <input type="password" name="hcaptcha_secret_key" class="mca-perm-input" autocomplete="new-password"
                               placeholder="{{ ($settings['hcaptcha']['secret_set'] ?? false) ? '••••••••' : '' }}"
                               value="">
                        <span class="mca-perm-help">{{ mca_cap('fields.secret_keep') }}</span>
                    </label>
                </div>
            </div>

            <div class="mca-cap-panel {{ $tab === 'turnstile' ? 'is-active' : '' }}" data-mca-cap-panel="turnstile">
                <div class="mca-cap-grid">
                    <label class="mca-perm-field">
                        <span>{{ mca_cap('fields.site_key') }}</span>
                        <input type="text" name="turnstile_site_key" class="mca-perm-input"
                               value="{{ old('turnstile_site_key', $settings['turnstile']['site_key'] ?? '') }}">
                    </label>
                    <label class="mca-perm-field">
                        <span>{{ mca_cap('fields.secret_key') }}</span>
                        <input type="password" name="turnstile_secret_key" class="mca-perm-input" autocomplete="new-password"
                               placeholder="{{ ($settings['turnstile']['secret_set'] ?? false) ? '••••••••' : '' }}"
                               value="">
                        <span class="mca-perm-help">{{ mca_cap('fields.secret_keep') }}</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mca-perm-card__footer">
            <button type="submit" class="mca-ui-btn mca-ui-btn--primary">{{ mca_cap('actions.save') }}</button>
        </div>
    </form>
@endsection
