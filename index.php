<?php 
    /*
    Plugin Name: IONIC Featured Image API for Wordpress
    Plugin URI: http://xyluz.com
    Description: You want to fetch featured image from your wordpress website for your ionic app
    Author: Seyi Onifade
    Version: 0.5
    Author URI: http://xyluz.com
    */


add_action( 'rest_api_init', 'appp_add_featured_urls' );
    
    function appp_add_featured_urls() {
        register_rest_field( array( 'post', 'product' ),
            'featured_image_urls',
            array(
                'get_callback'    => 'appp_featured_images',
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }

    function appp_featured_images( $post ) {
        
            $featured_id = get_post_thumbnail_id( $post['id'] );
        
            $sizes = wp_get_attachment_metadata( $featured_id );
        
            $size_data = new stdClass();
                    
            if ( ! empty( $sizes['sizes'] ) ) {
        
                foreach ( $sizes['sizes'] as $key => $size ) {
                    // Use the same method image_downsize() does
                    $image_src = wp_get_attachment_image_src( $featured_id, $key );
        
                    if ( ! $image_src ) {
                        continue;
                    }
                    
                    $size_data->$key = $image_src[0];
                    
                }
        
            }
        
            return $size_data;
            
        }
?>