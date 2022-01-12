<div class="login-box">
    <div class="login-logo">
        <img src="{{ mix('favicon.png', '/assets/vendor/boilerplate') }}" alt="bdpay" width="50" height="50">
        {!! config('boilerplate.theme.sidebar.brand.logo.text') ?? $title ?? '' !!}
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            {{ $slot }}
        </div>
    </div>
</div>
