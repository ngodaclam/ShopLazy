<div class="container" id="lockscreen-block">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="account-wall">
                <div class="user-image">
                    <img src="{{ isset($user['CandyAvatar']) && $user['CandyAvatar'] ?: url('themes/default/assets/img/avatars/avatar1_big@2x.png') }}"
                         class="img-responsive img-circle" alt="friend 8">
                    <div id="loader"></div>
                </div>
                {!! Form::open(['url' => route('login'), 'method' => 'POST', 'class' => 'form-signin']) !!}
                <h2 id="name">{!! trans('core::login.welcome_back') !!}<strong>{!! $user['CandyName'] !!}</strong>!</h2>

                <p>Enter your password to go to dashboard.</p>
                <input type="hidden" name="email" value="{!! $user['CandyUsername'] !!}"/>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                                <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">{!! trans('core::login.login') !!}</button>
                                </span>
                    </div>
                <div class="form-group change-account">
                    <a href="{!! route('login', ['change' => true]) !!}">{!! trans('core::login.change_account') !!}</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="loader-overlay">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<script>
    $(function () {
        $('body').addClass('account');
        $('body').removeClass('account2');
        $('body').removeClass('no-social');
        $('#lockscreen-block input#password2').focus();
    });
</script>