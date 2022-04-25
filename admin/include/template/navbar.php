<!--navbar.php-->
<nav style="color:#FFF "class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashbord.php"><?php echo lang('HOME')?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="app-nav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php if(getTitle() ==lang('SECTIONS')){ echo "activeLink"; } ?> " href="categores.php"><?php echo lang('SECTIONS')?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(getTitle() ==lang('ITEMS')){ echo "activeLink"; } ?> " href="items.php"><?php echo lang('ITEMS')?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(getTitle() ==lang('MEMBERS')){ echo "activeLink"; } ?> " href="members.php"><?php echo lang('MEMBERS')?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(getTitle() ==lang('STATISTICS')){ echo "activeLink"; } ?> " href="#"><?php echo lang('STATISTICS')?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(getTitle() ==lang('COMMENTS')){ echo "activeLink"; } ?> " href="comments.php"><?php echo lang('COMMENTS')?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(getTitle() ==lang('LOGS')){ echo "activeLink"; } ?> " href="#"><?php echo lang('LOGS')?></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php   echo lang('AdmainName')?>           
                    </a>
                    <div class="dropdown-menu <?php if(isset($ar)){echo 'rtl' ;}?>" aria-labelledby="navbarDropdown">
                        <a href="../index.php" class="dropdown-item">Visit Shop</a>
                        <a class="dropdown-item" href="members.php?do=Edit&adminId=<?php echo $_SESSION["adminId"]?>"><?php echo lang('EDITPROFILE')?> </a>
                        <a class="dropdown-item" href="#"><?php echo lang('SETTINGS')?> </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php"><?php echo lang('LOGOUT')?></a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
