import { __ } from '@wordpress/i18n';
import {
  useBlockProps,
  InspectorControls,
} from '@wordpress/block-editor';
import {
  PanelBody,
  TextControl,
} from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
  const { text } = attributes;
  const blockProps = useBlockProps();

  return (
    <>
      <InspectorControls>
        <PanelBody
          title={ __('Настройки объёма фонда', 'biotropika') }
          initialOpen
        >
          <TextControl
            label={ __('Объём призового фонда', 'biotropika') }
            value={ text }
            onChange={ ( val ) => setAttributes({ text: val }) }
            placeholder={ __('Введите цифру или текст', 'biotropika') }
          />
        </PanelBody>
      </InspectorControls>
      <h2 {...blockProps}>
        { text || __('(объём не задан)', 'biotropika') }
      </h2>
    </>
  );
}
