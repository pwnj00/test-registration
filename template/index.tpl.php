<?php
/**
 * @var $user
 */
?>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-collapse" id="bs-example-navbar-collapse-3">
            <a href="/logout/" class="btn btn-default navbar-btn">Exit</a>
        </div>
    </div>
</nav>
<div class="container">
    <div id="userbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">User</div>
            </div>
            <div class="panel-body">
                <p>Username: <?php print $user['username']; ?></p>

                <p>IP: <?php print $user['ip']; ?></p>

                <p>Created: <?php print date('d.m.Y H:i:s', $user['created']); ?></p>

                <p>Last visited: <?php print date('d.m.Y H:i:s', $user['visited']); ?></p>
            </div>
        </div>
    </div>
</div>