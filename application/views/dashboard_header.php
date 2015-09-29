<header>
    <div class="navbar-fixed">
        <nav class="top-nav amber lighten-2">
            <div class="nav-wrapper">  
                <a class="brand-logo left">Panel de control</a>
                <a href="#" data-activates="nav-mobile" class="button-collapse">
                    <i class="material-icons">menu</i>
                </a>
                <ul class="right hide-on-med-and-down">
                    <li class="bold">
                        <a class="waves-effect waves-teal" href="<?php echo site_url('Dashboard_c/index'); ?>">
                            <span class="l-menu">Home</span>
                        </a>
                    </li>

                    <li class="bold">
                        <a class="waves-effect waves-teal" href="<?php echo site_url('Dashboard_c/estadisticas'); ?>"><span class="l-menu">Estadisticas</span></a>
                    </li>
                    <li class="bold">
                        <a class="waves-effect waves-teal" href="<?php echo site_url('Dashboard_c/seccion_mapas'); ?>"><span class="l-menu">Mapas</span></a>
                    </li>
                    <li class="bold">
                        <a id="fun" class="waves-effect waves-teal" href="<?php echo site_url('Dashboard_c/taxistas'); ?>" ><span class="l-menu">Taxistas</span></a>
                    </li>

                </ul>
                <ul class="side-nav" id="nav-mobile">

                    <li>
                        <a class="waves-effect waves-teal" href="<?php echo site_url('Dashboard_c/index'); ?>">
                            <span class="l-menu">Home</span>
                        </a>
                    </li>

                    <li>
                        <a class="waves-effect waves-teal" href="<?php echo site_url('Dashboard_c/estadisticas'); ?>"><span class="l-menu">Estadisticas</span></a>
                    </li>
                    <li>
                        <a class="waves-effect waves-teal" href="<?php echo site_url('Dashboard_c/seccion_mapas'); ?>"><span class="l-menu">Mapas</span></a>
                    </li>
                    <li>
                        <a class="waves-effect waves-teal" href="<?php echo site_url('Dashboard_c/taxistas'); ?>" ><span class="l-menu">Taxistas</span></a>
                    </li>
                    
                </ul>
            </div>      
        </nav>
    </div>
</header>
