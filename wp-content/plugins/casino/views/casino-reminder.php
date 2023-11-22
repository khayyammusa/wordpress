<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <br>
    <form method="post">
        <div>
            <label for="casino_reminder_hour"><?php _e( 'Set timer', 'casino' ); ?></label>
            <select name="casino_reminder_hour" id="casino_reminder_hour">
                <?php for( $h = 0; $h <= 23; $h++ ) { ?>
                    <option
                        <?php if( $selected_hour == $h ) { ?>
                            selected
                        <?php } ?>
                        value="<?php echo $h; ?>"
                    >
                        <?php echo casino_beautify_time( $h ); ?>
                    </option>
                <?php } ?>
            </select>
            <select name="casino_reminder_minute" id="casino_reminder_minute">
                <?php for( $m = 0; $m <= 55; $m += 5 ) { ?>
                    <option
                        <?php if( $selected_minute == $m ) { ?>
                            selected
                        <?php } ?>
                        value="<?php echo $m; ?>"
                    >
                        <?php echo casino_beautify_time( $m ); ?>
                    </option>
                <?php } ?>
            </select>
            <div>
                <label for="casino_delay"><?php _e( 'Delay', 'casino' ); ?></label>
                <input name="casino_delay" type="number" min="0" max="10" required value="<?php echo $delay; ?>">
            </div>
        </div>
        <?php submit_button( __( 'Set reminder' , 'fs' ) ); ?>
    </form>
</div>