@extends('layout')

@section('content')
<div class="contact-grid">
    <div class="contact-card">
        <h2>{{ __('ui.contact.hq') }}</h2>
        <p>88 Spectrum Ave, Ward 7, District 1</p>
        <p>Ho Chi Minh City</p>
        <p><strong>{{ __('ui.contact.phone') }}:</strong> +84 28 555 0100</p>
        <p><strong>{{ __('ui.contact.email') }}:</strong> hello@eshopper.test</p>
    </div>
    <div class="contact-card">
        <h2>{{ __('ui.contact.message') }}</h2>
        <form>
            <div class="form-group">
                <label>{{ __('ui.contact.name') }}</label>
                <input type="text" class="form-control" placeholder="{{ __('ui.contact.name') }}">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" placeholder="you@email.com">
            </div>
            <div class="form-group">
                <label>{{ __('ui.contact.message_label') }}</label>
                <textarea class="form-control" rows="4" placeholder="{{ __('ui.contact.message_placeholder') }}"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('ui.contact.send') }}</button>
        </form>
    </div>
</div>
@endsection

