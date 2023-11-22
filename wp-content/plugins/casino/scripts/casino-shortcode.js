(function ( blocks, editor, components, i18n )
{
    'use strict';

    var el = wp.element.createElement;
    var registerBlockType = blocks.registerBlockType;

    registerBlockType( 'casino/block', {
        title: 'casino',
        icon: 'controls-play',
        category: 'common',
        attributes: {},
        edit: function ( props )
        {
            return el(
                'div',
                null,
                'Casino'
            );
        },
        save: function ( props )
        {
            return el( 'div', null, '[casino][/casino]' );
        }
    } );
})(
    window.wp.blocks,
    window.wp.editor,
    window.wp.components,
    window.wp.i18n
);
