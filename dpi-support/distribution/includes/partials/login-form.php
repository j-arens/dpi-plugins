<form class="c-login-form c-box c-box__raised" id="loginform-js" action="<?= $this->standardLoginPath ?>" method="post">
    <input type="hidden" id="nonce" value="<?= $this->nonce ?>" />
    <input type="hidden" name="redirect_to" value="<?= $this->redirectUrl ?>" />
    <h1 class="c-login-form--title">Sign In</h1>
    <p class="c-login-form--sub-title">You're just one step away from getting all the help you need!</p>
    <div class="c-login-form--icon-container">
        <svg class="c-login-form--icon c-login-form--icon-lock login-form--icon-js" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6-5.1c1.71 0 3.1 1.39 3.1 3.1v2H9V6h-.1c0-1.71 1.39-3.1 3.1-3.1zM18 20H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/>
        </svg>
        <svg class="c-login-form--icon c-login-form--icon-spinner c-login-form--icon__is-hidden login-form--icon-js" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><defs><clipPath clipPathUnits="userSpaceOnUse"><path d="M0 48 48 48 48 0 0 0 0 48Z"/></clipPath><clipPath clipPathUnits="userSpaceOnUse"><path d="M0 48 48 48 48 0 0 0 0 48Z"/></clipPath><clipPath clipPathUnits="userSpaceOnUse"><path d="M0 48 48 48 48 0 0 0 0 48Z"/></clipPath><clipPath clipPathUnits="userSpaceOnUse"><path d="M0 48 48 48 48 0 0 0 0 48Z"/></clipPath><clipPath clipPathUnits="userSpaceOnUse"/><clipPath clipPathUnits="userSpaceOnUse"/><clipPath clipPathUnits="userSpaceOnUse"><path d="M48 48 0 48 0 0 48 0 48 48Z"/></clipPath><clipPath clipPathUnits="userSpaceOnUse"><path d="M0 48 48 48 48 0 0 0 0 48Z"/></clipPath><clipPath clipPathUnits="userSpaceOnUse"/><clipPath clipPathUnits="userSpaceOnUse"/><clipPath clipPathUnits="userSpaceOnUse"><path d="M0 0 48 0 48 48 0 48 0 0Z"/></clipPath></defs><g transform="matrix(1.25 0 0 -1.25 0 60)"><path d="m24.1 44.3c-2.3 0-4.2-1.9-4.2-4.2 0-2.3 1.9-4.2 4.2-4.2 2.3 0 4.2 1.9 4.2 4.2 0 2.3-1.9 4.2-4.2 4.2zm11.6-4.4c-2.7 0-5-2.3-5-5 0-2.7 2.3-5 5-5 2.7 0 5 2.3 5 5 0 2.7-2.3 5-5 5zm-23-1c-2.1 0-3.8-1.7-3.8-3.8 0-2.1 1.7-3.8 3.8-3.8 2.1 0 3.8 1.7 3.8 3.8 0 2.1-1.7 3.8-3.8 3.8zM7.4 26.5c-1.8 0-3.2-1.4-3.2-3.2 0-1.8 1.4-3.2 3.2-3.2 1.8 0 3.2 1.4 3.2 3.2 0 1.8-1.4 3.2-3.2 3.2zm33.3 0c-1.8 0-3.2-1.4-3.2-3.2 0-1.8 1.4-3.2 3.2-3.2 1.8 0 3.2 1.4 3.2 3.2 0 1.8-1.4 3.2-3.2 3.2zM12.2 14.6c-1.8 0-3.2-1.4-3.2-3.2 0-1.8 1.4-3.2 3.2-3.2 1.8 0 3.2 1.4 3.2 3.2 0 1.8-1.4 3.2-3.2 3.2zm23.8 0c-1.8 0-3.2-1.4-3.2-3.2 0-1.8 1.4-3.2 3.2-3.2 1.8 0 3.2 1.4 3.2 3.2 0 1.8-1.4 3.2-3.2 3.2zM24.1 10.1c-1.8 0-3.2-1.4-3.2-3.2 0-1.8 1.4-3.2 3.2-3.2 1.8 0 3.2 1.4 3.2 3.2 0 1.8-1.4 3.2-3.2 3.2z" style="baseline-shift:baseline;block-progression:tb;color-interpolation-filters:linearRGB;color-interpolation:sRGB;color-rendering:auto;direction:ltr;font-family:sans-serif;font-size:medium;image-rendering:auto;isolation:auto;letter-spacing:normal;line-height:normal;mix-blend-mode:normal;shape-rendering:auto;solid-color:#000;solid-opacity:1;stroke-dashoffset:20;stroke-width:2;text-align:start;text-decoration-color:#000;text-decoration-line:none;text-decoration-style:solid;text-decoration:none;text-indent:0;text-rendering:auto;text-transform:none;white-space:normal;word-spacing:normal"/></g></svg>
    </div>
    <div class="c-login-form--input-group login-form--input-group-js">
        <input id="user_login" name="log" type="text" placeholder="Username or Email Address" />
        <input id="user_pass" type="password" name="pwd" placeholder="Password" />
    </div>
    <button type="submit" class="c-login-form--submit-btn login-form--submit-btn-js">
        <p>Submit</p>
    </button>
    <a href="<?= esc_url(wp_lostpassword_url()) ?>" class="c-login-form--forgot-link">
        Lost your password?
    </a>
</form>