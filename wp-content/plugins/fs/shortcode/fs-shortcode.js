(function ( blocks, editor, components, i18n )
{
    'use strict';

    var el = wp.element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var SelectControl = components.SelectControl;

    registerBlockType( 'fs/select-block', {
        title: 'FS',
        icon: 'admin-appearance',
        category: 'common',
        attributes: {
            selectedOption: {
                type: 'string',
                default: 'light'
            }
        },
        edit: function ( props )
        {
            var selectedOption = props.attributes.selectedOption;

            function onChangeSelect( newOption )
            {
                props.setAttributes( { selectedOption: newOption } );
            }

            var options = [
                { label: 'Light', value: 'light' },
                { label: 'Dark', value: 'dark' }
            ];

            return el(
                'div',
                null,
                el(
                    SelectControl,
                    {
                        label: 'Select theme',
                        value: selectedOption,
                        options: options,
                        onChange: onChangeSelect
                    }
                )
            );
        },
        save: function ( props )
        {
            var selectedOption = props.attributes.selectedOption;

            return el( 'div', null, '[' + 'fs style=' + selectedOption + ']' + '[/' + 'fs]' );
        }
    } );
})(
    window.wp.blocks,
    window.wp.editor,
    window.wp.components,
    window.wp.i18n
);
