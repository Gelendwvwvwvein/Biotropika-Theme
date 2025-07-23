import { registerBlockType } from '@wordpress/blocks';
import Edit from './editor';
import '../style/editor.scss';

registerBlockType('biotropika/scroll-animation-block', {
  edit: Edit,
  save({ attributes }) {
    const { imageUrl } = attributes;
    if (!imageUrl) return null;
    return (
      <div className="biotropika-scroll-animation-block">
        <img src={imageUrl} alt="" className="scroll-animation-block__image" />
      </div>
    );
  },
});
