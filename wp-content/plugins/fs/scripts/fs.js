jQuery( document ).ready( function ( $ )
{
    $( document ).on( 'submit', '.fs_remove_log', function ( e )
    {
        e.preventDefault();

        $.post( '/wp-admin/admin-ajax.php',
            {
                action: 'fs_remove_log',
                fs_log_id: e.target[ 0 ].value
            }, function ( data )
            {
                e.target.closest( 'tr' ).remove();
            }
        );
    } );
} );
