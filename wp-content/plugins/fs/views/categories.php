<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post">
        <div>
            <label for="fs_categories"><?php _e( 'Categories', 'fs' ); ?></label>
            <select
                multiple="multiple"
                name="fs_categories[]"
                id="fs_categories"
            >
                <?php foreach( $categories as $category ) { ?>
                    <option
                        <?php if( $category -> selected ) { ?>
                            selected
                        <?php } ?>
                        value="<?php echo $category -> slug; ?>"
                    >
                        <?php echo $category -> name; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <?php submit_button( __( 'Save' , 'fs' ) ); ?>
    </form>
</div>