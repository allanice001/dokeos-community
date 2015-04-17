<?php
require_once(api_get_path(SYS_CODE_PATH) . 'inc/lib/banner.lib.php');

//Give a default value to $charset. Should change to UTF-8 some time in the future.
//This parameter should be set in the platform configuration interface in time.
$charset = api_get_setting('platform_charset');
if (empty($charset)) {
    $charset = 'ISO-8859-15';
}

// Get language iso-code for this page - ignore errors
// The error ignorance is due to the non compatibility of function_exists()
// with the object syntax of Database::get_language_isocode()
@$document_language = Database::get_language_isocode($language_interface);
if (empty($document_language)) {
    //if there was no valid iso-code, use the english one
    $document_language = 'en';
}
header('Content-Type: text/html; charset=' . $charset);
header('X-Powered-By: Dokeos');
global $_course;
?>
<!DOCTYPE html>
<html lang="<?php echo $document_language; ?>" class="no-js">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>">
        <!--[if ie]><meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php
            if (!empty($_course['official_code'])) {
                echo $_course['name'] . ' - ';
            }
            echo $_course['official_code'];
            $include_library_path = api_get_path(WEB_LIBRARY_PATH) . 'javascript/responsive/';
            $normal_include_library_path = api_get_path(WEB_LIBRARY_PATH) . 'javascript/';
            ?>
        </title>
        <link rel="shortcut icon" href="images/favicon.ico" />
        <link rel="stylesheet" href="<?php echo api_get_path(WEB_CODE_PATH) ?>exercice/exam_mode/js/jquery-ui.css" />
        <link rel="stylesheet" href="<?php echo $include_library_path; ?>css/jquery.mCustomScrollbar.min.css" />
        <link rel="stylesheet" href="<?php echo $include_library_path; ?>css/jquery.tagit.min.css" /> 
        <link rel="stylesheet" href="<?php echo api_get_path(WEB_CSS_PATH); ?>custom-bootstrap-responsive.css" /> 
        
        <!--<link rel="stylesheet" href="<?php
        echo api_get_path(WEB_CSS_PATH);
        ;
        ?>../reporting/css/style.css" />--> <!this file is copy of exam mode-->
    <link rel="stylesheet" href="<?php echo api_get_path(WEB_CSS_PATH); ?>base.css" />
    <link rel="stylesheet" href="<?php echo api_get_path(WEB_CSS_PATH); ?>base_dokeos.css" />
    <link rel="stylesheet" href="<?php echo api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets'); ?>/icons_responsive.css" />
    <link rel="stylesheet" href="<?php echo api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets'); ?>/default_responsive.css" />
    <script src="<?php echo $include_library_path; ?>js/jquery.min.js"></script>


    <script type="text/javascript" src="<?php echo api_get_path(WEB_LIBRARY_PATH) . 'javascript/jquery-1.4.2.min.js' ?>" language="javascript"></script>
    <script type="text/javascript" src="<?php echo api_get_path(WEB_LIBRARY_PATH) . 'javascript/jquery-ui/js/jquery-ui-1.8.1.custom.min.js'; ?>"></script>
    <link type="text/css" href="<?php echo api_get_path(WEB_LIBRARY_PATH) . 'javascript/jquery-ui/css/ui-lightness/jquery-ui-1.8.1.custom.css'; ?>" rel="stylesheet" />
    <script src="<?php echo $include_library_path; ?>js/jwplayer.js"></script>
    <script src="<?php echo $include_library_path; ?>js/jquery.mousewheel.min.js"></script>
    <script src="<?php echo $include_library_path; ?>js/jquery.form.min.js"></script>
    <script src="<?php echo $include_library_path; ?>js/jquery.browser.min.js"></script>
    <script src="<?php echo $include_library_path; ?>js/jquery.tag-it.min.js"></script>
    <script src="<?php echo $include_library_path; ?>js/respond.min.js"></script>
    <script src="<?php echo $include_library_path; ?>js/modernizr.js"></script>
    
    
    
    
    
    <script type="text/javascript">
            $(document).ready(function() {
                $('a.logoutClick').click(function(event) {
                    event.preventDefault();
                    //LogOut.clicklogout($(this));
                    $('#logoutMsgBody').dialog({
                            modal: true, 
                            title: 'Logout', 
                            height: '230', 
                            width: '350px', 
                            resizable: false,
                            buttons: {
                                '<?php echo get_lang('No'); ?>': function() {
                                    $(this).dialog('close');
                                },
                                '<?php echo get_lang('Yes'); ?>': function() {
                                    window.location =" <?php echo api_get_path(WEB_PATH) . 'index.php?logout=logout&uid=' . $_user['user_id']; ?>";
                                }
                            }
                        });
                });
            });

            

            function h_search(){
                var input = $('#search-text-input').val();
                var loader = $('#h_loader');
                $('#main').html("");
                loader.show();
                $('#main').html('<div id="content"><div id="h_loader"><br /><br />' + '<?php echo get_lang('Searching') . '&nbsp;'; ?>'+'<strong>'+input+'</strong>' +'...</div></div>');
                // ajax request to show results
                $.ajax({
                    url: '<?php echo api_get_path(WEB_CODE_PATH) . 'search/get_results.ajax.php' ?>',
                    cache: false,
                    data: 'input='+input,
                    success: function(html){
                        h_showResults();
                        $('#main').html("<div id='content'><div id='result'>"+html+"</div></div>");
                    }
                });
                return false;
            }

            function h_showResults(){
                var loader = $('#h_loader');
                var result = $('#main');
                loader.hide();
                result.fadeIn();
            }

            function h_hideResults(){
                var result = $('#main');
                var form = $('#search_form');
                result.hide();
                form.fadeIn();
                $('#input').focus();
            }

            // intercept "enter" to submit form
            $(document).ready(function(){
                $('#input').focus();
                if (jQuery.browser.msie && jQuery.browser.version <= 7) {
                    $("#dokeostabs li span").css("margin-top","11px");
                }
            });
        </script>
        
        <!--[if IE 8]>
