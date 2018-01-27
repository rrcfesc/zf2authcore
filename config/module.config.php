<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore;


return array(
    'modules' => array(
        'Rioxygen\Zf2AuthCore',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/{,*.}{global,local}.php',
        ),
    ),
    'service_manager' => array(
        
    )
);