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
        body{margin:0;padding:0;height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#7f00ff,#e100ff);color:#fff;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',sans-serif;}
        h1{font-size:3rem;margin-bottom:0;}
    </style>
</head>
<body>
    <h1><?php esc_html_e( 'Coming Soon', 'csm' ); ?></h1>
    <?php wp_footer(); ?>
</body>
</html>
