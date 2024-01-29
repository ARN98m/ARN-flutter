<div class="sidebar">
    <div class="logo-area"><img src="<?php echo $images . "logo.png" ?>" alt="" /> </div><i class="fas fa-bars toggle-menu"></i>
    <ul class="links-area">
        <li><a href="homePage.php" class="<?php activeLinkSide("HomePage") ?>"><?php echo lang('homePage') ?> </a></li>
        <li><a href="salesPage.php" class="<?php activeLinkSide("SalesPage") ?>"><?php echo lang('SalesPage') ?> </a></li>
        <li><a href="manage.php" class="<?php activeLinkSide("Manage") ?>"> <?php echo lang('manage') ?> </a></li>
        <li><a href="historyPage.php" class="<?php activeLinkSide("My history") ?>"><?php echo lang('historyPage') ?> </a></li>
        <li><a href="logout.php"><?php echo lang('logout') ?> </a></li>
    </ul>
</div>