jQuery( document ).ready( function ( $ )
{
    $( document ).on( 'submit', '.casino_game', function ( e )
    {
        e.preventDefault();

        $.ajax( {
            type: 'POST',
            url: casino_ajax_object.ajax_url,
            data: {
                action: 'casino_play_game',
                casino_amount: e.target[ 0 ].value
            },
            success: function ( result )
            {
                if ( result )
                {
                    result = JSON.parse( result );

                    document.getElementsByClassName( 'casino_balance' )[0].textContent = result.balance;

                    if ( result.won ) alert( casino_ajax_object.congratulation_message );
                }

                else alert( casino_ajax_object.top_up_message );
            }
        } );
    } );


    $( document ).on( 'submit', '.casino_top_up_balance', function ( e )
    {
        e.preventDefault();

        $.ajax( {
            type: 'POST',
            url: casino_ajax_object.ajax_url,
            data: {
                action: 'casino_top_up_balance',
                casino_amount: e.target[ 0 ].value
            },
            success: function ( link )
            {
                if ( link ) location.href = link;

                else alert( casino_ajax_object.error_message );
            }
        } );
    } );
} );
