<style>

body{
	font-size: <?php echo get_option('theme_font_size');?>;
}

p{
	color: <?php echo get_option('body-color');?>;
}

a{
	color: <?php echo get_option('link-color');?>;
}
a:hover{
	color: <?php echo get_option('link-hover-color');?>;
}

a:active{
	color: <?php echo get_option('link-active-color');?>;
}

.navbar .nav > li > a{
	color: <?php echo get_option('nav-color');?>;
}

.navbar-inverse .nav > li > a:focus, 
.navbar-inverse .nav > li > a:hover{ /*Top level menu item*/
	color: <?php echo get_option('nav-hover-color');?>;
}

.navbar-inverse .navbar-inner{
	background-color: <?php echo get_option('nav-bg-color');?>;
}


/*Top level menu item*/
.navbar .nav > li.current_page_item a{ /*Top level current page item*/
	color: <?php echo get_option('nav-active-color');?>;
}



/*Sub-menu*/
.top-menu ul li ul li a{
	color: <?php echo get_option('sub-menu-color');?>;
}
.top-menu ul li ul li a:hover{
	color: <?php echo get_option('sub-menu-hover');?>;
}


</style>