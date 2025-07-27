import { __ } from '@wordpress/i18n';
import {
  useBlockProps,
  InspectorControls,
} from '@wordpress/block-editor';
import {
  PanelBody,
  ToggleControl,
  RangeControl,
} from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
  const { showAll, newsCount } = attributes;
  const blockProps = useBlockProps();

  return (
    <>
      <InspectorControls>
        <PanelBody title={__('Настройки списка новостей','biotropika')} initialOpen>
          <ToggleControl
            label={__('Вывести все новости','biotropika')}
            checked={ showAll }
            onChange={ val => setAttributes({ showAll: val }) }
          />
          { !showAll && (
            <RangeControl
              label={__('Количество новостей','biotropika')}
              value={ newsCount }
              onChange={ val => setAttributes({ newsCount: val }) }
              min={1}
              max={20}
            />
          ) }
        </PanelBody>
      </InspectorControls>

      <div {...blockProps} className="biotropika-news-list-block">
        { showAll
          ? <p>{__('Будут выведены все новости','biotropika')}</p>
          : <p>{`${__('Будет выведено','biotropika')} ${newsCount} ${__('новостей','biotropika')}`}</p>
        }
      </div>
    </>
  );
}