<style type="text/css">
        
    div.logout-new {
        border:none !important;
        background-color:transparent !important;
    }
        
    .responsive-tabs__list__item {
        background: none repeat scroll 0 0 #EEEEEE;
        border: 0 solid #FF0000;
        border-radius: 10px 10px 0 0;
        margin-right: 1em;
        padding: 1% 4%;
    }    
        ul.responsive-tabs__list {
        margin-top: 20px !important;
        
    }
        
        .edit-logo {
        border:1px solid red !important;
        position:absolute;
        right:10px;
        }
        
</style>
<![endif]-->
        
        
    <?php
    // Display all $htmlHeadXtra
    if (isset($htmlHeadXtra) && $htmlHeadXtra) {
        foreach ($htmlHeadXtra as $this_html_head) {
            echo($this_html_head);
        }
    }

    $path_logo = api_get_path(SYS_PATH) . 'home/logo/'; //logo-dokeos
    if (count(glob($path_logo . '*')) > 1) {
        foreach (glob($path_logo . '*') as $path_file) {

            $new_file_path = pathinfo($path_file);
            if ($new_file_path['extension'] == 'gif' || $new_file_path['extension'] == 'png' || $new_file_path['extension'] == 'jpg' || $new_file_path['extension'] == 'jpeg') {
                $logo_path = '../../home/logo/' . $new_file_path['basename'];
            }
        }
    } else {
        $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/logo-text.png';
    }
    $iurl = api_get_setting('InstitutionUrl');
    $iname = api_get_setting('Institution');
    ?>   

