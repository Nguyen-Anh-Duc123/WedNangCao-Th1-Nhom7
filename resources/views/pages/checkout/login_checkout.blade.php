@extends('layout_auth')
@section('content')

<section class="auth-shell">
    <div class="auth-backdrop"></div>
    <div class="auth-panel">
        <div class="auth-header">
            <h2>{{ __('ui.login.title') }}</h2>
            <p>{{ __('ui.login.subtitle') }}</p>
            <?php
            $message = Session::get('message');
            if($message){
                echo '<p class="auth-error">'.$message.'</p>';
                Session::put('message', null);
            }
            ?>
            <div class="auth-tabs">
                <button type="button" class="auth-tab is-active" data-target="signin">{{ __('ui.login.signin') }}</button>
                <button type="button" class="auth-tab" data-target="signup">{{ __('ui.login.signup') }}</button>
            </div>
        </div>
        <div class="auth-grid">
            <div class="auth-card auth-pane is-active" data-pane="signin">
                <h3>{{ __('ui.login.signin') }}</h3>
                <form action="{{URL::to('/login-customer')}}" method="POST">
                    {{csrf_field()}}
                    <label>Email</label>
                    <input type="text" name="email_account" placeholder="you@email.com" />
                    <label>{{ __('ui.login.password') }}</label>
                    <input type="password" name="password_account" placeholder="********" />
                    <label class="auth-check">
                        <input type="checkbox" class="checkbox">
                        {{ __('ui.login.remember') }}
                    </label>
                    <button type="submit" class="btn btn-primary btn-block">{{ __('ui.login.signin') }}</button>
                </form>
            </div>
            <div class="auth-card auth-pane" data-pane="signup">
                <h3>{{ __('ui.login.signup') }}</h3>
                <form action="{{URL::to('/add-customer')}}" method="POST">
                    {{ csrf_field() }}
                    <label>{{ __('ui.login.fullname') }}</label>
                    <input type="text" name="customer_name" placeholder="{{ __('ui.login.fullname') }}"/>
                    <label>Email</label>
                    <input type="email" name="customer_email" placeholder="you@email.com"/>
                    <label>{{ __('ui.login.password') }}</label>
                    <input type="password" name="customer_password" placeholder="{{ __('ui.login.password') }}"/>
                    <label>{{ __('ui.login.phone') }}</label>
                    <input type="text" name="customer_phone" placeholder="{{ __('ui.login.phone') }}"/>
                    <button type="submit" class="btn btn-default btn-block">{{ __('ui.login.signup') }}</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    (function () {
        var tabs = document.querySelectorAll('.auth-tab');
        var panes = document.querySelectorAll('.auth-pane');
        if (!tabs.length || !panes.length) return;
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var target = tab.getAttribute('data-target');
                tabs.forEach(function (t) { t.classList.toggle('is-active', t === tab); });
                panes.forEach(function (p) { p.classList.toggle('is-active', p.getAttribute('data-pane') === target); });
            });
        });
    })();
</script>
@endsection
