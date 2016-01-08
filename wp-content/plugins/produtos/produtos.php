<?php
/*Plugin Name: Produto Post Type
 Description: plugin para registrar os produtos.
Version: 1.0
License: GPLv2
*/
add_action( 'init', 'produto_post_type', 0 );
add_action( 'admin_init', 'my_admin' );
add_action( 'save_post', 'add_produtos_fields', 10, 2 );
add_filter( 'template_include', 'include_template_function', 1 );

// Register Custom Post Type
function produto_post_type() {

	$labels = array(
		'name'                  => _x( 'Produtos', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Produto', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Produtos', 'text_domain' ),
		'name_admin_bar'        => __( 'Produtos', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Listar todos', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Novo', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Produto', 'text_domain' ),
		'description'           => __( 'Descrição do produto', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'produtos', $args );

}


function my_admin() {
    add_meta_box( 'produtos_meta_box',
    'Detalhes do Produto',
    'display_produtos_meta_box',
    'produtos', 'normal', 'high'
        );
}

function display_produtos_meta_box( $produto ) {
    $produto_preco = intval( get_post_meta( $produto->ID, 'produto_preco', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 100%">Preço</td>
            <td><input type="text" size="80" name="produto_preco" value="<?php echo $produto_preco; ?>" /></td>
        </tr>
    </table>
    <?php
}

function add_produtos_fields( $produto_id, $produto ) {
    if ( $produto->post_type == 'produtos' ) {
        if ( isset( $_POST['produto_preco'] ) && $_POST['produto_preco'] != '' ) {
            update_post_meta( $produto_id, 'produto_preco', $_POST['produto_preco'] );
        }
    }
}

function include_template_function( $template_path ) {
    if ( get_post_type() == 'produtos' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array ( 'single-produtos.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-produtos.php';
            }
        }
    }
    return $template_path;
}
?>