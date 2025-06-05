<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo( 'name' ); ?> - <?php esc_html_e( 'Coming Soon', 'csm' ); ?></title>
    <?php wp_head(); ?>
    <style>
        body{margin:0;padding:0;height:100vh;display:flex;align-items:center;justify-content:center;background:#f5f5f5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',sans-serif;}
        .csm-container{text-align:center;}
        h1{font-size:3rem;margin-bottom:20px;}
    </style>
</head>
<body>
<div class="csm-container">
    <h1><?php esc_html_e( 'Coming Soon', 'csm' ); ?></h1>
    <p><?php esc_html_e( 'We are working hard to launch our new website.', 'csm' ); ?></p>
</div>
<?php wp_footer(); ?>
</body>
</html>
