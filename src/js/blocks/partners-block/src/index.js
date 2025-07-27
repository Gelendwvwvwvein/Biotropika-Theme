import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Placeholder в редакторе
 */
registerBlockType('biotropika/partners-block', {
  edit() {
    const blockProps = useBlockProps();
    return (
      <div {...blockProps} style={{
        padding: '20px',
        border: '1px dashed #ccc',
        textAlign: 'center',
      }}>
        { 'Партнеры (динамический)' }
      </div>
    );
  },
  save() {
    // динамический — рендерим через PHP
    return null;
  },
});
