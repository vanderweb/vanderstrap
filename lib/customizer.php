<?php
////////////////////////////////////////////////////////////////////
// Functions - Customizer
////////////////////////////////////////////////////////////////////
function vanderstrap_customize_register( $wp_customize ) {
    ////////////////////////////////////////////////////////////////////
    // Sidebar Settings
    $wp_customize->add_section( 'vanderstrap_settings' , array(
        'title'      => __( 'VanderStrap Settings', 'understrap-child' ),
        'priority'   => 30,
    ));
    
    // Header Control
    $wp_customize->add_setting('vanderstrap_headertoogle', array(
        'default'        => 'logomain',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control('vanderstrap_headertoogle', array(
        'label'      => __('Select Logo position', 'understrap-child'),
        'section'    => 'vanderstrap_settings',
        'settings'   => 'vanderstrap_headertoogle',
        'type'       => 'radio',
        'choices'    => array(
            'logomain' => __('Logo next to Main Menu', 'understrap-child'),
            'logotop' => __('Logo above Main Menu', 'understrap-child'),
        ),
    ));
    
    $wp_customize->add_setting('vanderstrap_headersticky', array(
        'default'        => 'sticky-top',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control('vanderstrap_headersticky', array(
        'label'      => __('Select Sticky Main Menu', 'understrap-child'),
        'section'    => 'vanderstrap_settings',
        'settings'   => 'vanderstrap_headersticky',
        'type'       => 'radio',
        'choices'    => array(
            'sticky-top' => __('Yes', 'understrap-child'),
            '' => __('No', 'understrap-child'),
        ),
    ));
    
    $wp_customize->add_setting('vanderstrap_navpos', array(
        'default'        => 'ml-auto',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control('vanderstrap_navpos', array(
        'label'      => __('Select Main Menu alignment', 'understrap-child'),
        'section'    => 'vanderstrap_settings',
        'settings'   => 'vanderstrap_navpos',
        'type'       => 'radio',
        'choices'    => array(
            'ml-auto' => __('Right', 'understrap-child'),
            'mr-auto' => __('Left', 'understrap-child'),
            'center' => __('Center', 'understrap-child'),
        ),
    ));
    
    ////////////////////////////////////////////////////////////////////
}
add_action( 'customize_register', 'vanderstrap_customize_register' );
?>