</head>
<body>
    <?php
    echo '<div style="display:none;" id="logoutMsgBody">';
    echo '<center><img alt="' . get_lang('AreYouSureAreCloseSession') . '" title="' . get_lang('AreYouSureAreCloseSession') . '" src="' . api_get_path(WEB_IMG_PATH) . 'logout-tab.png" style="vertical-align:text-bottom;" /><br/>' . get_lang('AreYouSureAreCloseSession') . '</center>';
    echo '</div>';
    ?>
    <!--<div id="wrapper">-->
    <div class="row-fluid">
        <div class="span12 custom-back-header">
            <div id="main" class="container">

                <header>
                    <div class="row-fluid back-image">

                        <div class="span4" style="position:relative"> 
                            <div id="logo">
                                <a href="<?php echo api_get_path(WEB_PATH); ?>"> 
                                    <img alt="<?php echo $iname; ?>" src="<?php echo $logo_path; ?>" title="<?php echo $iname; ?>">
                                </a>
                                <?php if (api_is_platform_admin()) { ?>

									<a  href="<?php echo api_get_path(WEB_PATH) . 'main/admin/configure_homepage.php?action=logo'; ?>">
										<span class="edit-logo" style="float: left;    margin-left: 202px;    margin-top: -35px; width:55px; ">
											<?php echo Display::return_icon('pixel.gif', get_lang('EditLogo'), array('class' => 'actionplaceholdericon actionedit')) . get_lang('Logo'); ?> 
										</span>
									</a>

                                    <?php
                                }
                                ?>
                            </div>                           

                        </div>

                        <div class="span4 custom-title-header">
                            <a href="<?php echo api_get_path(WEB_PATH); ?>index.php" target="_top"><?php echo api_get_setting('siteName') ?></a>
                            <?php
                            $iname = api_get_setting('Institution');
                            if (!empty($iname)) {
                                echo '-&nbsp;<a href="' . $iurl . '" target="_top">' . $iname . '</a>';
                            }
                            ?>
                        </div>

                        <!--                            <div class="span4 custom-title-header">
                                                        The section is for E-commerce
                                                    </div>-->
                        <!--<div class="span5" id="header_right"></div> -->
                    </div>


                </header>

            </div>
        </div>
    </div>




    <div class="row-fluid">
        <div class="span12">

            <div class="navbar navbar-inverse">
                <div class="navbar-inner">
                    <div class="container">

                        <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                        <a href="<?php echo api_get_path(WEB_PATH); ?>" class="brand" style="display: none;"><?php echo $iname; ?></a>

                        <!-- Be sure to leave the brand out there if you want it shown -->
                        <!--<a class="brand" href="#">Project name</a>asd-->

                        <!-- Everything you want hidden at 940px or less, place within here -->
                        <div class="nav-collapse collapse">
                            <!-- .nav, .navbar-search, .navbar-form, etc -->

                            
                            <div class="new-logout" style="width:55px;float:right; overflow:hidden; height:48px;">
