<div class="container" id="login-block">
    <i class="user-img icons-faces-users-03"></i>

    <div class="account-info">
        <a href="{!! url('/') !!}" class="logo">CANDY CMS</a>

        <h3>Modular &amp; Flexible Admin.</h3>
        <ul>
            <li><i class="icon-magic-wand"></i> Fully customizable</li>
            <li><i class="icon-layers"></i> Various sibebars look</li>
            <li><i class="icon-arrow-right"></i> RTL direction support</li>
            <li><i class="icon-drop"></i> Colors options</li>
        </ul>
    </div>
    <div class="account-form">
        {!! Form::open(['url' => route('login'), 'method' => 'POST']) !!}
            <h3>{{ trans('core::login.title') }}</h3>

            <div class="append-icon">
                <input type="email" id="email" name="email" class="form-control form-white password"
                       placeholder="{!! trans('core::login.email_placeholder') !!}" required/>
                <i class="icon-user"></i>
            </div>
            <div class="append-icon m-b-20">
                <input type="password" id="password" class="form-control form-white password" name="password"
                       placeholder="{!! trans('core::login.password_placeholder') !!}" required/>
                <i class="icon-lock"></i>
            </div>

            <div class="form-group change-account" style="display: none;">
                <div class="input-group">
                    <label>
                        <input type="checkbox" id="use-current-account" data-checkbox="icheckbox_square-blue">
                        {!! trans('core::login.use_current_account') !!}
                    </label>
                </div>
            </div>
            <button type="submit" id="login" class="btn btn-lg btn-dark btn-rounded ladda-button" data-style="expand-left" >
                {!! trans('core::login.login') !!}
            </button>

            <span class="forgot-password">
                <a id="password"
                   href="{!! route('forget_password') !!}">{{ trans('core::login.forget_password') }}</a>
            </span>

            <div class="form-footer">
                <div class="clearfix">
                    <p class="new-here"><a href="{!! route('register') !!}">{{ trans('core::login.register') }}</a></p>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="loader-overlay">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>