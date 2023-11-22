<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <table class="form-table">
        <thead>
            <tr>
                <th><?php _e( 'ID', 'fs' ); ?></th>
                <th><?php _e( 'Post ID', 'fs' ); ?></th>
                <th><?php _e( 'Post title', 'fs' ); ?></th>
                <th><?php _e( 'Post link', 'fs' ); ?></th>
                <th><?php _e( 'Date', 'fs' ); ?></th>
                <th><?php _e( 'Delete', 'fs' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach( $logs as $log ) { ?>
                <tr>
                    <td><?php echo $log -> id; ?></td>
                    <td><?php echo $log -> post_id; ?></td>
                    <td><?php echo $log -> post_title; ?></td>
                    <td>
                        <a
                            target="_blank"
                            href="<?php echo $log -> post_link; ?>"
                        >
                            <?php echo $log -> post_link; ?>
                        </a>
                    </td>
                    <td><?php echo $log -> shared_at; ?></td>
                    <td>
                        <form class="fs_remove_log">
                            <input
                                type="hidden"
                                name="fs_log_id"
                                value="<?php echo $log -> id; ?>"
                            >
                            <?php submit_button( '❌' ); ?>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>