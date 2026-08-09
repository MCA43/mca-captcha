@if (session('status'))
    <div class="mca-ui-alert mca-ui-alert--success" role="status">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="mca-ui-alert mca-ui-alert--danger" role="alert">
        <ul class="mca-ui-alert__list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
