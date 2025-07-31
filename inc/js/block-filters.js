import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';

/**
 * 1) Расширяем все блоки новым булевым атрибутом isHidden.
 */
addFilter(
  'blocks.registerBlockType',
  'biotropika/extend-attributes',
  (settings) => {
    settings.attributes = {
      ...settings.attributes,
      isHidden: {
        type: 'boolean',
        default: false,
      },
    };
    return settings;
  }
);

/**
 * 2) Вставляем в InspectorControl для каждого блока чекбокс "Скрыть блок".
 */
const withHideControl = createHigherOrderComponent( ( BlockEdit ) => {
  return ( props ) => {
    const { attributes, setAttributes, isSelected } = props;
    if ( typeof attributes.isHidden === 'undefined' ) {
      return <BlockEdit { ...props } />;
    }
    return (
      <Fragment>
        <InspectorControls>
          <PanelBody title="Отображение блока" initialOpen={ false }>
            <ToggleControl
              label="Скрыть блок в продакшене"
              checked={ attributes.isHidden }
              onChange={ ( val ) => setAttributes( { isHidden: val } ) }
            />
          </PanelBody>
        </InspectorControls>
        <BlockEdit { ...props } />
      </Fragment>
    );
  };
}, 'withHideControl' );

addFilter(
  'editor.BlockEdit',
  'biotropika/with-hide-control',
  withHideControl
);

/**
 * 3) Подменяем изображение на плейсхолдер, если у блока есть атрибут imageUrl (или previewUrl),
 *    и он пуст.
 */
const withPlaceholder = createHigherOrderComponent( ( BlockSave ) => {
  return ( props ) => {
    const { attributes } = props;
    // Список полей, где может быть картинка:
    const imgAttrs = [ 'imageUrl', 'previewUrl' ];
    imgAttrs.forEach( ( key ) => {
      if ( key in attributes && ! attributes[ key ] ) {
        attributes[ key ] = BiotropikaSettings.placeholderUrl;
      }
    } );
    return <BlockSave { ...props } />;
  };
}, 'withPlaceholder' );

addFilter(
  'blocks.getSaveElement',
  'biotropika/with-placeholder',
  withPlaceholder
);