<!--                                    <a href="<?php echo api_get_path(WEB_PATH) . 'index.php'; ?>?logout=logout&<?php echo api_get_user_id(); ?>" title="<?php echo get_lang('Logout'); ?>" class="logout logoutClick" id="logout_button">
                                        <div class="logout-reporting"><img src="<?php echo api_get_path(WEB_IMG_PATH); ?>close.png" alt="<?php echo get_lang('Logout'); ?>" />  <?php echo get_lang('Logout') . ' ' . $login; ?></div>                          
                                    </a>-->
                                  <div class="logout-new">
                   <a class="logoutClick image-logout" href="<?php echo api_get_path(WEB_PATH) . 'index.php'; ?>?logout=logout&<?php echo api_get_user_id(); ?>"></a>
                </div>  
                            </div>
                            
                            
                            
                            <div id="dokeostabs">
                                <a id="prev2" class="prevbar" href="#"></a>
                                <a id="next2" class="nextbar" href="#"></a>
                                <div class="list_carousel">
                                <ul id="foo2" class="nav">
                            
                            
                            <!--<ul class="nav">-->
                               <!-- <?php
                                global $_user, $_course;
                                if (api_get_setting('show_tabs', 'campus_homepage') == 'true') {
                                    ?>
                                    <li>
                                        <a target="_top" href="<?php echo api_get_path(WEB_PATH); ?>index.php"><img alt="<?php echo get_lang('Home'); ?>" class="align-icons" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/home.png'; ?>" /><?php echo get_lang('Home'); ?></a>
                                    </li>
                                    <?php
                                }
                                if ($_user['user_id'] && !api_is_anonymous()) {
                                    if (api_get_setting('show_tabs', 'my_courses') == 'true') {
                                        ?>
                                        <li>
                                            <a target="_top" href="<?php echo api_get_path(WEB_PATH); ?>user_portal.php"><img alt="<?php echo get_lang('MyCourses'); ?>" class="align-icons" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/course.png'; ?>" /><?php echo get_lang('MyCourses'); ?></a>
                                        </li>
                                        <?php
                                    }
                                    if (api_get_setting('show_tabs', 'my_profile') == 'true') {
                                        $profile_link = api_get_path(WEB_CODE_PATH) . 'auth/profile.php' . (!empty($_course['path']) ? '?coursePath=' . $_course['path'] . '&amp;courseCode=' . $_course['official_code'] : '' );
                                        ?>
                                        <li>
                                            <a target="_top" href="<?php echo $profile_link; ?>"><img alt="<?php echo get_lang('MyCourses'); ?>" class="align-icons" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/profile.png'; ?>" /><?php echo get_lang('ModifyProfile'); ?></a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li class="active" id="current">
                                        <a target="_top" href="<?php echo api_get_path(WEB_CODE_PATH); ?>reporting/index.php"><img alt="<?php echo get_lang('MySpace'); ?>" class="align-icons" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/reporting_na.png'; ?>" /><?php echo get_lang('MySpace'); ?></a>
                                    </li>
                                    <?php
                                    if (api_get_setting('show_tabs', 'social') == 'true') {
                                        ?>
                                        <li>
                                            <a target="_top" href="<?php echo api_get_path(WEB_CODE_PATH); ?>social/home.php"><img alt="<?php echo get_lang('SocialNetwork'); ?>" class="align-icons" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/social.png'; ?>" /><?php echo get_lang('SocialNetwork'); ?></a>
                                        </li>                                
                                        <?php
                                    }
                                    if (api_get_setting('show_tabs', 'my_agenda') == 'true') {
                                        ?>
                                        <li>
                                            <a target="_top" href="<?php echo api_get_path(WEB_CODE_PATH); ?>calendar/myagenda.php"><img alt="<?php echo get_lang('MyAgenda'); ?>" class="align-icons" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/calendar.png'; ?>" /><?php echo get_lang('MyAgenda'); ?></a>
                                        </li>
                                        <?php
                                    }
                                    if (api_is_platform_admin(true)) {
                                        if (api_get_setting('show_tabs', 'platform_administration') == 'true') {
                                            ?>
                                            <li>
                                                <a target="_top" href="<?php echo api_get_path(WEB_CODE_PATH); ?>admin/index.php"><img alt="<?php echo get_lang('PlatformAdmin'); ?>" class="align-icons" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/admin.png'; ?>" /><?php echo get_lang('PlatformAdmin'); ?></a>
                                            </li>

                                            <?php
                                            if ((api_get_setting('show_tabs', 'search') == 'true') || (api_get_setting('search_enabled') == 'true')) {

                                                if ((!api_is_anonymous($_user['user_id'], true))) {
                                                    echo "<li>";
                                                    if ((api_get_setting('search_enabled') == 'true') && extension_loaded('xapian') && !api_is_anonymous()) {
                                                    ?>
                                            <form  method="post" action="#" onsubmit="return h_search();" style="position:relative; margin-left:5px; margin-right: 5px; margin-top:11px;"> 
                                                        <span>
                                                            <input class="search-reporting" type="text" name="input" class="input-h-search" id="search-text-input"></input>
                                                        </span>
                                                        <span>
                                                            <button style="" type="image" src="<?php echo api_get_path(WEB_IMG_PATH) . 'button_search.png'; ?>" id="btn-h-search"/></button>
                                                        </span>
                                                    </form>
                                                    <?php
                                                    }

                                                    echo "</li>";
                                                }
                                            }
                                            ?>
                                            <?php
                                        }
                                    }
                                }


                                if ($_user['user_id'] && !api_is_anonymous($_user['user_id'], true)) {
                                    $login = '';
                                    if (api_is_anonymous($_user['user_id'], true)) {
                                        $login = '(' . get_lang('Anonymous') . ')';
                                    } else {
                                        $uinfo = api_get_user_info(api_get_user_id());
                                        $login = '(' . $uinfo['username'] . ')';
                                    }
                                }
                                ?>-->
                                
                                
                                <?php
                                
                                // Display Tabs --------------------------------------------------
                                $possible_tabs = get_tabs();
        
                                if(isset($possible_tabs[SECTION_CAMPUS]))
                                    $navigation[SECTION_CAMPUS] = $possible_tabs[SECTION_CAMPUS];       

                                // logged
                                if ($_user['user_id'] && !api_is_anonymous()){
                                    $navigation = $possible_tabs;

                                // anonymous
                                } else {
                                    foreach($possible_tabs as $section => $navigation_info){
                                        if($navigation_info['link_type'] != MENULINK_TYPE_PLATFORM)
                                            $navigation[$section] = $possible_tabs[$section];
                                    }
                                }
                                
                                // Displaying the tabs        
                                foreach ($navigation as $section => $navigation_info) {
                                    // platform links
                                    if($navigation_info['link_type'] == 'platform' or $section == 'search'){
                                        if (isset($GLOBALS['this_section'])) {
                                            $current        = ($section == $GLOBALS['this_section'] ? ' id="current" class="tab_' . $section . '_current"' : ' class="tab_' . $section . '"');
                                            $class_icon_tab = ($section == $GLOBALS['this_section'] ? ' class="icon_tab_' . $section . '_current"' : ' class="icon_tab_' . $section . '"');
                                            $get_my_class   = 'tab_'. $section;
                                        } else {
                                            $current        = 'class="tab_'. $section .'"';
                                            $get_my_class   = 'tab_'. $section;
                                        }

                                        if ((!api_is_anonymous($_user['user_id'], true)) || $get_my_class == 'tab_mycampus') {
                                            echo "<li " . $current . ">";
                                            if ($section == "search") {
//                                                if (/*api_get_setting('search_enabled') == 'true' &&*/ extension_loaded('xapian') && !api_is_anonymous()) {
                                                    ?>
                                                    <form  method="post" action="#" onsubmit="return h_search();" style="position:relative;"> 
                                                        <!--<span>-->
                                                            <input type="text" name="input" class="input-h-search" id="search-text-input"></input>
                                                        <!--</span>-->
                                                        <!--<span>-->
                                                            <button style="" type="image" src="<?php echo api_get_path(WEB_IMG_PATH) . 'button_search.png'; ?>" id="btn-h-search"/></button>
                                                        <!--</span>-->
                                                    </form>
                                                    <?php
//                                                }
                                            } else {
                                                echo "<a href='" . $navigation_info['url'] . "' target='". $navigation_info['target']. "'>" . $navigation_info['title'] . "</a>";
                                            }
                                            echo "</li>";
                                        }

                                    // other links    
                                    } else {
                                    ?>
                                        <li class="tab_link"><a href="<?php echo $navigation_info['url']; ?>" target="<?php echo $navigation_info['target']; ?>"><?php echo $navigation_info['title']; ?></a></li>
                                    <?php
                                    }

                                }
                                // Display Tabs --------------------------------------------------
                                
                                ?>
<!--                                <li>
                                    <a href="<?php echo api_get_path(WEB_PATH) . 'index.php'; ?>?logout=logout&<?php echo api_get_user_id(); ?>" title="<?php echo get_lang('Logout'); ?>" class="logout logoutClick" id="logout_button">
                                        <div class="logout-reporting"><img src="<?php echo api_get_path(WEB_IMG_PATH); ?>close.png" alt="<?php echo get_lang('Logout'); ?>" />  <?php echo get_lang('Logout') . ' ' . $login; ?></div>                          
                                    </a>
                                </li>-->
                            </ul>
                            
                            
                        </div>
                    </div>
                        
                        </div>

                    </div>
                </div>
            </div>
            </div>
            </div>

            <!--                <div class="navbar subnav">
                                <div class="navbar-inner">
            
            
                                    <div class="container">
                                        <a class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse">              
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </a>
                                        <a href="<?php echo api_get_path(WEB_PATH); ?>" class="brand" style="display: none;"><?php echo $iname; ?></a>
                                        <div class="nav-collapse collapse">
                                            <div class="span9">
                                                <ul class="nav">
                                                    <li>
                                                        <a target="_top" href="<?php echo api_get_path(WEB_PATH); ?>index.php"><img alt="<?php echo get_lang('Home'); ?>" style="padding-right:5px;" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/home.png'; ?>" /><?php echo get_lang('Home'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a target="_top" href="<?php echo api_get_path(WEB_PATH); ?>user_portal.php"><img alt="<?php echo get_lang('MyCourses'); ?>" style="padding-right:5px;" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/course.png'; ?>" /><?php echo get_lang('MyCourses'); ?></a>
                                                    </li>
                                                    <li class="active" id="current">
                                                        <a target="_top" href="<?php echo api_get_path(WEB_CODE_PATH); ?>reporting/reporting.php"><img alt="<?php echo get_lang('MySpace'); ?>" style="padding-right:5px;" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/reporting_na.png'; ?>" /><?php echo get_lang('MySpace'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a target="_top" href="<?php echo api_get_path(WEB_CODE_PATH); ?>calendar/myagenda.php"><img alt="<?php echo get_lang('MyAgenda'); ?>" style="padding-right:5px;" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/calendar.png'; ?>" /><?php echo get_lang('MyAgenda'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a target="_top" href="<?php echo api_get_path(WEB_CODE_PATH); ?>social/home.php"><img alt="<?php echo get_lang('SocialNetwork'); ?>" style="padding-right:5px;" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/social.png'; ?>" /><?php echo get_lang('SocialNetwork'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a target="_top" href="<?php echo api_get_path(WEB_CODE_PATH); ?>admin/index.php"><img alt="<?php echo get_lang('PlatformAdmin'); ?>" style="padding-right:5px;" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/tool/header/admin.png'; ?>" /><?php echo get_lang('PlatformAdmin'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
            
                                            <div class="span3 pull-right">
            
                                                <ul class="nav pull-right">
                                                    <li class="dropdown">
                                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                                            <img alt="<?php echo get_lang('Image'); ?>" src="<?php echo $logo_path = api_get_path(WEB_CSS_PATH) . api_get_setting('stylesheets') . '/images/action/unknown.png'; ?>" />
            <?php
            global $_user;
            echo $_user['firstname'] . '&nbsp;' . $_user['lastname'];
            ?>
                                                            <b class="caret"></b>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="<?php echo api_get_path(WEB_CODE_PATH) . 'calendar/myagenda.php'; ?>"> <?php echo get_lang("Calendar_event"); ?></a>
                                                                <a href="<?php echo api_get_path(WEB_CODE_PATH) . 'messages/inbox.php?f=social'; ?>"><?php echo get_lang('Inbox'); ?></a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo api_get_path(WEB_PATH) . 'index.php'; ?>?logout=logout&<?php echo api_get_user_id(); ?>" title="<?php echo get_lang('Logout'); ?>" class="logout" id="logout_button">
                                                            <img src="<?php echo api_get_path(WEB_IMG_PATH); ?>close_na.png" alt="<?php echo get_lang('Logout'); ?>" />  <?php echo get_lang('Logout'); ?>                          
                                                        </a>
                                                    </li>   
                                                </ul>
                                            </div>
            
            
                                        </div>
                                    </div>
            
                                </div>
                            </div>-->





        </div>
    </div>

    <!--</div>-->

<script src="<?php echo $include_library_path; ?>js/bootstrap.min.js"></script>
 
<?php 

echo '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jquery.carouFredSel-6.2.1.js"></script>';
echo '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jquery.carouFredSel-6.2.1.js"></script>';
echo '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/helper-plugins/jquery.touchSwipe.min.js"></script>';
echo '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/helper-plugins/jquery.transit.min.js"></script>';
echo '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/helper-plugins/jquery.ba-throttle-debounce.min.js"></script>';
echo "
<script>
			$(function() {
				$('#foo2').carouFredSel({
					auto: false,
                                        circular: false,
                                        infinite: false,
					prev: '#prev2',
					next: '#next2',
					pagination: \"#pager2\",
					mousewheel: true,
					swipe: {
						onMouse: true,-
						onTouch: true
					}
				});
			});
</script>";
    
    ?>
    
    <div id="wrapper">
        <div class="container">
            <div id="dokeos_content">
                <!--<div id ="top_main_content" class="row">-->
                
                
 