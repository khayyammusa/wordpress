<div class="wrap">
    <div>
        <h1><?php _e( 'Balance' , 'casino' ); ?>: <b class="casino_balance"><?php echo $balance; ?></b></h1>
    </div>
    <div>
        <form class="casino_top_up_balance">
            <input type="number" name="casino_amount" required min="0" max="100">
            <button><?php _e( 'Top up balance' , 'casino' ); ?></button>
        </form>
    </div>
    <br>
    <div>
        <form class="casino_game">
            <select name="casino_amount" required>
                <option>1</option>
                <option>5</option>
                <option>10</option>
            </select>
            <button><?php _e( 'Play' , 'casino' ); ?></button>
        </form>
    </div>
</div>