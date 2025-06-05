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
        .csm-container{text-align:center;background:#fff;padding:40px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
        h1{font-size:2.5rem;margin-bottom:10px;}
        form{margin-top:20px;display:flex;flex-direction:column;gap:10px;}
        input{padding:10px;font-size:16px;border:1px solid #ddd;border-radius:4px;}
        button{padding:10px;font-size:16px;background:#7f00ff;color:#fff;border:none;border-radius:4px;cursor:pointer;}
    </style>
</head>
<body>
<div class="csm-container">
    <h1><?php esc_html_e( 'Coming Soon', 'csm' ); ?></h1>
    <p><?php esc_html_e( 'Subscribe to get notified when we launch.', 'csm' ); ?></p>
    <form id="csm-signup-form">
        <input type="text" name="name" placeholder="<?php esc_attr_e( 'Your Name', 'csm' ); ?>">
        <input type="email" name="email" required placeholder="<?php esc_attr_e( 'Email Address', 'csm' ); ?>">
        <button type="submit"><?php esc_html_e( 'Notify Me', 'csm' ); ?></button>
    </form>
    <div id="csm-signup-success" style="display:none;margin-top:10px;color:green;">
        <?php esc_html_e( 'Thank you for subscribing!', 'csm' ); ?>
    </div>
</div>
<script>
(function(){
    var form = document.getElementById('csm-signup-form');
    form.addEventListener('submit', function(e){
        e.preventDefault();
        var data = new FormData(form);
        data.append('action','csm_signup');
        data.append('nonce','<?php echo wp_create_nonce( 'csm_signup' ); ?>');
        fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {method:'POST', body:data})
            .then(function(res){return res.json();})
            .then(function(res){ if(res.success){form.style.display='none'; document.getElementById('csm-signup-success').style.display='block';}});
    });
})();
</script>
<?php wp_footer(); ?>
</body>
</html>
