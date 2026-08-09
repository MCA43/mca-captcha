@if ($enabled)
    <div class="mca-captcha-widget" data-driver="{{ $driver }}">
        @if ($driver === 'recaptcha')
            @if (($config['version'] ?? 'v2') === 'v3')
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                <script src="{{ $config['script'] }}"></script>
                <script>
                    grecaptcha.ready(function () {
                        grecaptcha.execute(@json($config['site_key']), {action: @json($action)}).then(function (token) {
                            document.getElementById('g-recaptcha-response').value = token;
                        });
                    });
                </script>
            @else
                <script src="{{ $config['script'] }}" async defer></script>
                <div class="g-recaptcha" data-sitekey="{{ $config['site_key'] }}"></div>
            @endif
        @elseif ($driver === 'hcaptcha')
            <script src="{{ $config['script'] }}" async defer></script>
            <div class="h-captcha" data-sitekey="{{ $config['site_key'] }}"></div>
        @elseif ($driver === 'turnstile')
            <script src="{{ $config['script'] }}" async defer></script>
            <div class="cf-turnstile" data-sitekey="{{ $config['site_key'] }}"></div>
        @endif
    </div>
@endif
