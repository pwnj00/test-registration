<?php
/**
 * @var array $messages
 * @var string|null $username
 * @var int|null $remember
 */
?>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-collapse" id="bs-example-navbar-collapse-3">
            <a href="/signup/" class="btn btn-default navbar-btn">Sign up</a>
        </div>
    </div>
</nav>
<div class="container">
    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Sign in</div>
            </div>
            <div class="panel-body">
                <?php if (isset($messages['error'])): ?>
                    <div id="login-alert" class="alert alert-danger col-sm-12">
                        <?php foreach ($messages['error'] as $message): ?>
                            <p><?php print $message; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form id="loginform" action="/signin/" method="POST" class="form-horizontal" role="form">
                    <div class="input-group input-control <?php print (isset($messages['error']['username']) ? 'has-error' : '') ?>">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="login-username" type="text" class="form-control" name="username" value="<?php print (isset($username) ? $username : '') ?>" placeholder="username" required="required">
                    </div>
                    <div class="input-group input-control <?php print (isset($messages['error']['password']) ? 'has-error' : '') ?>">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="login-password" type="password" class="form-control" name="password" placeholder="password" required="required">
                    </div>
                    <div class="input-group">
                        <div class="checkbox">
                            <label>
                                <input id="login-remember" type="checkbox" name="remember" value="1" <?php print (isset($remember) && $remember ? 'checked="checked"' : '') ?>> Remember me
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 controls">
                            <input type="submit" id="btn-login" class="btn btn-success" value="Sign In">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>