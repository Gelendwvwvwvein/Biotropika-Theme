/**
 * src/js/blocks/highlight-text-block/src/editor.js
 */
import { __ } from '@wordpress/i18n';
import {
  useBlockProps,
  InspectorControls,
  RichText,
} from '@wordpress/block-editor';
import {
  PanelBody,
  TextControl,
} from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
  const {
    title,
    content,
    buttonText,
    buttonLink,
  } = attributes;

  const blockProps = useBlockProps();

  return (
    <>
      <InspectorControls>
        <PanelBody
          title={ __('Ссылка кнопки', 'biotropika') }
          initialOpen
        >
          <TextControl
            label={ __('URL кнопки', 'biotropika') }
            value={ buttonLink }
            onChange={ ( val ) => setAttributes({ buttonLink: val }) }
            placeholder={ __('https://...', 'biotropika') }
          />
        </PanelBody>
      </InspectorControls>

      <section {...blockProps} className="biotropika-highlight-text-block">
        {/* Заголовок */}
        <RichText
          tagName="h3"
          className="highlight-text__title"
          value={ title }
          onChange={ ( val ) => setAttributes({ title: val }) }
          placeholder={ __('Введите заголовок...', 'biotropika') }
          allowedFormats={ [] }
        />

        {/* Абзац с поддержкой ссылок */}
        <RichText
          tagName="p"
          className="highlight-text__content"
          value={ content }
          onChange={ ( val ) => setAttributes({ content: val }) }
          placeholder={ __('Введите текст и выделите ссылку...', 'biotropika') }
          formattingControls={ [ 'bold', 'italic', 'link' ] }
          allowedFormats={ [ 'core/bold', 'core/italic', 'core/link' ] }
        />

        {/* Текст кнопки */}
        <RichText
          tagName="div"
          className="highlight-text__button-edit"
          multiline={ false }
          value={ buttonText }
          onChange={ ( val ) => setAttributes({ buttonText: val }) }
          placeholder={ __('Текст кнопки', 'biotropika') }
          allowedFormats={ [] }
        />
      </section>
    </>
  );
}
