import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

registerBlockType('biotropika/reviews-cards-block', {
  edit() {
    const blockProps = useBlockProps();
    return (
      <div {...blockProps} style={{
        padding: '20px',
        border: '1px dashed #ccc',
        textAlign: 'center',
      }}>
        { 'Блок «Карточки с отзывами» (динамический)' }
      </div>
    );
  },
  save() {
    // динамический рендер — фронтенд рендерит PHP
    return null;
  },
});
