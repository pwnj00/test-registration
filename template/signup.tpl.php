<?php
/**
 * @var array $messages
 * @var string|null $username
 */
?>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-collapse" id="bs-example-navbar-collapse-3">
            <a href="/signin/" class="btn btn-default navbar-btn">Sign in</a>
        </div>
    </div>
</nav>
<div class="container">
    <div id="signupbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Sign Up</div>
            </div>
            <div class="panel-body">
                <form id="signupform" action="/signup/" method="POST" class="form-horizontal" role="form">
                    <?php if (isset($messages['error'])): ?>
                        <div id="signup-alert" class="alert alert-danger col-sm-12">
                            <?php foreach ($messages['error'] as $message): ?>
                                <p><?php print $message; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="signup-username" class="col-md-3 control-label">Username</label>

                        <div class="col-md-9">
                            <input id="signup-username" type="text" class="form-control" name="username" value="<?php print (isset($username) ? $username : '') ?>" placeholder="username" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="signup-password" class="col-md-3 control-label">Password</label>

                        <div class="col-md-9">
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="password" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="submit" id="btn-signup" class="btn btn-info" value="Sign Up">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>