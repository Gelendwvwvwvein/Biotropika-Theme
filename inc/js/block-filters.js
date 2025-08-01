/**
 * inc/js/block-filters.js
 *
 * 1) Добавляет атрибут isHidden (boolean) ко всем блокам biotropika/*
 * 2) Вставляет в боковую панель чекбокс "Скрыть блок в продакшене"
 * 3) Не выводит скрытый блок на фронтенде
 */
(function() {
    const { addFilter } = wp.hooks;
    const { createHigherOrderComponent } = wp.compose;
    const { createElement, Fragment } = wp.element;
    const { InspectorControls } = wp.blockEditor || wp.editor;
    const { PanelBody, CheckboxControl } = wp.components;

    // 0) Расширяем metadata блоков, объявляя новый атрибут
    addFilter(
        'blocks.registerBlockType',
        'biotropika/extend-attributes',
        (settings, name) => {
            if ( name.startsWith('biotropika/') ) {
                settings.attributes = Object.assign(
                    {},
                    settings.attributes,
                    {
                        isHidden: {
                            type: 'boolean',
                            default: false,
                        },
                    }
                );
            }
            return settings;
        }
    );

    // 1) HOC для добавления панели с чекбоксом
    const withHideControl = createHigherOrderComponent(
        (BlockEdit) => {
            return (props) => {
                const { name, attributes, setAttributes } = props;

                // Только для своих блоков
                if ( ! name.startsWith('biotropika/') ) {
                    return createElement(BlockEdit, props);
                }

                const isHidden = !!attributes.isHidden;

                return createElement(
                    Fragment,
                    {},
                    createElement(BlockEdit, props),
                    createElement(
                        InspectorControls,
                        {},
                        createElement(
                            PanelBody,
                            {
                                title: 'Отображение блока',
                                initialOpen: false,
                            },
                            createElement(CheckboxControl, {
                                label: 'Скрыть блок в продакшене',
                                checked: isHidden,
                                onChange: () =>
                                    setAttributes({ isHidden: ! isHidden }),
                            })
                        )
                    )
                );
            };
        },
        'withHideControl'
    );

    // 2) Не рендерим на фронт, если isHidden=true
    function overrideSave(element, blockType, attributes) {
        if (
            blockType.name.startsWith('biotropika/') &&
            attributes.isHidden
        ) {
            return null;
        }
        return element;
    }

    // 3) Регистрируем фильтры
    addFilter(
        'editor.BlockEdit',
        'biotropika/hide-block-control',
        withHideControl
    );

    addFilter(
        'blocks.getSaveElement',
        'biotropika/hide-block-override',
        overrideSave
    );
})();
